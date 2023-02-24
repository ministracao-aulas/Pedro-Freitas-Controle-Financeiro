@extends('layouts.sb-admin-2.app')
@section('title', 'Contas')
@inject('billModel', 'App\Models\Bill')

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
                            <tr
                                data-bill-row-id="{{ $bill->id }}"
                                data-bill-row-data="{{ json_encode($bill) }}"
                            >
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
                                    <x-sb-amin-menu.blocks.action-button
                                        icon-class="text-info"
                                        icon="edit"
                                        title="Editar conta #{{ $bill->id }}"
                                        actionObjectContainer="bill_actions"
                                        actionName="editBill"
                                        actionEventName="editBill"
                                        actionInfoType="integer"
                                        actionInfo="{{ $bill->id }}"
                                    >
                                    </x-sb-amin-menu.blocks.action-button>

                                    <x-sb-amin-menu.blocks.action-button
                                        icon-class="text-danger"
                                        icon="trash"
                                        title="Excluir conta #{{ $bill->id }}"
                                        actionObjectContainer="bill_actions"
                                        actionName="deleteBill"
                                        actionEventName="deleteBill"
                                        actionInfoType="integer"
                                        actionInfo="{{ $bill->id }}"
                                    >
                                    </x-sb-amin-menu.blocks.action-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    <!-- Modals -->
    <div class="modal fade" id="deleteBillModal" tabindex="-1" aria-labelledby="deleteBillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

    {{-- TODO --}}
    <div class="modal fade" id="editBillModal" tabindex="-1" aria-labelledby="editBillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
    <!-- END of Modals -->

    <script>
        window.bill_actions = {
            deleteBill: (billId) => {
                let modalBillIdInput = document.querySelector('#deleteBillModal input[name="bill_id"]')
                let deleteModalMessage = document.querySelector('#deleteBillModal [data-modal-message]')

                if (!modalBillIdInput) {
                    return;
                }

                if (deleteModalMessage) {
                    deleteModalMessage.innerHTML = `Deseja realmente excluir o item <strong>${billId}</strong>?`
                }

                modalBillIdInput.value = billId

                jQuery('#deleteBillModal').modal('show');

                $('#deleteBillModal').on('hidden.bs.modal', function (event) {
                    modalBillIdInput.value = ''

                    if (deleteModalMessage) {
                        deleteModalMessage.innerHTML = ''
                    }
                })
            },
            editBill: (billId) => {
                if (!billId) {
                    console.log('Error: Invalid billId', billId)
                    return
                }

                let row = document.querySelector(`[data-bill-row-id="${billId}"]`)

                if (!row) {
                    console.log('Error: Invalid row', row)
                    return
                }

                let modalBillIdInput = document.querySelector('#editBillModal input[name="bill_id"]')
                let modalMessage = document.querySelector('#editBillModal [data-modal-message]')

                if (!modalBillIdInput) {
                    return;
                }

                modalBillIdInput.value = billId

                let rowData = (() => {
                    try {
                        return JSON.parse(row.dataset.billRowData)
                    } catch (error) {
                        console.error(error)
                        return null
                    }
                })()

                if (!rowData) {
                    console.log('Error: invalid rowData', rowData)
                    return
                }

                let inputsAndKeys = [
                    {
                        selector: 'select[name="status"]',
                        key: 'status',
                    },
                    {
                        selector: 'select[name="type"]',
                        key: 'type',
                    },
                    {
                        selector: 'input[name="title"]',
                        key: 'title',
                    },
                    {
                        selector: 'input[name="overdue_date"]',
                        key: 'overdue_date',
                        formater: (input, value, rowData) => {
                            try {
                                return (new Date(value)).toISOString().slice(0, 10)
                            } catch (error) {
                                console.error('Error on overdue_date', error, 'value:', value)
                                return value
                            }
                        }
                    },
                    {
                        selector: 'input[name="value"]',
                        key: 'value',
                        formater: (input, value, rowData) => {
                            console.log(input, value)

                            return value
                        }
                    },
                    {
                        selector: 'input[name="creditor_id"]',
                        key: 'creditor_id',
                    },
                    {
                        selector: 'input[data-null-name="creditor_name"]',
                        key: 'creditor',
                        formater: (input, value, rowData) => {
                            if (!window.DotObject || !window.DotObject.get) {
                                return
                            }

                            return DotObject.get('name', value)
                        }
                    },
                    {
                        selector: 'textarea[name="note"]',
                        key: 'note',
                    },
                ]

                let fillInputs = (clear = false) => {
                    inputsAndKeys.forEach(inputInfo => {
                        if (!inputInfo || !inputInfo.selector) {
                            return
                        }

                        let input = document.querySelector(inputInfo.selector)

                        if (!input) {
                            return
                        }

                        let isEmptyValue = (clear || !inputInfo.key)

                        let formater = inputInfo.formater

                        let valueToSet = isEmptyValue ? '' : rowData[inputInfo.key]

                        if (!isEmptyValue && formater) {
                            valueToSet = formater(input, valueToSet, rowData)
                        }

                        input.value =  valueToSet

                        input.dispatchEvent(
                            new Event("change")
                        )
                    })
                }

                fillInputs(true)

                jQuery('#editBillModal').on('show.bs.modal', function (event) {
                    modalBillIdInput.value = billId
                    fillInputs()

                    if (modalMessage) {
                        modalMessage.innerHTML = `Editando item <strong>#${billId}</strong>`
                    }
                })

                jQuery('#editBillModal').on('hidden.bs.modal', function (event) {
                    modalBillIdInput.value = ''
                    fillInputs(true)

                    if (modalMessage) {
                        modalMessage.innerHTML = ''
                    }
                })

                jQuery('#editBillModal').modal('show');
            },
        }
    </script>
    <script>
        window.addEventListener('load', (event) => {
            @if ($deleteId ?? null)
                window.bill_actions.deleteBill({{$deleteId}})
            @endif
        });
    </script>
@endsection
