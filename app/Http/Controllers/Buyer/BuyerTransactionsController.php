<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerTransactionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(["index"]);
    }

    public function index(Buyer $buyer): JsonResponse
    {
        $transactions = $buyer->transactions;
        return $this->showAll($transactions);
    }
}
