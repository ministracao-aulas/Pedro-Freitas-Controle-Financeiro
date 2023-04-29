@extends('layouts.sb-admin-2.app')
@section('title', 'Contas')
@inject('billModel', 'App\Models\Bill')

@section('before_head_end')
    @vite(['resources/views/admin/bills/assets/js/scripts.js', 'resources/views/admin/bills/assets/css/styles.css'])
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
            class="mt-4 mb-4 mx-2 btn btn-md btn-primary bg-custom-gradient-01">
            Cadastrar conta
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <style>
                    .show-label-on-hover .hover-label {
                        display: none;
                    }

                    .show-label-on-hover:hover .hover-label {
                        display: initial;
                    }
                </style>
                <table
                    class="table table-bordered _scrollTable"
                    id="dataTable"
                    _width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="100%" data-filter-type="container">
                                <div class="row">
                                    <div class="col-12 col-sm-12 d-flex d-flex justify-content-end">
                                        <div class="col-md-3 col-sm-12 d-flex justify-content-end">
                                            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Export">
                                                <div class="btn-group me-2" role="group" aria-label="Export group">
                                                    <div
                                                        type="div"
                                                        class="btn btn-outline-secondary input-group-text disabled"
                                                        disabled
                                                        readonly
                                                    >
                                                        @lang('Export')
                                                    </div>

                                                    <a href="#bills-export-xlsx={{ $filterParams }}" class="btn btn-outline-success show-label-on-hover d-flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                            class="bi bi-filetype-xlsx mt-1" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM7.86 14.841a1.13 1.13 0 0 0 .401.823c.13.108.29.192.479.252.19.061.411.091.665.091.338 0 .624-.053.858-.158.237-.105.416-.252.54-.44a1.17 1.17 0 0 0 .187-.656c0-.224-.045-.41-.135-.56a1.002 1.002 0 0 0-.375-.357 2.028 2.028 0 0 0-.565-.21l-.621-.144a.97.97 0 0 1-.405-.176.37.37 0 0 1-.143-.299c0-.156.061-.284.184-.384.125-.101.296-.152.513-.152.143 0 .266.023.37.068a.624.624 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.093 1.093 0 0 0-.199-.566 1.21 1.21 0 0 0-.5-.41 1.813 1.813 0 0 0-.78-.152c-.293 0-.552.05-.777.15-.224.099-.4.24-.527.421-.127.182-.19.395-.19.639 0 .201.04.376.123.524.082.149.199.27.351.367.153.095.332.167.54.213l.618.144c.207.049.36.113.462.193a.387.387 0 0 1 .153.326.512.512 0 0 1-.085.29.558.558 0 0 1-.255.193c-.111.047-.25.07-.413.07-.117 0-.224-.013-.32-.04a.837.837 0 0 1-.249-.115.578.578 0 0 1-.255-.384h-.764Zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036l.823-1.438Zm1.923 3.325h1.697v.674H5.266v-3.999h.791v3.325Zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036l.823-1.438Z" />
                                                        </svg>
                                                        <span class="hover-label mx-1">Excel</span>
                                                    </a>

                                                    <a href="#bills-export-csv" class="btn btn-outline-secondary show-label-on-hover d-flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                            class="bi bi-filetype-csv mt-1" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM3.517 14.841a1.13 1.13 0 0 0 .401.823c.13.108.289.192.478.252.19.061.411.091.665.091.338 0 .624-.053.859-.158.236-.105.416-.252.539-.44.125-.189.187-.408.187-.656 0-.224-.045-.41-.134-.56a1.001 1.001 0 0 0-.375-.357 2.027 2.027 0 0 0-.566-.21l-.621-.144a.97.97 0 0 1-.404-.176.37.37 0 0 1-.144-.299c0-.156.062-.284.185-.384.125-.101.296-.152.512-.152.143 0 .266.023.37.068a.624.624 0 0 1 .246.181.56.56 0 0 1 .12.258h.75a1.092 1.092 0 0 0-.2-.566 1.21 1.21 0 0 0-.5-.41 1.813 1.813 0 0 0-.78-.152c-.293 0-.551.05-.776.15-.225.099-.4.24-.527.421-.127.182-.19.395-.19.639 0 .201.04.376.122.524.082.149.2.27.352.367.152.095.332.167.539.213l.618.144c.207.049.361.113.463.193a.387.387 0 0 1 .152.326.505.505 0 0 1-.085.29.559.559 0 0 1-.255.193c-.111.047-.249.07-.413.07-.117 0-.223-.013-.32-.04a.838.838 0 0 1-.248-.115.578.578 0 0 1-.255-.384h-.765ZM.806 13.693c0-.248.034-.46.102-.633a.868.868 0 0 1 .302-.399.814.814 0 0 1 .475-.137c.15 0 .283.032.398.097a.7.7 0 0 1 .272.26.85.85 0 0 1 .12.381h.765v-.072a1.33 1.33 0 0 0-.466-.964 1.441 1.441 0 0 0-.489-.272 1.838 1.838 0 0 0-.606-.097c-.356 0-.66.074-.911.223-.25.148-.44.359-.572.632-.13.274-.196.6-.196.979v.498c0 .379.064.704.193.976.131.271.322.48.572.626.25.145.554.217.914.217.293 0 .554-.055.785-.164.23-.11.414-.26.55-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.764a.799.799 0 0 1-.118.363.7.7 0 0 1-.272.25.874.874 0 0 1-.401.087.845.845 0 0 1-.478-.132.833.833 0 0 1-.299-.392 1.699 1.699 0 0 1-.102-.627v-.495Zm8.239 2.238h-.953l-1.338-3.999h.917l.896 3.138h.038l.888-3.138h.879l-1.327 4Z">
                                                            </path>
                                                        </svg>
                                                        <span class="hover-label mx-1">CSV</span>
                                                    </a>

                                                    <a href="#bills-export-pdf" class="btn btn-outline-danger show-label-on-hover d-flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                            class="bi bi-filetype-pdf mt-1" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z" />
                                                        </svg>
                                                        <span class="hover-label mx-1">PDF</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="input-group my-2">
                                            <input
                                                type="search"
                                                name="search"
                                                value="{{ $search ?? '' }}"
                                                class="form-control"
                                                placeholder="@lang('Search')"
                                                aria-label="@lang('Search')"
                                                aria-describedby="search-input-thead"
                                                data-filter-refresh-on="key:Enter">
                                            <div class="input-group-append">
                                                <button
                                                    class="btn btn-sm btn-primary input-group-text"
                                                    id="search-input-thead"
                                                    type="button"
                                                    data-filter-refresh-on="click">
                                                    <i
                                                        class="fa fa-search fa-sm cursor-pointer"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($paginationValues ?? [])
                                        <div class="col-md-2 col-sm-6 pt-2">
                                            <select
                                                name="per_page"
                                                id="per_page_tfoot"
                                                class="form-control"
                                                data-filter-refresh-on="change">
                                                @foreach ($paginationValues as $paginationValue)
                                                    <option
                                                        value="{{ $paginationValue }}"
                                                        {{ ($perPage ?? null) == $paginationValue ? 'selected' : '' }}>
                                                        {{ $paginationValue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="col-md-2 col-sm-6 pt-2">
                                        <div class="form-group">
                                            <select
                                                class="form-control form-select"
                                                name="filter_by[status]"
                                                data-filter-refresh-on="change">
                                                <option
                                                    value=""
                                                    {{ !request('filter_by.status') ? 'selected' : '' }}>
                                                    @lang('Filter by status')
                                                </option>
                                                <option
                                                    value="opened"
                                                    {{ request('filter_by.status') == 'opened' ? 'selected' : '' }}>
                                                    @lang('enums.status.opened')
                                                </option>
                                                <option
                                                    value="paid"
                                                    {{ request('filter_by.status') == 'paid' ? 'selected' : '' }}>
                                                    @lang('enums.status.paid')
                                                </option>
                                                <option
                                                    value="postponed"
                                                    {{ request('filter_by.status') == 'postponed' ? 'selected' : '' }}>
                                                    @lang('enums.status.postponed')
                                                </option>
                                                <option
                                                    value="other"
                                                    {{ request('filter_by.status') == 'other' ? 'selected' : '' }}>
                                                    @lang('enums.status.other')
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-6 pt-2">
                                        <div class="form-group">
                                            <input
                                                type="date"
                                                name="filter_by[date_start]"
                                                class="form-control"
                                                value="{{ date('Y-m-01') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-6 pt-2">
                                        <div class="form-group">
                                            <input
                                                type="date"
                                                name="filter_by[date_end]"
                                                class="form-control"
                                                value="{{ date('Y-m-t') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-1 col-sm-12 mt-2 py-0 align-items-stretch d-grid gap-2">
                                        <button
                                            class="btn btn-sm btn-primary input-group-text d-block w-100"
                                            id="search-input-thead2"
                                            type="button"
                                            data-filter-refresh-on="click"
                                            data-filter-bypass="true">
                                            <i
                                                class="fa fa-search fa-sm cursor-pointer"></i>
                                        </button>
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
                                data-bill-row-data="{{ json_encode($bill) }}">
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

                                    @if ($bill->overdue_date && !$bill->overdue && $bill->overdue_date->diffInDays() <= 5)
                                        <i
                                            class="fa fa-info-circle fa-lg text-warning cursor-pointer"
                                            aria-hidden="true"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{ trans_choice('Due in :count days', $bill->overdue_date->diffInDays()) }}">
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
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
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
                                                actionInfo="{{ $bill->id }}">
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
                                                actionInfo="{{ $bill->id }}">
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
                                        required>
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
                                        required>
                                        <option value="">@lang('Select a status')</option>
                                        <option
                                            value="{{ $billModel::STATUS_OPENED }}"
                                            {{ old('status') == $billModel::STATUS_OPENED ? 'selected' : '' }}>
                                            @lang('enums.status.opened')
                                        </option>
                                        <option
                                            value="{{ $billModel::STATUS_PAID }}"
                                            {{ old('status') == $billModel::STATUS_PAID ? 'selected' : '' }}>
                                            @lang('enums.status.paid')
                                        </option>
                                        <option
                                            value="{{ $billModel::STATUS_POSTPONED }}"
                                            {{ old('status') == $billModel::STATUS_POSTPONED ? 'selected' : '' }}>
                                            @lang('enums.status.postponed')
                                        </option>
                                        <option
                                            value="{{ $billModel::STATUS_OTHER }}"
                                            {{ old('status') == $billModel::STATUS_OTHER ? 'selected' : '' }}>
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
                                        required>
                                        <option value="">@lang('Select a type')</option>
                                        <option
                                            value="{{ $billModel::TYPE_FIXED }}"
                                            {{ old('type') == $billModel::TYPE_FIXED ? 'selected' : '' }}>
                                            @lang('enums.type.fixed')
                                        </option>
                                        <option
                                            value="{{ $billModel::TYPE_VARIABLE }}"
                                            {{ old('type') == $billModel::TYPE_VARIABLE ? 'selected' : '' }}>
                                            @lang('enums.type.variable')
                                        </option>
                                        <option
                                            value="{{ $billModel::TYPE_SEPARATE }}"
                                            {{ old('type') == $billModel::TYPE_SEPARATE ? 'selected' : '' }}>
                                            @lang('enums.type.separate')
                                        </option>
                                        <option
                                            value="{{ $billModel::TYPE_OTHER }}"
                                            {{ old('type') == $billModel::TYPE_OTHER ? 'selected' : '' }}>
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
                                        placeholder="@lang('Overdue date')">
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
                                        placeholder="@lang('Bill value')">
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
                                        placeholder="@lang('Creditor id')">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            data-null-name="creditor_name"
                                            placeholder="@lang('Creditor')"
                                            id="creditor_id"
                                            readonly>
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
                                        placeholder="@lang('Your note was here')">{{ old('note') }}</textarea>
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
                                data-action-info="">
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
                                data-action-info="">
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
            window.deleteId = '{{ $deleteId }}'
        </script>
    @endif
@endsection
