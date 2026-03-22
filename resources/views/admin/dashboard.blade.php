@extends('layouts.base')

@section('body')
<div class="container py-5">
    <h3 class="fw-bold mb-4" style="color:#001f3f; text-transform: uppercase; letter-spacing: 1px;">
        <i class="fa fa-chart-line" style="color:#d4af37;"></i> DASHBOARD ANALYTICS
    </h3>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3" style="background-color:#001f3f;">
                    <h6 class="m-0 font-weight-bold" style="color:#d4af37; text-transform: uppercase; font-size: 0.8rem;">YEARLY REVENUE TREND</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        {!! $yearlyChart->container() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3" style="background-color:#001f3f;">
                    <h6 class="m-0 font-weight-bold" style="color:#d4af37; text-transform: uppercase; font-size: 0.8rem;">TOP 10 PRODUCTS</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        {!! $productChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color:#001f3f;">
                    <h6 class="m-0 font-weight-bold" style="color:#d4af37; text-transform: uppercase; font-size: 0.8rem;">SALES PERFORMANCE</h6>
                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex align-items-center" id="dateFilterForm">
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                            <input type="text" id="date_range_picker" class="form-control form-control-sm border-0" style="width: 220px;" placeholder="Filter Date Range">
                        </form>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning text-white border-warning">Clear</a>
                    </div>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 350px;">
                        {!! $performanceChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $yearlyChart->script() !!}
    {!! $productChart->script() !!}
    {!! $performanceChart->script() !!}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date_range_picker", {
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    document.getElementById('start_date').value = instance.formatDate(selectedDates[0], "Y-m-d");
                    document.getElementById('end_date').value = instance.formatDate(selectedDates[1], "Y-m-d");
                    document.getElementById('dateFilterForm').submit();
                }
            }
        });
    </script>
@endpush