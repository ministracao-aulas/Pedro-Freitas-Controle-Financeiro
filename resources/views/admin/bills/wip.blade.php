@extends('layouts.sb-admin-2.app')
@section('title', 'WIP Page')
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
            <h1>WIP Page</h1>
        <x-tiago-f2.flatpickr />
            {{ $bills->count() }}

            <x-tiago-f2.filter-by-date-range
                :dateRange="$dateRange"
                :startDate="$startDate"
                :endDate="$endDate"
                :defaultRange="$dateRangeMode"
            />
        </div>
    </div>
@endsection
