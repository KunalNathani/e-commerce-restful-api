<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ResponseHelper
{
    private function successResponse($responseParams, $statusCode = 200)
    {
        return response()->json($responseParams, $statusCode);
    }

    protected function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message, 'code' => $statusCode], $statusCode);
    }

    protected function showOne(Model $model, $statusCode = 200)
    {
        $transformer = $model->getTransformer();
        $model = $this->transformData($model, $transformer);
        $responseParams = ['data' => $model];
        return $this->successResponse($responseParams, $statusCode);
    }

    protected function showAll(Collection $collection, $statusCode = 200)
    {
        if($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $statusCode);
        }
        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sort($collection, $transformer);

        $total = $collection->count();

        $collection = $this->paginate($collection);

        $collection = $this->transformData($collection, $transformer);
        $responseParams = ['data' => $collection, 'count' => $collection->count()];
        return $this->successResponse($responseParams, $statusCode);
    }

    protected function showMessage(string $message, int $statusCode = 200)
    {
        $responseParams = ['data' => $message];
        return $this->successResponse($responseParams, $statusCode);
    }

    private function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);
        return collect($transformation->toArray()['data']); # Note: 'data' key is passed automatically by transformer.
    }

    private function sort(Collection $collection, $transformer): Collection
    {
        if(request()->has('sort_by')) {
            $transformedAttribute = request()->sort_by;
            $sortAttribute = $transformer::attributeMapper($transformedAttribute);
            if(request()->has('order_by') && request()->order_by == 'desc') {
                $collection = $collection->sortByDesc($sortAttribute);
            } else {
                $collection = $collection->sortBy($sortAttribute);
            }
        }
        return $collection;
    }

    private function filterData(Collection $collection, $transformer): Collection
    {
        foreach(request()->query() as $key => $value) {
            $actualAttribute = $transformer::attributeMapper($key);
            if(isset($actualAttribute, $value)) {
                $collection = $collection->where($actualAttribute, $value);
            }
        }
        return $collection;
    }

    private function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:10|max:100'
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $elementsPerPage = 10; # Default Page Size is 15

        # Update elements per page if there is query string present!
        if(request()->has('per_page')) {
            $elementsPerPage = (int)request()->per_page;
        }
        $results = $collection->slice($elementsPerPage*($page-1), $elementsPerPage)->values();

        $options = [
            'page' => LengthAwarePaginator::resolveCurrentPath()
        ];
        $paginator = new LengthAwarePaginator($results, $collection->count(), $elementsPerPage, $page, $options);
        $paginator->appends(request()->all());
        return $paginator;
    }
}
