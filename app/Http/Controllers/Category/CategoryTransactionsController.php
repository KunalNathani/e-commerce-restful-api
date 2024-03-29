<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryTransactionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(['index']);
    }
    
    public function index(Category $category): JsonResponse
    {
        $transactions = $category->products()
                                ->whereHas('transactions')
                                ->with('transactions')
                                ->get()
                                ->pluck('transactions')
                                ->flatten();
        return $this->showAll($transactions);
    }
}
