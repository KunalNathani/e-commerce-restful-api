<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category): JsonResponse
    {
        return $this->showOne($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:2'
        ];

        $this->validate($request, $rules);

        $category = Category::create($request->only(['name', 'description']));

        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $rules = [
            'name' => 'min:2|max:255',
            'description' => 'min:2'
        ];

        $this->validate($request, $rules);

        $category->fill($request->only(['name', 'description']));
        if($category->isClean()) {
            return $this->errorResponse('You need to update some field!', 422);
        }
        $category->save();
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return $this->showOne($category, 204);
    }
}
