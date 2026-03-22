<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                // HANDLE THE STATUS FILTER LOGIC
                if (request()->has('status') && request('status') != '') {
                    $query->where('status', request('status'));
                }
            })
            ->addColumn('customer', function ($row) {
                return $row->user ? $row->user->name : 'Guest';
            })
            ->addColumn('items', function ($row) {
                $html = '<ul class="list-unstyled mb-0" style="font-size: 0.85rem;">';
                foreach ($row->items as $item) {
                    $html .= '<li>' . ($item->product->name ?? 'Deleted Product') . ' (x' . $item->quantity . ')</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('total', function ($row) {
                return '₱' . number_format($row->total, 2);
            })
            ->addColumn('status', function ($row) {
                $class = match($row->status) {
                    'pending' => 'bg-warning',
                    'processing' => 'bg-info',
                    'shipped' => 'bg-primary',
                    'delivered' => 'bg-success',
                    'cancelled' => 'bg-danger',
                    default => 'bg-secondary'
                };
                return '<span class="badge ' . $class . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('orders.show', $row->id) . '" class="btn btn-sm btn-outline-dark">View Details</a>';
            })
            ->setRowId('id')
            ->rawColumns(['items', 'status', 'action']);
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with(['user', 'items.product']);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', 'data.status = $("#status-filter").val();') // SEND STATUS TO SERVER
            ->orderBy(0, 'desc')
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['export', 'print', 'reset', 'reload'],
                // INJECT THE DROPDOWN INTO THE DATATABLE HEADER
                'initComplete' => "function () {
                    var select = $('<select id=\"status-filter\" class=\"form-select form-select-sm d-inline-block w-auto ms-2\"><option value=\"\">All Status</option><option value=\"pending\">Pending</option><option value=\"processing\">Processing</option><option value=\"shipped\">Shipped</option><option value=\"delivered\">Delivered</option><option value=\"cancelled\">Cancelled</option></select>')
                        .appendTo('#orders-table_filter')
                        .on('change', function () {
                            window.LaravelDataTables['orders-table'].draw();
                        });
                }",
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->title('Order #'),
            Column::make('customer')->title('Customer'),
            Column::make('total')->title('Total Amount'),
            Column::make('status')->title('Status'),
            Column::make('items')->title('Products Ordered')->exportable(false)->printable(false),
            Column::computed('action')->title('Action')->addClass('text-center'),
        ];
    }
}