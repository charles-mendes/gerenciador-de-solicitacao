<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSolicitacao;
use App\Usuario;
use App\Solicitacao;

class MailController extends Controller
{
    public function solicitacaoPendente($id){
        $id = (int) $id;
        if(isset($id) && is_numeric($id) ){
            //usuarios que irão receber email que foi criado uma nova solicitação
            $usuarios = Usuario::where('tipo_conta','A')->orwhere('tipo_conta','C')->get();
            $usuario = $usuarios[0];
            $solicitacao = Solicitacao::find($id);

            foreach ($usuarios as $usuario) {
                Mail::to($usuario->email)->send(new MailSolicitacao($solicitacao));    
            }
        }
        return back();
        
    }
}
