<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Login;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Verificar se o usuário e senha são válidos
        $registro = Login::where('usuario', $username)->where('senha', $password)->first();

        if ($registro) {
            // Autenticação bem-sucedida, armazenar informações na sessão
            Session::put('username', $registro->usuario);
            return $next($request);
        } else {
            // Autenticação falhou, redirecionar para a página de login
            return redirect()->route('loginView')->withErrors(['message' => 'Login incorreto']);
        }
    }
}
