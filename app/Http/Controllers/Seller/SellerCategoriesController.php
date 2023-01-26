<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerCategoriesController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(["index"]);
    }

    public function index(Seller $seller): JsonResponse
    {
        $categories = $seller->products()
                            ->with('categories')
                            ->get()
                            ->pluck('categories')
                            ->unique()
                            ->flatten();
        return $this->showAll($categories);
    }
}
