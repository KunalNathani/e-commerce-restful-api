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
        $this->middleware("auth:api")->only(["index"]);
        // $this->middleware("can:view,seller")->only(["index"]);
    }

    public function index(Seller $seller): JsonResponse
    {
        $this->authorize("view", $seller);
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
