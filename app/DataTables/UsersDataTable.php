<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function($row) {
                return $row->created_at ? $row->created_at->format('M d, Y h:i A') : '';
            })
            ->addColumn('action', function($row) {
                return '
                    <div class="d-flex border-0">
                        <a href="'.route('users.edit', $row->id).'" class="btn btn-sm btn-warning me-2">Edit</a>
                    </div>';
            })
            ->setRowId('id')
            ->rawColumns(['action']);
    }

    public function query(User $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('role'),
            Column::make('status'),
            Column::make('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
                  ->addClass('text-center'),
        ];
    }
}