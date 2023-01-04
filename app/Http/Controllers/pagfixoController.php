<?php

namespace App\Http\Controllers;

use App\Models\pagfixo;
use Illuminate\Http\Request;



class pagfixoController extends Controller
{

    
    public function index(){
        $tabela = pagfixo::orderby('id', 'desc')->paginate();
        return view ('painel-admin.pagfixo.index', ['itens'=>$tabela]);
    }

    public function create(){
        return view('painel-admin.pagfixo.create');
    }
    
    public function insert(Request $request){
        $tabela = new pagfixo();
        $tabela->nome = $request->nome;
        $tabela->tipo = $request->tipo;
        $tabela->vencimento = $request->vencimento;
        $tabela->valor = $request->valor;
        $tabela->situacao = $request->situacao;
        $tabela->save();
        return redirect()->route('pagfixo.index');

    }

    
}
