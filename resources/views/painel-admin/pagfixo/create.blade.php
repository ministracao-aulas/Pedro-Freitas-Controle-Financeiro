@extends('template.painel-admin')

@section('title', 'Pagamentos')

@section('content')
    <h6 class="mb-4"><i>CADASTRO DE PAGAMENTOS</i></h6>
    <hr>
    <form
        method="POST"
        action="{{ route('contas.store') }}"
    >
        @csrf

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input
                        type="text"
                        class="form-control"
                        id=""
                        name="nome"
                        required
                    >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tipo</label>
                    <input
                        type="tipo"
                        class="form-control"
                        id=""
                        name="tipo"
                    >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Vencimento</label>
                    <input
                        type="date"
                        class="form-control"
                        id="vencimento"
                        name="vencimento"
                    >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Valor</label>
                    <input
                        type="text"
                        class="form-control"
                        id=""
                        name="valor"
                    >
                </div>
            </div>


            <div class="col-md-8">
                <div class="form-group">
                    <label for="exampleInputEmail1">Situação</label>
                    <input
                        type="text"
                        class="form-control"
                        id="situacao"
                        name="situacao"
                    >
                </div>
            </div>

        </div>



        <p align="right">
            <button
                type="submit"
                class="btn btn-secondary"
            >Salvar</button>
        </p>
    </form>



@endsection
