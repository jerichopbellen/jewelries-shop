<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\ReviewsDataTable;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(ReviewsDataTable $dataTable)
    {
        return $dataTable->render('admin.reviews.index');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}