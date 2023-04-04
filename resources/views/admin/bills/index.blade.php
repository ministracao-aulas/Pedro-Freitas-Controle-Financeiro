@extends('layouts.sb-admin-2.app')
@section('title', 'Contas')
@inject('billModel', 'App\Models\Bill')

@section('before_head_end')

@vite([
    'resources/views/admin/bills/assets/js/scripts.js',
    'resources/views/admin/bills/assets/css/styles.css',
])
@endsection

@section('alpine_page_data')
<script>
    window.initialAlpineContentData = {}
</script>
@endsection

@section('content')
    <h6 class="mb-2"><i> LISTA DE PAGAMENTOS </i></h6>
    <hr>

    <div class="row d-flex align-items-center justify-content-end px-2">
        <a
            href="{{ route('admin.contas.create') }}"
            class="mt-4 mb-4 mx-2 btn btn-md btn-primary bg-custom-gradient-01"
        >
            Cadastrar conta
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table
                    class="table table-bordered _scrollTable"
                    id="dataTable"
                    _width="100%"
                    cellspacing="0"
                >
                    <thead>
                        <tr>
                            <th colspan="100%">
                                <div class="row" data-filter-type="container">
                                    <div class="col-auto">
                                        <div class="input-group my-2">
                                            <input
                                                type="search"
                                                name="search"
                                                value="{{ $search ?? '' }}"
                                                class="form-control"
                                                placeholder="Search"
                                                aria-label="Search"
                                                aria-describedby="search-input-thead"
                                                data-filter-refresh-on="key:Enter"
                                            >
                                            <div class="input-group-append">
                                                <button
                                                    class="btn btn-sm btn-primary input-group-text"
                                                    id="search-input-thead"
                                                    type="button"
                                                    data-filter-refresh-on="click"
                                                >
                                                    <i
                                                        class="fa fa-search fa-sm cursor-pointer"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($paginationValues ?? [])
                                    <div class="col-2 pt-2">
                                        <select
                                            name="per_page"
                                            id="per_page_tfoot"
                                            class="form-control"
                                            data-filter-refresh-on="change"
                                        >
                                        @foreach ($paginationValues as $paginationValue)
                                                <option
                                                    value="{{ $paginationValue }}"
                                                    {{ ($perPage ?? null) == $paginationValue ? 'selected' : '' }}
                                                >
                                                    {{ $paginationValue }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    <div class="col-2 pt-2">
                                        <button @click="toggle">Toggle Content</button>

                                        <div
                                            x-show="open"
                                            x-show="open"
                                            @click.outside="open = false"
                                        >
                                            Content...
                                        </div>
                                    </div>
                                </div>
                            </th>
                        </tr>
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
                            @php
                                $actionCaller = "
                                    data-action-type=\"trigger\"
                                    data-action-object-container=\"bill_actions\"
                                    data-action-name=\"showBill\"
                                    data-action-event-name=\"showBill\"
                                    data-action-info-type=\"integer\"
                                    data-action-info=\"{$bill->id}\"
                                ";
                            @endphp
                            <tr
                                data-bill-row-id="{{ $bill->id }}"
                                data-bill-row-data="{{ json_encode($bill) }}"
                            >
                                <td {!! $actionCaller !!}>{{ $bill->id }}</td>

                                <td {!! $actionCaller !!}>{{ $bill->title }}</td>
                                <td {!! $actionCaller !!}>
                                    <span
                                        class="badge badge-pill badge-{{ $bill->type_color }}">
                                        {{ $bill->type_name }}
                                    </span>
                                </td>
                                <td {!! $actionCaller !!}>
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
                                <td {!! $actionCaller !!}>
                                    @if ($bill->value)
                                        R$ {{ number_format($bill->value, 2, ',', '.') }}
                                    @endif
                                </td>
                                <td {!! $actionCaller !!}>
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
                                    <div class="btn-group d-block">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            @lang('Actions')
                                        </button>

                                        <div class="dropdown-menu">
                                            <x-sb-amin-menu.blocks.action-button
                                                class="dropdown-item d-flex align-items-center justify-content-between"
                                                icon-class="text-info"
                                                icon="edit"
                                                title="Editar conta #{{ $bill->id }}"
                                                actionObjectContainer="bill_actions"
                                                actionName="editBill"
                                                actionEventName="editBill"
                                                actionInfoType="integer"
                                                actionInfo="{{ $bill->id }}"
                                            >
                                                @lang('app-ref.bill.edit')
                                            </x-sb-amin-menu.blocks.action-button>

                                            <div class="dropdown-divider"></div>

                                            <x-sb-amin-menu.blocks.action-button
                                                class="dropdown-item d-flex align-items-center justify-content-between"
                                                icon-class="text-danger"
                                                icon="trash"
                                                title="Excluir conta #{{ $bill->id }}"
                                                actionObjectContainer="bill_actions"
                                                actionName="deleteBill"
                                                actionEventName="deleteBill"
                                                actionInfoType="integer"
                                                actionInfo="{{ $bill->id }}"
                                            >
                                                @lang('app-ref.bill.delete')
                                            </x-sb-amin-menu.blocks.action-button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Vencimento</th>
                            <th>Valor</th>
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                        <tr>
                            <td colspan="100%">
                                <div class="row">
                                    <div class="col-auto">
                                        {{ $bills->withQueryString()->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="deleteBillModal" tabindex="-1" aria-labelledby="deleteBillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBillModalLabel">Deletar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span data-modal-message=""></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form method="POST" action="{{ route('admin.contas.destroy') }}">
                        @csrf
                        <input type="hidden" name="bill_id" value="{{ $deleteId ?? null }}">
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBillModal" tabindex="-1" aria-labelledby="editBillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <form method="POST" action="{{ route('admin.contas.update') }}">
                @csrf
                <input type="hidden" name="bill_id" value="{{ $editId ?? null }}">
                @method('put')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBillModalLabel">Editar Registro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="w-100 mb-3">
                            <span data-modal-message="" class="text-center"></span>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">
                                        @lang('Title')
                                        <span class="text-small text-danger" title="@lang('Required')">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        placeholder="@lang('Bill name')"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">
                                        @lang('Status')
                                        <span class="text-small text-danger" title="@lang('Required')">*</span>
                                    </label>
                                    <select
                                        class="form-control form-select"
                                        name="status"
                                        id="status"
                                        required
                                    >
                                        <option value="">@lang('Select a status')</option>
                                        <option
                                            value="{{ $billModel::STATUS_OPENED }}"
                                            {{ old('status') == $billModel::STATUS_OPENED ? 'selected' : '' }}
                                        >
                                            @lang('enums.status.opened')
                                        </option>
                                        <option
                                            value="{{ $billModel::STATUS_PAID }}"
                                            {{ old('status') == $billModel::STATUS_PAID ? 'selected' : '' }}
                                        >
                                            @lang('enums.status.paid')
                                        </option>
                                        <option
                                            value="{{ $billModel::STATUS_POSTPONED }}"
                                            {{ old('status') == $billModel::STATUS_POSTPONED ? 'selected' : '' }}
                                        >
                                            @lang('enums.status.postponed')
                                        </option>
                                        <option
                                            value="{{ $billModel::STATUS_OTHER }}"
                                            {{ old('status') == $billModel::STATUS_OTHER ? 'selected' : '' }}
                                        >
                                            @lang('enums.status.other')
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">
                                        @lang('Type')
                                        <span class="text-small text-danger" title="@lang('Required')">*</span>
                                    </label>
                                    <select
                                        class="form-control form-select"
                                        name="type"
                                        id="type"
                                        required
                                    >
                                        <option value="">@lang('Select a type')</option>
                                        <option
                                            value="{{ $billModel::TYPE_FIXED }}"
                                            {{ old('type') == $billModel::TYPE_FIXED ? 'selected' : '' }}
                                        >
                                            @lang('enums.type.fixed')
                                        </option>
                                        <option
                                            value="{{ $billModel::TYPE_VARIABLE }}"
                                            {{ old('type') == $billModel::TYPE_VARIABLE ? 'selected' : '' }}
                                        >
                                            @lang('enums.type.variable')
                                        </option>
                                        <option
                                            value="{{ $billModel::TYPE_SEPARATE }}"
                                            {{ old('type') == $billModel::TYPE_SEPARATE ? 'selected' : '' }}
                                        >
                                            @lang('enums.type.separate')
                                        </option>
                                        <option
                                            value="{{ $billModel::TYPE_OTHER }}"
                                            {{ old('type') == $billModel::TYPE_OTHER ? 'selected' : '' }}
                                        >
                                            @lang('enums.type.other')
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vencimento">
                                        @lang('Overdue date')
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="vencimento"
                                        name="overdue_date"
                                        placeholder="@lang('Overdue date')"
                                    >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="value">
                                        Valor
                                        <small class="text-muted">
                                            <em>
                                                (@lang('Can changed later'))
                                            </em>
                                        </small>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="value"
                                        name="value"
                                        placeholder="@lang('Bill value')"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="creditor_id">
                                        @lang('Creditor')
                                        <small class="text-muted">
                                            <em>
                                                (@lang('Can changed later'))
                                            </em>
                                        </small>
                                    </label>
                                    <input
                                        type="hidden"
                                        class="form-control"
                                        name="creditor_id"
                                        placeholder="@lang('Creditor id')"
                                    >
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            data-null-name="creditor_name"
                                            placeholder="@lang('Creditor')"
                                            id="creditor_id"
                                            readonly
                                        >
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-sm p-0 m-0 px-2 pt-1 input-group-text">
                                                <i class="fas fa-search fa-md text-info pointer-events-none"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="note">
                                        @lang('Note')
                                        <small class="text-muted">
                                            <em>
                                                (@lang('Can changed later'))
                                            </em>
                                        </small>
                                    </label>
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        id="note"
                                        name="note"
                                        placeholder="@lang('Your note was here')"
                                    >{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DOING --}}
    <div class="modal fade" id="showBillModal" tabindex="-1" aria-labelledby="showBillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showBillModalLabel">Editar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100 mb-3">
                        <span data-modal-message="" class="text-center"></span>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.status')</strong>
                        </div>
                        <div class="col" data-show-name="status"></div>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.type')</strong>
                        </div>
                        <div class="col" data-show-name="type"></div>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.title')</strong>
                        </div>
                        <div class="col" data-show-name="title"></div>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.overdue_date')</strong>
                        </div>
                        <div class="col" data-show-name="overdue_date"></div>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.value')</strong>
                        </div>
                        <div class="col" data-show-name="value"></div>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.creditor_id')</strong>
                        </div>
                        <div class="col" data-show-name="creditor_id"></div>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.creditor_name')</strong>
                        </div>
                        <div class="col" data-show-name="creditor_name"></div>
                    </div>

                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-4">
                            <strong>@lang('app-ref.bill.note')</strong>
                        </div>
                        <div class="col" data-show-name="note"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100 row d-flex align-items-center justify-content-between mx-1">
                        <div class="col">
                            <x-sb-amin-menu.blocks.action-button
                                btnClass="dropdown-item"
                                icon-class="text-info"
                                icon="edit"
                                data-show-name="id"
                                actionObjectContainer="bill_actions"
                                actionName="editBill"
                                actionEventName="editBill"
                                actionInfoType="integer"
                                actionInfo="{{ $bill->id }}"
                            >
                                @lang('app-ref.bill.edit')
                            </x-sb-amin-menu.blocks.action-button>
                        </div>

                        <div class="col">
                            <x-sb-amin-menu.blocks.action-button
                                btnClass="dropdown-item"
                                icon-class="text-danger"
                                icon="trash"
                                data-show-name="id"
                                actionObjectContainer="bill_actions"
                                actionName="deleteBill"
                                actionEventName="deleteBill"
                                actionInfoType="integer"
                                actionInfo="{{ $bill->id }}"
                            >
                                @lang('app-ref.bill.delete')
                            </x-sb-amin-menu.blocks.action-button>
                        </div>
                        {{-- <div class="col"><button type="button" class="btn btn-info">Edit</button></div>
                        <div class="col"><button type="button" class="btn btn-danger">Delete</button></div> --}}
                        <div class="col"><button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END of Modals -->

    @if ($deleteId ?? null)
    <script>
        window.deleteId = '{{$deleteId}}'
    </script>
    @endif
@endsection
