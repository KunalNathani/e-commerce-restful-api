<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier' => (int)$category->id,
            'name' => $category->name,
            'categoryDesc' => $category->description,
            'creationDate' => $category->created_at,
            'lastChangeDate' => $category->updated_at,
            'deletionDate' => isset($category->deleted_at) ? (string)$category->deleted_at : null
        ];
    }

    public static function attributeMapper(string $key): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'categoryDesc' => 'description',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at',
        ];
        return $attributes[$key] ?? null;
    }
}
