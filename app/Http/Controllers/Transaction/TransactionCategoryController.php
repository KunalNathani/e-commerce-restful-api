<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class TransactionCategoryController extends ApiController
{
    public function index(Transaction $transaction): JsonResponse
    {
        $categories = $transaction->product->categories;
        return $this->showAll($categories);
    }
}
