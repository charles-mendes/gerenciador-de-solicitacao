<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
use App\Status;
use App\HistoricoSolicitacao;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\DetalheFornecedorProduto;
use App\Servico;
use App\Fornecedor;
use App\Usuario;
use App\Justificativa;
use App\Detalhe_Solicitacao_Produto;
use App\Detalhe_Solicitacao_Servico;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;
//use Request;
use Auth;
//use Input;
use Illuminate\Http\Request;


//TROCAR VARIAVEL DA TABELA SOLICITACAO PARA ENUM('A','P','I');

class SolicitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }

    public function nova(){
        $url_previous = explode('/',url()->previous());
        $previous = end($url_previous);  

        //verificando se session não existe ou se venho da tela solicitação
        if(!session()->has('novaSolicitacao') || $previous == 'solicitacao'){
            session(['novaSolicitacao' => new \stdClass() ]);
        }
        $solicitacao = session('novaSolicitacao');
        
        return view('solicitacao.solicitacao',['solicitacao' => $solicitacao ,'status' => 'criando']);
    }
    
    //listar Solicitações
    public function listar(){
        //usuario tipo 'S', sistema faz filtro mostrando apenas solicitações que ele criar
        if(Auth::user()->tipo_conta == 'S'){
            $solicitacoes = Solicitacao::where('id_criador',Auth::user()->id)->get();
        }else if(Auth::user()->tipo_conta == 'A'){
            //so pode mostrar solicitações que estão pendentes e que foram aprovadas e reprovados pelo Aprovador
            $status_pendente = $this->pegaStatus('Pendente');
            $status_aprovador_aprovado = $this->pegaStatus('Aprovado pelo Aprovador');
            $status_aprovador_reprovado = $this->pegaStatus('Reprovado pelo Aprovador');
            
            $solicitacoes = Solicitacao::where('id_status',$status_pendente->id)
            ->orwhere('id_status',$status_aprovador_aprovado->id)
            ->orwhere('id_status',$status_aprovador_reprovado->id)->get();
        }else if(Auth::user()->tipo_conta == 'AD' ||  Auth::user()->tipo_conta == 'C'){
            $solicitacoes = Solicitacao::all();
        }else if(Auth::user()->tipo_conta == 'D'){
            dd('Não foi feito configurações para esse tipo de conta');
        }else{
            dd('Não foi feito configurações para esse tipo de conta');
            //Criar erros
        }
        
        //mandar para tela listar solicitações
        return view('solicitacao.listar', ['solicitacoes'=> $solicitacoes]);

    }

    // private function verificaVisualizacao($id){
    //     // id é o id da solicitação
    //     $tipo_conta = Auth::user()->tipo_conta;

    //     if($tipo_conta == 'S'){
    //         //tem que verificar se a solicitação é a que o usuario criou
    //         $solicitacao = Solicitacao::find($id);
    //         if($solicitacao->id_criador == Auth::user()->id){
    //             return true;
    //         }
    //     }else if($tipo_conta == 'C' || $tipo_conta == 'AD'){
    //         return true;
    //     }else if($tipo_conta == 'D'){
    //         return true;
    //     }else{
    //         return back()->withErrors('Tipo de conta não configurado.');
    //     }
    //     return false;
    // }

    
    public function detalhe($id){
        $id = (int) $id;
        if(is_numeric($id)){
            // dd($this->verificaVisualizacao($id));

            //pegando solicitacao
            $solicitacao = Solicitacao::find($id);
            if($solicitacao == null){
                return back()->withErrors('Solicitação não encontrada.');
            }

            //verificando se a aprovação da solicitação foi feita pelo usuario atual
            $ultimo_registro = HistoricoSolicitacao::where('id_solicitacao',$solicitacao->id)->where('id_usuario',Auth::user()->id)->get()->last();
            
            $aprovou = false;
            if(!($ultimo_registro == null) ){
                if($ultimo_registro->id_status == $this->pegaStatus('Aprovado pelo Aprovador')->id){
                    $aprovou = true;
                }
            }

            return view('solicitacao.detalhe',['solicitacao'=> $solicitacao,'id'=> $id, 'aprovou' => $aprovou]);  
        }          
    }

    private function pegaStatus($status){
        if(isset($status)){
            $status = Status::where('tipo_status',$status)->get()->first();

            return $status;
        }
    }


    public function avalia_solicitacao($id){
        $id = (int) $id;
        if(is_numeric($id)){
            $solicitacao = Solicitacao::find($id);
            
            if($solicitacao == null){
                return back()->withErrors('Solicitação não encontrada.');
                //error perfeito ta voltando na tela
            }
            $usuario = Auth::user()->tipo_conta;

            if( !($usuario == 'A' || $usuario == 'C' || $usuario == 'D') ){
                return back()->withErrors('Não possui autorização.');
            }

            
            $status_atual_solicitacao =  Status::find($solicitacao->id_status);
            $tipo_status = $status_atual_solicitacao->tipo_status;

            $status = '';
            $justificativa = $this->pegaJustificativa($solicitacao); //pegando justificativas
            
    
            //1° situação -  a solicitação esta pendente
            //se ela esta pendente é para o usuario aprovar
            //quem pode aprovar : Aprovador e Comprador
            if($status_atual_solicitacao->tipo_status == 'Pendente'){
                $status = 'Pendente';
                return view('solicitacao.avalia.avalia_solicitacao',['solicitacao'=> $solicitacao,'id'=> $id,'status' => $status,'justificativa' => $justificativa]);    
            }

            //aqui é quando o aprovador já aprovou a solicitação
            //quando solicitação foi regeitada por aprovar mas ele quer re-ativar ela
            //2 ° aprovador que aprovou solicitação pode reprovar solicitação
            if($status_atual_solicitacao->tipo_status == 'Aprovado pelo Aprovador'){
                 //verificando se a aprovação da solicitação foi feita pelo usuario atual
                $ultimo_registro = HistoricoSolicitacao::where('id_solicitacao',$solicitacao->id)->get()->last();
                
                if(!($ultimo_registro == null) ){
                    //ele foi o cara que aprovou
                    if($ultimo_registro->id_status == $this->pegaStatus('Aprovado pelo Aprovador')->id && $ultimo_registro->id_usuario == Auth::user()->id ){
                        return view('solicitacao.avalia.reprova_solicitacao',['solicitacao'=> $solicitacao,'id'=> $id,'justificativa' => $justificativa]);
                    }else{
                        if($usuario == 'C'){
                            return view('solicitacao.avalia.reprova_solicitacao',['solicitacao'=> $solicitacao,'id'=> $id,'justificativa' => $justificativa]);
                        }else if($usuario == 'A'){
                            return redirect()->route('listar_solicitacao')->withErrors('Você não tem permissão para reprovar esta solicitação, pois não foi você quem a criou.');
                        }
                    }
                    
                }else{
                    //cai aqui quando não foi o usuario que não fez a ultima justificativa
                
                    //se caso for o comprador libera para realizar reprovação
                    if($usuario == 'C'){
                        return view('solicitacao.avalia.reprova_solicitacao',['solicitacao'=> $solicitacao,'id'=> $id,'justificativa' => $justificativa]);
                    }else if($usuario == 'A'){
                        return redirect()->route('listar_solicitacao')->withErrors('Você não tem permissão para reprovar esta solicitação, pois não foi você quem a criou.');
                    }
                }
                  
            }

            //Quando comprador quer ativar solicitação que esta reprovada
            if( $usuario == 'C' && $tipo_status == 'Reprovado pelo Aprovador'){
                $status = 'Reprovado pelo Aprovador';
                //manda para uma pagina onde usuario possa trocar status atual da solicitação
                return view('solicitacao.avalia.ativa_solicitacao',[
                    'solicitacao'=> $solicitacao,
                    'id'=> $id, 'status' => $status, 
                    'justificativa' => $justificativa,
                    // 'total' => $total,
                    // 'falta_preencher' => $falta_preencher
                ]);   
            }

            //Pegando quando é reprovado
            if( ( $usuario == 'A' && $tipo_status == 'Reprovado pelo Aprovador') ||
            ($usuario == 'C' && $tipo_status == 'Reprovado pelo Comprador') ||
            ($usuario == 'AD' && $tipo_status == 'Reprovado pelo Administrador')||
            ($usuario == 'D' && $tipo_status == 'Reprovado pela Diretoria')){
                //manda para uma pagina onde usuario possa trocar status atual da solicitação
                return view('solicitacao.avalia.ativa_solicitacao',[
                    'solicitacao'=> $solicitacao,
                    'id'=> $id, 'status' => $status, 
                    'justificativa' => $justificativa,
                    // 'total' => $total,
                    // 'falta_preencher' => $falta_preencher
                ]);   

                //return back()->withErrors('Esta solicitação já foi aprovada por um usúario do mesmo perfil do que o seu.');
            }
            
            //Verificando se solicitação ja foi aprovada pelo mesmo tipo de usuario
            if( ($usuario == 'A' && $tipo_status == 'Aprovado pelo Aprovador') ||
                ($usuario == 'C' && $tipo_status == 'Aprovado pelo Comprador') ||
                ($usuario == 'AD' && $tipo_status == 'Aprovado pelo Administrador') ||
                ($usuario == 'D' && $tipo_status == 'Aprovado pela Diretoria')){
                    return back()->withErrors('Esta solicitação já foi aprovada por um usúario do mesmo perfil do que o seu.');
            }

            //3° Comprador quer finalizar solicitação
            if($status_atual_solicitacao->tipo_status == 'Iniciou Cotação' && Auth::user()->tipo_conta == 'C'){
                $status = 'Iniciou Cotação';

                $falta_preencher = false;
                $total = 0;
                $array_soma = $this->somaValorSolicitacao($solicitacao);
                $falta_preencher = $array_soma['falta_preencher'];
                $total = $array_soma['total'];

                return view('solicitacao.avalia.finaliza_cotacao',[
                    'solicitacao'=> $solicitacao,
                    'id'=> $id, 'status' => $status, 
                    'justificativa' => $justificativa,
                    'total' => $total,
                    'falta_preencher' => $falta_preencher
                ]);   
            }


            //4°Quando comprador finalizaou sua cotacao
            if($status_atual_solicitacao->tipo_status == 'Em processo de execução'){
                $status = 'Em processo de execução';

                return view('solicitacao.avalia.finaliza_solicitacao',[
                    'solicitacao'=> $solicitacao,
                    'id'=> $id, 'status' => $status, 
                    'justificativa' => $justificativa,
                    // 'total' => $total,
                    // 'falta_preencher' => $falta_preencher
                ]);  
            }

            //5° Quando solicitação foi finalizada 
            if($status_atual_solicitacao->tipo_status == 'Finalizada'){
                $status = 'Finalizada';


                return view('solicitacao.avalia.finalizada',[
                    'solicitacao'=> $solicitacao,
                    'id'=> $id, 'status' => $status, 
                    'justificativa' => $justificativa,
                    // 'total' => $total,
                    // 'falta_preencher' => $falta_preencher
                ]);  
            }


            

            
      
        }
        return back()->withErrors('Não foi encontrado configurações adequadas.');
    }

    private function pegaJustificativa($solicitacao){
        $status_atual_solicitacao =  Status::find($solicitacao->id_status);

        //caso haja justificativa pegar a ultima que seria a mais valida
        $status_reprovado_aprovador = $this->pegaStatus('Reprovado pelo Aprovador');
            $status_reprovado_adm = $this->pegaStatus('Reprovado pelo Administrador');
            $status_reprovado_comprador = $this->pegaStatus('Reprovado pelo Comprador');
            $status_reprovado_diretoria = $this->pegaStatus('Reprovado pela Diretoria');

            $ids_reprovados = [
                $status_reprovado_aprovador->id,
                $status_reprovado_adm->id,
                $status_reprovado_comprador->id,
                $status_reprovado_diretoria->id,
            ];

            //pegar a ultima justificativa
            if(in_array($status_atual_solicitacao->id, $ids_reprovados )){
                $justificativas = $solicitacao->justificativas;
                if($justificativas->first() !== null){
                    $data_atual = new \stdClass;
                    $data_atual->data = new Carbon('2001-01-01 11:53:20');
                    $data_atual->id = "";
                    foreach($justificativas as $justificativa){
                        if($data_atual->data < $justificativa->data_modificacao){
                            $data_atual->data = $justificativa->data_modificacao;
                            $data_atual->id = $justificativa->id;
                        }
                    }
                    $justificativa = Justificativa::find($data_atual->id);
                }else{
                    $justificativa = null;
                }
            }else{
                $justificativa = null;
            }
        return $justificativa;
    }

    private function somaValorSolicitacao($solicitacao){
        //soma valor da solicitação 
        $total = null;
        $falta_preencher = false;
        
        if($solicitacao->produtos->first() == null && $solicitacao->servicos->first() == null){
            $falta_preencher = true;
        }else{
            
            if($solicitacao->produtos->first() !== null){
                
                foreach($solicitacao->produtos as $produto){
                    if(is_numeric($produto->valor)){
                        $total += $produto->valor;
                    }else{
                        $falta_preencher = true;
                        break;
                    }
                }
            }

            if($solicitacao->servicos->first() !== null){
                // dd('entrei');
                if($falta_preencher == false){
                    foreach($solicitacao->servicos as $servico){
                        if(is_numeric($servico->valor)){
                            $total += $servico->valor;
                        }else{
                            $falta_preencher = true;
                            break;
                        }
                    }
                }
            }     
            
        } 
        return array('falta_preencher' => $falta_preencher,'total' => $total);
    }

    public function cadastrar_ativacao(Request $request){
        $this->validate($request,[
            'id_solicitacao'=>'required',
            // 'justificativa'=>'required',
        ]);

        $solicitacao = Solicitacao::find($request->input('id_solicitacao'));
        if($solicitacao == null){
            return back()->withErrors('Solicitação não encontrada.');
        }

        //novo status
        //ela vai retornar para o estado inicial de pendente
        $status = $this->pegaStatus('Pendente');

        $solicitacao->id_status = $status->id;
        $message = '';
        if($solicitacao->save()){
            $message = "Status da Solicitação (".$solicitacao->descricao.") alterado com sucesso!, status alterado para : ".$status->tipo_status;
        }else{
            return back()->withErrors('Status da solicitacação não alterado.');
        }

        //enviando que foi aprovado
        $this->setHistorico($solicitacao);

        return redirect()->route('listar_solicitacao')->with('success', $message);
    }

    public function mostrar_verificacao_diretoria($id){

        //verifica se a solicitacao existe
        $id = (int) $id;
    
        if($id !== null){
            $solicitacao = Solicitacao::find($id);
            if($solicitacao == null){
                return back()->withErrors('Solicitação não encontrada.');
            }
            return view('solicitacao.modal.verifica_email_diretoria',['solicitacao'=> $solicitacao, 'id' => $id]);    
        }
        return back();
    }

    public function enviar_email_diretoria(Request $request){
        $this->validate($request,[
            'id_solicitacao'=>'required|numeric',
            'email'=>'required|email',
        ]);

        $usuario = Usuario::where('email',$request->input('email'))->get()->first();
        
        if($usuario == null){
            $usuario = new Usuario();
            $usuario->email = $request->input('email');
            $nome = explode('@',$request->input('email'));
            $usuario->nome = $nome[0];
            $usuario->senha = Hash::make('mudar12345');
            $usuario->situacao = 'A';
            $usuario->id_criador = Auth::user()->id;
            $usuario->data_criacao = time();
            $usuario->id_modificador = Auth::user()->id;
            $usuario->data_modificacao = time();
            $usuario->tipo_conta = 'D';
            $usuario->save();
        }

        //envia email para diretoria, para esperar por alteração no status da solicitação 
        $mailController = new MailController();
        $mailController->enviarEmailDiretoria($request->input('id_solicitacao'),$usuario);

        
        $solicitacao = Solicitacao::find($request->input('id_solicitacao'));
        if($solicitacao == null){
            return back()->withErrors('Solicitação não encontrada.');
        }
        
        //muda status para aprovado
        $status = $this->pegaStatus('Aprovado pelo Comprador');
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        $this->setHistorico($solicitacao);

        //muda status para esperando diretoria
        $status = $this->pegaStatus('Esperando Aprovação da diretoria');
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        $this->setHistorico($solicitacao);

        return redirect()->route('listar_solicitacao');

    }


    public function mostra_verificacao_falta_preencher($id){
        $id = (int) $id;
        if(is_numeric($id)){
            $solicitacao = Solicitacao::find($id);
            if($solicitacao == null){
                return back()->withErrors('Solicitação não encontrada.');
            }
            $usuario = Auth::user()->tipo_conta;
            if($usuario == 'AD' || $usuario == 'A' || $usuario == 'C' || $usuario == 'D'){
                return view('solicitacao.modal.falta_preencher',['solicitacao'=> $solicitacao,'id'=> $id]);       
            }
            return back();
        }
    }
    

    public function cadastrar_aprovacao(Request $request){
        $this->validate($request,[
            'id_solicitacao'=>'required',
        ]);

        $solicitacao = Solicitacao::find($request->input('id_solicitacao'));
        if($solicitacao == null){
            return back()->withErrors('Solicitação não encontrada.');
        }

        //contar valores da solicitação
        
        
        //pegando status
        $tipo_conta = Auth::user()->tipo_conta;

        if($tipo_conta == 'D'){
            $status = $this->pegaStatus('Aprovado pela Diretoria');
        }else if($tipo_conta == 'A'){
            $status = $this->pegaStatus('Aprovado pelo Aprovador');
        }else if($tipo_conta == 'C'){
            //tenho que gravar no historico que foi aprovado pelo comprador e que inicio cotação
            $status = $this->pegaStatus('Aprovado pelo Comprador');
            if($status == null){
                return back()->withErrors('Status não encontrado.');
            }
            $solicitacao->id_status = $status->id;
            $solicitacao->save();
            
            //enviando que foi aprovado
            $this->setHistorico($solicitacao);

            $status = $this->pegaStatus('Iniciou Cotação');

        }else if($tipo_conta == 'AD'){
            $status = $this->pegaStatus('Aprovado pelo Administrador');
        }
    
        if($status == null){
            return back()->withErrors('Status não encontrado.');
        }
        
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        //enviando que foi aprovado
        $this->setHistorico($solicitacao);
        
        $message = '';
        if($solicitacao->save()){
            $message = "Status da Solicitação (".$solicitacao->descricao.") alterado com sucesso!, status alterado para : ".$status->tipo_status;
        }else{
            return back()->withErrors('Status da solicitacação não alterado.');
        }

        return redirect()->route('listar_solicitacao')->with('success', $message);
    }

    public function justificativa($id){
        $id = (int) $id;
        if(is_numeric($id)){
            $solicitacao = Solicitacao::find($id);
            if($solicitacao == null){
                return back()->withErrors('Solicitação não encontrada.');
            }
            $usuario = Auth::user()->tipo_conta;
            if($usuario == 'AD' || $usuario == 'A' || $usuario == 'C' || $usuario == 'M'){
                return view('solicitacao.modal.justificativa',['solicitacao'=> $solicitacao,'id'=> $id]);       
            }
            return back();
        }
    }

    public function cadastrar_justificativa(Request $request){
        $this->validate($request,[
            'id_solicitacao'=>'required',
            'justificativa'=>'required',
        ]);

        //pegando status
        $tipo_conta = Auth::user()->tipo_conta;
        if($tipo_conta == 'D'){
            $status = $this->pegaStatus('Reprovado pela Diretoria');
        }else if($tipo_conta == 'A'){
            $status = $this->pegaStatus('Reprovado pelo Aprovador');
        }else if($tipo_conta == 'C'){
            $status = $this->pegaStatus('Reprovado pelo Comprador');
        }else if($tipo_conta == 'AD'){
            $status = $this->pegaStatus('Reprovado pelo Administrador');
        }

        if($status == null){
            return back();
        }

        //adicionando status na solicitação
        $solicitacao = Solicitacao::find($request->input('id_solicitacao'));
        if($solicitacao == null){
            return back()->withErrors('Solicitação não encontrada.');
        }
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        //cadastra no histirico
        $this->setHistorico($solicitacao);

        //salva justificativa        
        $justificativa = new Justificativa();
        $justificativa->id_solicitacao = $solicitacao->id;
        $justificativa->justificativa = $request->input('justificativa');
        $justificativa->id_criador = Auth::user()->id;
        $justificativa->data_criacao = time();
        $justificativa->save();
        
        return redirect()->route('listar_solicitacao');
    }

    public function mostrar_verificacao_cotacao($id){
        //verifica se a solicitacao existe
        $id = (int) $id;
    
        if($id !== null){
            $solicitacao = Solicitacao::find($id);
            if($solicitacao == null){
                return back()->withErrors('Solicitação não encontrada.');
            }
            return view('solicitacao.modal.verifica_cotacao',['solicitacao'=> $solicitacao]);    
        }
        return back();
    }

    public function finaliza_cotacao(Request $request){
        $this->validate($request,[
            'id_solicitacao'=>'required',
            // 'justificativa'=>'required',
        ]);
        //altera status da solicitacao
        $status = $this->pegaStatus('Finalizou Cotação');

        //adicionando status na solicitação
        $solicitacao = Solicitacao::find($request->input('id_solicitacao'));
        if($solicitacao == null){
            return back()->withErrors('Solicitação não encontrada.');
        }
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        //salva historico
        $this->setHistorico($solicitacao);

        //altera status da solicitacao
        $status = $this->pegaStatus('Em processo de execução');

        //adicionando outro status na solicitação
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        //cadastra no histirico
        $this->setHistorico($solicitacao);

        return redirect()->route('listar_solicitacao');

    }


    public function finaliza_solicitacao($id){
        $id = (int) $id;
        if(!is_numeric($id)){
            return back();
        }
        
        //altera status da solicitacao
        $status = $this->pegaStatus('Finalizada');

        //adicionando status na solicitação
        $solicitacao = Solicitacao::find($id);
        if($solicitacao == null){
            return back()->withErrors('Solicitação não encontrada.');
        }
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        //salva historico
        $this->setHistorico($solicitacao);

        return redirect()->route('listar_solicitacao');
    }



    private function setHistorico($solicitacao){
        //salvando historico da solicitação
        $historico = new HistoricoSolicitacao();
        $historico->id_solicitacao = $solicitacao->id;
        $historico->id_status = $solicitacao->id_status;
        $historico->id_usuario = Auth::user()->id;
        $historico->data_modificacao = time();
        $historico->save();
    }


    public function cadastrar_solicitacao(Request $request){
        $this->validate($request,[
            'descricao'=>'required',
        ]);

        
        //cria uma solicitacao
        $solicitacao = new Solicitacao();
        //pegar status de pendente
        $status = $this->pegaStatus('Pendente');
        $solicitacao->id_status = $status->id;
        $solicitacao->descricao = $request->input('descricao');
        $solicitacao->id_criador = Auth::user()->id;
        $solicitacao->data_criacao = time();
        $solicitacao->id_modificador = Auth::user()->id;
        $solicitacao->data_modificacao = time();
        $solicitacao->save();

        //salvando historico da solicitação
        $this->setHistorico($solicitacao);
        
        //pegando solicitacao da session
        $solicitacaoSession = session('novaSolicitacao');
        
        //verificar se produto ou servico esta preenchido na solicitação 
        if(isset($solicitacaoSession->produtos) || isset($solicitacaoSession->servicos)){
            if(isset($solicitacaoSession->produtos)){                
                foreach ($solicitacaoSession->produtos as $item) {
                    //criado produto para enviar
                    $produto = new \stdClass;
                    $produto->nome = $item->nome;
                    $produto->quantidade = $item->quantidade;
                    $produto->valor = $item->valor;
                    $produto->descricao = $item->descricao;
                    $produto->id_criador = $item->id_criador;
                    $produto->data_criacao = $item->data_criacao;
                    $produto->id_modificador = $item->id_modificador;
                    $produto->data_modificacao = $item->data_modificacao;

                    //salva produto
                    $produtoController = new ProdutoController();
                    $produto = $produtoController->cadastrar_produto($produto);
                    
                    //salva registro na tabela auxiliar
                    $solicitacao_produto = new Detalhe_Solicitacao_Produto();
                    $solicitacao_produto->id_solicitacao = $solicitacao->id;
                    $solicitacao_produto->id_produto = $produto->id;
                    $solicitacao_produto->save();
                }
            }
            
            if(isset($solicitacaoSession->servicos)){
                foreach($solicitacaoSession->servicos as $item){
                    //criado produto para enviar
                    $servico = new \stdClass;
                    $servico->nome = $item->nome;
                    $servico->valor = $item->valor;
                    $servico->descricao = $item->descricao;
                    $servico->id_criador = $item->id_criador;
                    $servico->data_criacao = $item->data_criacao;
                    $servico->id_modificador = $item->id_modificador;
                    $servico->data_modificacao = $item->data_modificacao;

                    $servicoController = new ServicoController();
                    $servico = $servicoController->cadastrar_servico($servico);

                    //salva registro na tabela auxiliar
                    $solicitacao_servico  = new Detalhe_Solicitacao_Servico();
                    $solicitacao_servico->id_solicitacao = $solicitacao->id;
                    $solicitacao_servico->id_servico = $servico->id;
                    $solicitacao_servico->save();
                }
            }    
                
            //envia email após criar solicitação 
            //Para tipo A e tipo C
            $mailController = new MailController();
            $mailController->solicitacaoPendente($solicitacao->id);
        }


        return redirect()->route('listar_solicitacao');
    }


    public function editar_solicitacao($id,Request $request){
        $id = (int) $id;
        if(is_numeric($id)){

            $solicitacao = Solicitacao::find($id);
            if($solicitacao == null){
                return redirect()->route('listar_solicitacao')->withErrors('Solicitação não encontrada.');
            }

            //verifica se o usuario tipo solicitante tem permissão para editar essa soliciitação
            if(Auth::user()->tipo_conta == "S"){
                $solicitacoes = Solicitacao::where('id_criador',Auth::user()->id)->get();
                $verify = false;
                foreach($solicitacoes as $soli){
                    if($soli->id == $id){
                        $verify = true;
                    }
                }
                if(!($verify)){
                    return redirect()->route('listar_solicitacao')->withErrors('Você não tem permissão para editar esta solicitação.');
                }
            }

            //pegando a url da onde o usuario venho 

            //se usuario vem de solicitaçao
            $url = explode('/',$request->path());

            $url_previous = explode('/',url()->previous());
            $previous = end($url_previous);
            // dd($previous);
            //verifica se na url do usuario tem solicitação e se ele venho da tela solicitacao
            //verifica se na url do usuario tem solicitação e se ele venho da tela avalia
            // dd($url[0] == 'solicitacao');
            if( ($url[0] == 'solicitacao' && $previous == 'solicitacao') || ($url[0] == 'solicitacao' && $url_previous[count($url_previous)-2] == 'avalia') ){
                $solicitacao = Solicitacao::find($id);
                if($solicitacao == null){
                    return back()->withErrors('Solicitação não encontrada.');
                }
                
                session(['novaSolicitacao' => $solicitacao ]);
            }

            //caso ele não entre no if de cima, ele fica com a sessão anterior 

            return view('solicitacao.solicitacao',['status' => 'editando' ,'id_solicitacao' => $id]);
        }
        return back();
    }


    public function salvar_solicitacao(Request $request){
        // dd($request->input());
        $this->validate($request,[
            // 'id_solicitacao'=>'required',
            'descricao' => 'required',
        ]);

        if(session()->has('novaSolicitacao')){
            $solicitacao = session('novaSolicitacao');
            // dd($solicitacao);
            //pega solicitação do banco
            $bdSolicitacao = Solicitacao::find($solicitacao->id);
            $bdSolicitacao->descricao = $request->input('descricao');
            $bdSolicitacao->id_modificador = Auth::user()->id;
            $bdSolicitacao->data_modificacao = time();
            $bdSolicitacao->save();
            
            //salvando alterações no produto

            // dd($solicitacao->produtos);
            // dd('');
            if(isset($solicitacao->produtos)){
                foreach($solicitacao->produtos as $produto){
                    if(isset($produto->id) && is_numeric($produto->id)){
                        //salvando alteração em objeto
                        $produto->save();
                    }else{
                        //salva produto
                        $produtoController = new ProdutoController();
                        $produto = $produtoController->cadastrar_produto($produto);
                        
                        //salva registro na tabela auxiliar
                        $solicitacao_produto = new Detalhe_Solicitacao_Produto();
                        $solicitacao_produto->id_solicitacao = $solicitacao->id;
                        $solicitacao_produto->id_produto = $produto->id;
                        $solicitacao_produto->save();
                    }
                }
            }    
            if(isset($solicitacao->servicos)){
                //salvando alterações no servico
                foreach($solicitacao->servicos as $servico){
                    if(isset($servico->id) && is_numeric($servico->id)){
                        //salvando alteração em objeto
                        $servico->save();
                    }else{
                        $servicoController = new ServicoController();
                        $servico = $servicoController->cadastrar_servico($servico);

                        //salva registro na tabela auxiliar
                        $solicitacao_servico  = new Detalhe_Solicitacao_Servico();
                        $solicitacao_servico->id_solicitacao = $solicitacao->id;
                        $solicitacao_servico->id_servico = $servico->id;
                        $solicitacao_servico->save();
                    }
                }
            }

            //salvando alteração na descricao


            return redirect()->route('listar_solicitacao');
        }
    }


    public function mostrar_verificacao_solicitacao($id){
         //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        $id = (int) $id;
        
        if($id != null){
            $solicitacao = Solicitacao::find($id);
            if($solicitacao == null){
                return back()->withErrors('Solicitação não encontrada.');
            }
            return view('solicitacao.modal.verifica_solicitacao',['solicitacao'=> $solicitacao]);    
        }
        return back();
    }

    public function excluir_solicitacao(Request $request){
        $this->validate($request,[
            'id_solicitacao' => 'required|numeric',
        ]);

        $id_solicitacao = (int) request()->input('id_solicitacao');

        $solicitacao = Solicitacao::find($id_solicitacao);
        if($solicitacao == null){
            return back()->withErrors('Solicitação não encontrada.');
        }

        $status = $this->pegaStatus('Inativada');
        $solicitacao->id_status = $status->id;
        $solicitacao->save();

        //salvando historico da solicitação
        $this->setHistorico($solicitacao);


        return redirect()->route('listar_solicitacao');
    }


    public function mostrar_form_produto(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao        
        if(session()->has('novaSolicitacao')){
            $produto = new \stdClass;
            $produto->nome = "";
            $produto->quantidade = "";
            $produto->valor = "";
            // $produto->valor_imposto = "";
            $produto->descricao = "";
            // $produto->link_oferta = "";

            //habilita campos para colocar valor na solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            //pegando os produtos que tem fornecedores
            $fornecedores = Fornecedor::all();
            $produtos_fornecedor = [];
            foreach($fornecedores as $fornecedor){
                foreach($fornecedor->produtos as $prod){
                    $produtos_fornecedor[] = ['id'=> $prod->id,'nome'=> $prod->nome];
                }
            }
            

            return view('solicitacao.modal.produto',['produto' => $produto , 'produtos_fornecedor' => $produtos_fornecedor , 'habilitaCampo' => $habilitaCampo]);
        }
        return redirect()->route('nova_solicitacao');
    }

    public function pegaProduto(Request $request){
        $this->validate($request,[
            'produto' => 'required',
            // 'produto' => 'required',
        ]);
        $produto = Produto::where('nome',$request->input('produto'))->first()->get();
        $produto = $produto->first();
        // dd($produto->valor);
        if($produto !== null){
            return ['valor'=>$produto->valor,'descricao'=>$produto->descricao];
        }
        return 0;

    }

    private function redireciona_solicitacao(){
        //gerencia quando usuario esta criando uma nova solicitação ou quando ele esta editando uma nova solicitação
        $url_previous = explode('/',url()->previous());
        
        if(end($url_previous) == 'nova'){
            return route('nova_solicitacao');
        }else if(is_numeric(end($url_previous))){   
            $id = (int) end($url_previous);
            return route('editar_solicitacao',[$id]);
        }
        
    }

    public function cadastrar_produto(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required|min:1',
                //  'valor'=> 'required',
                'descricao'=>'required',
             ]);

        }else{
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required|min:1',
                'valor'=> 'required|min:1',
                'descricao'=>'required',
             ]);

        }
        
        // pegando a sessao novaSolicitacao e atribuindo a uma var local
        $solicitacao = session('novaSolicitacao');

        //criando produto que sera enviado para ser cadastrado
        $produto = new \stdClass;
        $produto->nome = $request->input('nome');
        $produto->quantidade = $request->input('quantidade');
        $produto->valor = $request->input('valor');
        $produto->descricao = $request->input('descricao');
        $produto->id_criador = Auth::user()->id;
        $produto->data_criacao = time();
        $produto->id_modificador = Auth::user()->id;
        $produto->data_modificacao = time();
        
        //adicionando o novo produto a variavel local solicitacao
        $solicitacao->produtos[]= $produto;

        session()->put('novaSolicitacao', $solicitacao);
    
        //redireciona solicitação
        return redirect($this->redireciona_solicitacao());
    }

    public function editar_produto($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $produto = new \stdClass;
            $produto->nome = session('novaSolicitacao')->produtos[$id]->nome;
            $produto->quantidade = session('novaSolicitacao')->produtos[$id]->quantidade;
            $produto->valor = session('novaSolicitacao')->produtos[$id]->valor;
            $produto->descricao = session('novaSolicitacao')->produtos[$id]->descricao;


            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.produto',['produto' => $produto ,'id'=> $id ,'habilitaCampo' => $habilitaCampo]);    
        }
        
        return back();
    }

    public function salvar_produto(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required',
                'descricao'=>'required',
                'id_produto' => 'required'
             ]);

        }else{
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required',
                'valor'=> 'required',                
                'descricao'=>'required',
                'id_produto' => 'required'
             ]);

        }

        //pegando o id do produto
        $id = $request->input('id_produto');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
    
        //alterar produto ja existente na session
        $solicitacao->produtos[$id]->nome = $request->input('nome');
        $solicitacao->produtos[$id]->quantidade = $request->input('quantidade');
        $solicitacao->produtos[$id]->valor = $request->input('valor');
        $solicitacao->produtos[$id]->descricao = $request->input('descricao');
        $solicitacao->produtos[$id]->id_criador = Auth::user()->id;
        $solicitacao->produtos[$id]->id_modificador = Auth::user()->id;
        
        // dd($solicitacao);
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        //redirecionando solicitação
        return redirect($this->redireciona_solicitacao());
    }

    public function mostrar_verificacao_produto($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $solicitacao = session('novaSolicitacao');
            //verifica se existe o vetor produtos e se o produto que foi escolhido existe no array de produtos cadastrados
            if($solicitacao->produtos !== [] && isset($solicitacao->produtos[$id]) ){
                return view('solicitacao.modal.verifica_produto',['id'=> $id]);    
            }
        }
        return back();
    }

    public function excluir_produto(Request $request){
        $this->validate($request,[
            'id_produto' => 'required',
        ]);
        $id_produto = (int) request()->input('id_produto');

        if(session()->has('novaSolicitacao')){
            $solicitacao = session('novaSolicitacao');
            if( isset($solicitacao->produtos) && isset($solicitacao->produtos[$id_produto])){
                // dd( isset($solicitacao->produtos[$id_produto]->id)? $solicitacao->produtos[$id_produto]->id : 0, $solicitacao->produtos);

                if(isset($solicitacao->produtos[$id_produto]->id)){
                    //deleta produto do  banco na hora que usuario esta editando solicitação
                    $produto = Produto::find($solicitacao->produtos[$id_produto]->id);
                    $produto->delete();

                    //detelar relação entre produto e solicitacao
                    $solicitacao_produto = Detalhe_Solicitacao_Produto::where('id_produto',$solicitacao->produtos[$id_produto]->id)->get()->first();
                    $solicitacao_produto->delete();
                
                }
                
                $produtos = $solicitacao->produtos;
                
                if(count($produtos) > 0){
                    //excluindo produto
                    unset($produtos[$id_produto]);
                    
                    //ordenando vetor depois da exclusão de um produto
                    // $produtos = array_values($produtos);
                }
                session('novaSolicitacao')->produtos = $produtos;
                
                //redirecionando solicitação
                return redirect($this->redireciona_solicitacao());
            }

        }
        return back();

    }


    public function mostrar_form_servico(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao        
        if(session()->has('novaSolicitacao')){
            $servico = new \stdClass;
            $servico->nome = "";
            $servico->valor = "";
            $servico->descricao = "";

            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.servico',['servico' => $servico , 'habilitaCampo' => $habilitaCampo]);
        }
        return back();
    }

    public function cadastrar_servico(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                'descricao'=>'required',
             ]);
        }else{
            $this->validate($request,[
                'nome' => 'required',
                 'valor'=> 'required',
                'descricao'=>'required',
             ]);

        }

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');


        //criando produto que sera enviado para ser cadastrado
        $servico = new \stdClass;
        $servico->nome = $request->input('nome');
        $servico->valor = $request->input('valor');
        $servico->descricao = $request->input('descricao');
        $servico->id_criador = Auth::user()->id;
        $servico->data_criacao = time();
        $servico->id_modificador = Auth::user()->id;
        $servico->data_modificacao = time();
        
        //adicionando o novo produto na sessao
        $solicitacao->servicos[]= $servico;

        session()->put('novaSolicitacao', $solicitacao);
        
        //redirecionando solicitação
        return redirect($this->redireciona_solicitacao());
    }


    public function editar_servico($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $servico = new \stdClass;
            $servico->nome = session('novaSolicitacao')->servicos[$id]->nome;
            $servico->valor = session('novaSolicitacao')->servicos[$id]->valor;
            $servico->descricao = session('novaSolicitacao')->servicos[$id]->descricao;

            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.servico',['servico' => $servico , 'tipo' => 'solicitacao','id' => $id , 'habilitaCampo' => $habilitaCampo]);    
        }
        return back();
    }


    public function salvar_servico(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                'descricao'=>'required',
                'id_servico' => 'required',
             ]);
        }else{
            $this->validate($request,[
                'nome' => 'required',
                 'valor'=> 'required',
                'descricao'=>'required',
                'id_servico' => 'required',
             ]);

        }
        
        //pegando o id do servico
        $id = $request->input('id_servico');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
        
        //alterar servico ja existente na session
        $solicitacao->servicos[$id]->nome = $request->input('nome');
        $solicitacao->servicos[$id]->valor = $request->input('valor');
        $solicitacao->servicos[$id]->descricao = $request->input('descricao');
        $solicitacao->servicos[$id]->id_criador = Auth::user()->id;
        $solicitacao->servicos[$id]->id_modificador = Auth::user()->id;
        
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        //redirecionando solicitação
        return redirect($this->redireciona_solicitacao());
    }

    //o que é verificacao
    public function mostrar_verificacao_servico($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id !== null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $solicitacao = session('novaSolicitacao');
            //verifica se existe o vetor produtos e se o produto que foi escolhido existe no array de produtos cadastrados
            if($solicitacao->servicos !== [] && isset($solicitacao->servicos[$id]) ){
                return view('solicitacao.modal.verifica_servico',['id'=> $id]);    
            }
        }
        return back();
    }

    public function excluir_servico(Request $request){
        $this->validate($request,[
            'id_servico' => 'required',
        ]);
        $id_servico = (int) request()->input('id_servico');

        if(session()->has('novaSolicitacao')){
            $solicitacao = session('novaSolicitacao');
            // tem que excluir no banco quando é objeto 

            if( isset($solicitacao->servicos) && isset($solicitacao->servicos[$id_servico])){
                //verifica se o servico ja esta cadastrado no banco, caso tiver deleta do banco 
                if(isset($solicitacao->servicos[$id_servico]->id)){
                    //deleta servico no banco
                    $servico = Servico::find($solicitacao->servicos[$id_servico]->id);
                    $servico->delete();

                    //detelar relação entre servico e solicitacao
                    $solicitacao_servico = Detalhe_Solicitacao_Servico::where('id_servico',$solicitacao->servicos[$id_servico]->id)->get()->first();
                    $solicitacao_servico->delete();
                }

                //para ajustar visualização de edição de solicitação
                $servicos = $solicitacao->servicos;
                // dd($servicos,$id_servico,count($servicos));
                if(count($servicos) > 0){
                    //excluindo servico
                    unset($servicos[$id_servico]);
                    //ordenando vetor depois da exclusão de um servico
                    // $servicos = array_values($servicos);
                }
                session('novaSolicitacao')->servicos = $servicos;
                
                //redirecionando solicitação
                return redirect($this->redireciona_solicitacao());

            }   
        }
        return back();

    }




}

