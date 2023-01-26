<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellersController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(["index", "show"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sellers = Seller::all();
        return $this->showAll($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }
}
