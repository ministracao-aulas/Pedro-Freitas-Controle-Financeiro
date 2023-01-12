<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function editar(Request $request, User $user)
    {
        $user->nome = $request->nome;
        $user->cpf = $request->cpf;
        $user->user = $request->user; //NOCOMMIT
        $user->senha = $request->senha;
        $user->save();

        return redirect()->route('admin.dashboard');
    }
}
