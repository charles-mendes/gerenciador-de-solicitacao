<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class BuildMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            //S = Solicitante | A = Aprovador | C = Comprador | AD = Administrador
            $tipo_conta = Auth::user()->tipo_conta;
            $menu = [];

            if( $tipo_conta == 'A'){
                $menu = [
                    'Dashboard'   => ['link'=> '/dashboard','icone'=> "mdi mdi-gauge"],
                    'Solicitacao' => ['link' => '/solicitacao','icone' =>  "mdi mdi-gauge",],
                ];

            }else if( $tipo_conta == 'AD' || $tipo_conta == 'C'){
                $menu = [
                'Dashboard'   => ['link'=> '/dashboard','icone'=> "mdi mdi-gauge"],
                'Solicitação' => ['link' => '/solicitacao','icone' =>  "mdi mdi-gauge"],
                'Usuarios'    => ['link'=>'/usuarios','icone'=>"mdi mdi-table"],
                'Fornecedor'  => ['link'=>'/fornecedor','icone'=>"mdi mdi-emoticon"],
                'Relatorios'  => ['link'=>'/relatorios','icone'=>"mdi mdi-earth"],
                ];
            }else{
                //Solicitante ou outros que não tem cadastro do tipo_conta
                $menu = [
                    'Dashboard'   => ['link'=> '/dashboard','icone'=> "mdi mdi-gauge"],
                    'Solicitacao' => ['link' => '/solicitacao','icone' =>  "mdi mdi-gauge",],
                ];
            }

            session(['menu' => $menu]);

        }
        // dd($menu);



        return $next($request);
    }
}
