@extends('layouts.base')

@section('body')
<div class="container py-5">
    <h1 class="mb-4">Orders</h1>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle']) !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush