@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0" style="color:#001f3f; letter-spacing:1px; font-weight:600;">
            <i class="fa fa-box" style="color:#d4af37;"></i> PRODUCTS
        </h1>
        <a href="{{ route('products.create') }}" 
           class="btn px-4" 
           style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
            <i class="fa fa-plus"></i> ADD PRODUCT
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table align-middle shadow-sm']) !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush