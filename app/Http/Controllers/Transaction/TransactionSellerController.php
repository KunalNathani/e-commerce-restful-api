<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(["index"]);
    }

    public function index(Transaction $transaction): JsonResponse
    {
        $seller = $transaction->product->seller;
        return $this->showOne($seller);
    }
}
