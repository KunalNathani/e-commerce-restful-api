<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductTransactionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(["index"]);
    }

    public function index(Product $product): JsonResponse
    {
        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }
}
