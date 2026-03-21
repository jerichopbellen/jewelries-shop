@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Registered Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Yajra DataTables Scripts --}}
    {!! $dataTable->scripts() !!}
@endpush