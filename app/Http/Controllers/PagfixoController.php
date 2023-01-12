<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class PagfixoController extends Controller
{
    public function index()
    {
        $tabela = Bill::orderby('id', 'desc')->paginate();

        return view('painel-admin.Bill.index', ['itens' => $tabela]);
    }

    public function create()
    {
        return view('painel-admin.Bill.create');
    }

    public function insert(Request $request)
    {
        $tabela = new Bill();
        $tabela->nome = $request->nome;
        $tabela->tipo = $request->tipo;
        $tabela->vencimento = $request->vencimento;
        $tabela->valor = $request->valor;
        $tabela->situacao = $request->situacao;
        $tabela->save();

        return redirect()->route('Bill.index');
    }
}
