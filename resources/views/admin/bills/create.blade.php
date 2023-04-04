@extends('layouts.sb-admin-2.app')

@section('title', 'Contas')

@inject('billModel', 'App\Models\Bill')

@section('content')
    <h6 class="mb-4"><i>Cadastrar conta</i></h6>
    <hr>
    <form
        method="POST"
        action="{{ route('admin.contas.store') }}"
        class="container"
    >
        @csrf

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
                        value="{{ old('title') }}"
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
                        value="{{ old('status') }}"
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
                        value="{{ old('type') }}"
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
            <div class="col-md-4">
                <div class="form-group">
                    <label for="vencimento">
                        @lang('Overdue date')
                    </label>
                    <input
                        type="date"
                        class="form-control"
                        id="vencimento"
                        name="overdue_date"
                        value="{{ old('overdue_date') }}"
                        placeholder="@lang('Overdue date')"
                    >
                </div>
            </div>

            <div class="col-md-4">
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
                        value="{{ old('value') }}"
                        placeholder="@lang('Bill value')"
                    >
                </div>
            </div>

            <div class="col-md-4">
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
                        type="text"
                        class="form-control"
                        id="creditor_id"
                        name="creditor_id"
                        value="{{ old('creditor_id') }}"
                        placeholder="@lang('Creditor')"
                    >
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

        <p align="right">
            <button
                type="submit"
                class="btn btn-secondary">
                Salvar
            </button>
        </p>
    </form>

@endsection
