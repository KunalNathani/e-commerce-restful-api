<?php

namespace App\Transformers;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier' => (int)$seller->id,
            'name' => $seller->name,
            'email' => $seller->email,
            'isVerified' => (boolean)$seller->isVerified(),
            'creationDate' => $seller->created_at,
            'lastChangeDate' => $seller->updated_at,
            'deletionDate' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null
        ];
    }

    public static function attributeMapper(string $key): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at',
        ];
        return $attributes[$key] ?? null;
    }
}
