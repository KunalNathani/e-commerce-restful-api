<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerSellersController extends ApiController
{
    public function index(Buyer $buyer): JsonResponse
    {
        $sellers = $buyer->transactions()
                        ->with('product.seller')
                        ->get()
                        ->pluck('product.seller')
                        ->unique();
        return $this->showAll($sellers);
    }
}
