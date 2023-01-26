<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryProductsController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(['index']);
    }

    public function index(Category $category): JsonResponse
    {
        $products = $category->products;
        return $this->showAll($products);
    }
}
