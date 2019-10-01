<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        if (!app('Illuminate\Contracts\Auth\Guard')->guest()) {
            if ($request->user()->userCan($permission)) {
                return $next($request);
            }
        }

        return $request->ajax ? response()->json(['message' => 'Não Autorizado!','status' => 403]) : redirect()->back()->with('mensagem_falha', 'Você não tem permissão para acessar esse conteúdo!');
    }
}
