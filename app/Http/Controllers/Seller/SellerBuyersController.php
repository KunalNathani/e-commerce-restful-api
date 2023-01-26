<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerBuyersController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(["index"]);
    }

    public function index(Seller $seller): JsonResponse
    {
        $buyers = $seller->products()
                        ->whereHas('transactions')
                        ->with('transactions.buyer')
                        ->get()
                        ->pluck('transactions')
                        ->flatten()
                        ->pluck('buyer')
                        ->unique()
                        ->values();
        return $this->showAll($buyers);
    }
}
