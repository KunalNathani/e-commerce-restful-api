<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerCategoriesController extends ApiController
{
    public function index(Buyer $buyer): JsonResponse
    {
        $categories = $buyer->transactions()
                            ->with('product.categories')
                            ->get()
                            ->pluck('product.categories')
                            ->flatten()
                            ->unique();

        return $this->showAll($categories);
    }
}
