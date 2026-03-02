<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class ProductsDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('image', function ($product) {
                if ($product->images->first()) {
                    return '<img src="' . asset('storage/' . $product->images->first()->image_path) . '" 
                                alt="Product Image" 
                                class="img-thumbnail" 
                                style="max-width: 80px;">';
                }
                return '<span class="text-muted">No image</span>';
            })
            ->addColumn('action', function ($product) {
                return '
                    <a href="' . route('products.edit', $product->id) . '" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form action="' . route('products.destroy', $product->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete this product?\')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['image', 'action']); // allow HTML rendering
    }

    public function query(Product $model)
    {
        return $model->newQuery()->with('category', 'images');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons([
                'excel',
                'csv',
                'pdf',
                'print',
                'reset',
                'reload',
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('category.name')->title('Category'),
            Column::make('description'),
            Column::make('price'),
            Column::make('stock'),
            Column::computed('image')
                ->title('Image')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}