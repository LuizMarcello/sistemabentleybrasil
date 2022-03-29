<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all(['email', 'password']);

        /* Autenticação (email e senha) */
        /* Usando o helper "auth()" do laravel */
        /* Se a autenticação der certo, attempt() retornarà
           um token JWT (Json Web Token) */
        $token = auth('api')->attempt($credenciais);

        if ($token) { /* Usuário autenticado com sucesso. */
            return response()->json(['token' => $token]);
        } else { /* êrro de usuário ou senha */
            return response()->json(['erro' => 'Usuário ou senha inválido!'], 403);

            /* 401 = Unauthorized -> não autorizado. Pode
               ser então "logado", mas não "authorizado" */
            /* 403 = forbidden - > proibido (login inválido) */
        }

        //return 'login';
    }


    public function logout()
    {
        /* Para revogar/invalidar/colocar na blackList um token JWT,
           é preciso ter um token ainda válido. */
        /* Invalidando o token JWT */
        auth('api')->logout();
        return response()->json(['msg' => 'Logout realizado com sucesso!']);
    }



    public function refresh()
    {
        /* Renovação do token JWT(autorização) */
        /* Cliente tem que ter um token JWT(autorização) ainda válido */
        $token = auth('api')->refresh();
        /* Retornando um array */
        return response()->json(['token' => $token]);
    }


    public function me()
    {
        return response()->json(auth()->user());
    }
}
