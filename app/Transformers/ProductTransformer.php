<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
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
    public function transform(Product $product)
    {
        return [
            'identifier' => (int)$product->id,
            'name' => $product->name,
            'productDesc' => $product->description,
            'productQuantity' => $product->quantity,
            'isAvailable' => (boolean)$product->isAvailable(),
            'productImage' => $product->image,
            'productSellerIdentifier' => (int)$product->seller_id,
            'creationDate' => $product->created_at,
            'lastChangeDate' => $product->updated_at,
            'deletionDate' => isset($product->deleted_at) ? (string)$product->deleted_at : null
        ];
    }

    public static function attributeMapper(string $key): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'productDesc' => 'description',
            'productQuantity' => 'quantity',
            'isAvailable' => 'status',
            'productImage' => 'image',
            'productSellerIdentifier' => 'seller_id',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at',
        ];
        return $attributes[$key] ?? null;
    }
}
