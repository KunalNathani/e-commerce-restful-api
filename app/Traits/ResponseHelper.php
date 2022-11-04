<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
        $collection = $this->sort($collection, $transformer);
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
}
