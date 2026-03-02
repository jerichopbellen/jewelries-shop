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
            ->addColumn('customer', function ($row) {
                return $row->user->name;
            })
            ->addColumn('items', function ($row) {
                $html = '<ul class="list-unstyled mb-0">';
                foreach ($row->items as $item) {
                    $html .= '<li>' . $item->product->name . ' (x' . $item->quantity . ') - ₱' . number_format($item->price, 2) . '</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('total', function ($row) {
                // Use the accessor from Order model
                return '₱' . number_format($row->total, 2);
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex border-0">
                        <a href="' . route('orders.show', $row->id) . '" class="btn btn-sm btn-info me-2">View</a>
                        
                        <form action="' . route('orders.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>';
            })
            ->setRowId('id')
            ->rawColumns(['items', 'action']);
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
            ->minifiedAjax()
            ->orderBy(1);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('customer'),
            Column::make('total')->title('Total'),
            Column::make('status'),
            Column::make('items')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-start'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }
}