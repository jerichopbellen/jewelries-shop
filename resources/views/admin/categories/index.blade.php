@extends('layouts.base')

@section('body')
    <h1 class="mb-4">Categories</h1>

    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Category
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle']) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush