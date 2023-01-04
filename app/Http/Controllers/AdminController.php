<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view ('painel-admin.index');
    }

    public function editar(Request $request, usuario $usuarios){
        
        $usuarios->nome = $request->nome;
        $usuarios->cpf = $request->cpf;
        $usuarios->Usuarios = $request->Usuario;
        $usuarios->senha = $request->senha;
        $usuarios->save();
        return redirect()->route('admin.index');

    }
}
