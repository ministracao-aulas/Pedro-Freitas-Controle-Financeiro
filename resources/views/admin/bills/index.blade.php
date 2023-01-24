@extends('template.painel-admin')
@section('title', 'Contas')
@section('content')

    <h6 class="mb-2"><i> LISTA DE PAGAMENTOS </i></h6>
    <hr>

    <a
        href="{{ route('admin.contas.create') }}"
        class="mt-4 mb-4 btn btn-md btn-primary bg-custom-gradient-01"
    >
        Cadastrar conta
    </a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Vencimento</th>
                            <th>Valor</th>
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($bills as $bill)
                            <tr>
                                <td>{{ $bill->id }}</td>
                                <td>{{ $bill->title }}</td>
                                <td>
                                    <span
                                        class="badge badge-pill badge-{{ $bill->type_color }}">
                                        {{ $bill->type_name }}
                                    </span>
                                </td>
                                <td>
                                    @if ($bill->overdue_date)
                                        {{ $bill->overdue_date->format('d/m/Y') }}
                                    @endif

                                    @if ($bill->overdue)
                                        <i
                                            class="fa fa-info-circle fa-lg text-danger cursor-pointer"
                                            aria-hidden="true"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{ $bill->overdue_formated }}">
                                        </i>
                                    @endif

                                    @if (
                                        $bill->overdue_date &&
                                        !$bill->overdue &&
                                        $bill->overdue_date->diffInDays() <= 5
                                    )
                                        <i
                                            class="fa fa-info-circle fa-lg text-warning cursor-pointer"
                                            aria-hidden="true"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{
                                            trans_choice('Due in :count days', $bill->overdue_date->diffInDays())
                                            }}">
                                        </i>
                                    @endif
                                </td>
                                <td>
                                    @if ($bill->value)
                                        R$ {{ number_format($bill->value, 2, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge badge-pill badge-{{ $bill->status_color }}">
                                        {{ $bill->status_name }}
                                    </span>

                                    @if ($bill->overdue)
                                        <i
                                            class="fa fa-info-circle fa-sm text-danger cursor-pointer"
                                            aria-hidden="true"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{ $bill->overdue_formated }}">
                                        </i>
                                    @endif
                                </td>
                                <td>
                                    <a href="#edit">
                                        <i class="fas fa-edit text-info mr-1"></i>
                                    </a>
                                    <a href="#trash">
                                        <i class="fas fa-trash text-danger mr-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').dataTable({
                "ordering": false
            })

        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja Realmente Excluir este Registro?

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form method="POST" action=" ">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (@$id != '') {
        echo "<script>$('#exampleModal').modal('show');</script>";
    }
    ?>

@endsection