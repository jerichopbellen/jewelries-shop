@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family:'Montserrat','Segoe UI',sans-serif;">
    {{-- Flash messages for success/errors --}}

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color:#001f3f; letter-spacing:1px;">
            <i class="fa fa-gem" style="color:#d4af37;"></i> PRODUCTS
        </h3>
        <div class="d-flex gap-2">
            {{-- Import Button --}}
            <button type="button" class="btn px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal"
                style="background-color:transparent; color:#001f3f; border:2px solid #001f3f; font-weight:600; letter-spacing:0.5px;">
                <i class="fa fa-file-import me-1"></i> IMPORT EXCEL
            </button>

            {{-- Add Product Button --}}
            <a href="{{ route('products.create') }}" 
                class="btn px-4 shadow-sm" 
                style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                <i class="fa fa-plus"></i> ADD PRODUCT
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:8px; overflow:hidden;">
        <div class="card-header py-3" style="background-color:#001f3f; border:none;">
            <h6 class="m-0 font-weight-bold" style="color:#d4af37; letter-spacing:0.5px;">
                INVENTORY LIST
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

{{-- Import Modal --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px; border:none; overflow:hidden;">
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background-color:#001f3f; color:#d4af37; border-bottom: 2px solid #d4af37;">
                    <h5 class="modal-title fw-bold" id="importModalLabel">IMPORT PRODUCTS</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="file" class="form-label fw-bold text-muted small text-uppercase">Choose Excel File</label>
                        <input type="file" name="file" id="file" class="form-control" required 
                            accept=".xlsx, .xls, .csv" style="border-radius: 6px;">
                        <div class="form-text mt-2" style="font-size: 0.8rem;">
                            <i class="fa fa-info-circle me-1"></i> Required headers: <strong>name, category, description, price, stock</strong>.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 fw-600" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn px-4 shadow-sm" 
                        style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600;">
                        CONFIRM IMPORT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Yajra DataTables Scripts --}}
    {!! $dataTable->scripts() !!}
@endpush