@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family:'Montserrat','Segoe UI',sans-serif;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color:#001f3f; letter-spacing:1px;">
            <i class="fa fa-star" style="color:#d4af37;"></i> REVIEWS
        </h3>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:8px; overflow:hidden;">
        <div class="card-header py-3" style="background-color:#001f3f; border:none;">
            <h6 class="m-0 font-weight-bold" style="color:#d4af37; letter-spacing:0.5px;">
                REVIEW TRANSACTION HISTORY
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                {!! $dataTable->table([
                    'class' => 'table table-hover align-middle w-100',
                    'style' => 'border-collapse: separate; border-spacing: 0;'
                ]) !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush