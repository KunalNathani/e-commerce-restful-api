<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerProductsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(["index"]);
    }

    public function index(Buyer $buyer): JsonResponse
    {
        $products = $buyer->transactions()
                            ->with('product')
                            ->get()
                            ->pluck('product')
                            ->unique();
        return $this->showAll($products);
    }
}
