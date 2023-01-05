<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('painel-admin.index');
    }

    public function editar(Request $request, User $user)
    {

        $user->nome = $request->nome;
        $user->cpf = $request->cpf;
        $user->Usuarios = $request->Usuario;
        $user->senha = $request->senha;
        $user->save();
        return redirect()->route('admin.index');
    }
}
