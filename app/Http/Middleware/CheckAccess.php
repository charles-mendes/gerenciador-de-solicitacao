<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccess
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
        //pegando path da pagina
        $url = explode('/',$request->path());
        //rodando os menus que o usuario tem
        foreach(session('menu') as $menu){
            $m = str_replace("/", "", $menu['link']);
            //verificando se ele tem acesso a pagina
            if($m == $url[0]){
                return $next($request);
            }
        }
        //se não tiver redirecionando usuario para o dashboard com mensagem de erro
        return redirect()->route('listar_solicitacao')->with('error', 'Não tem permissão para acessar esta página.');
    }
}
