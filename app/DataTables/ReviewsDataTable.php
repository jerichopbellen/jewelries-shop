<?php

namespace App\DataTables;

use App\Models\Review;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class ReviewsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('customer', function($row) {
                return $row->user->name;
            })
            ->addColumn('product', function($row) {
                return $row->product->name;
            })
            ->editColumn('rating', function($row) {
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    $stars .= '<i class="' . ($i <= $row->rating ? 'fas' : 'far') . ' fa-star" style="color:#d4af37; font-size:0.8rem;"></i>';
                }
                return $stars;
            })
            ->editColumn('comment', function($row) {
                return Str::limit($row->comment, 70);
            })
            ->addColumn('action', function($row) {
                return '
                    <div class="d-flex border-0 justify-content-center">
                        <form action="'.route('admin.reviews.destroy', $row->id).'" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger px-3" style="background-color: #dc3545; border: none;">Delete</button>
                        </form>
                    </div>';
            })
            ->setRowId('id')
            ->rawColumns(['rating', 'action']);
    }

    public function query(Review $model)
    {
        return $model->newQuery()->with(['user', 'product']);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('reviews-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'desc')
            ->parameters([
                'dom' => '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->title('Id'),
            Column::computed('customer')->title('Customer'),
            Column::computed('product')->title('Product'),
            Column::make('rating')->title('Rating'),
            Column::make('comment')->title('Comment'),
            Column::computed('action')->title('Action')->addClass('text-center'),
        ];
    }
}