<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'transactionBuyerIdentifier' => (int)$transaction->buyer_id,
            'transactionProductIdentifier' => (int)$transaction->product_id,
            'transactionQuantity' => (int)$transaction->quantity,
            'creationDate' => $transaction->created_at,
            'lastChangeDate' => $transaction->updated_at,
            'deletionDate' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null
        ];
    }

    public static function attributeMapper(string $key): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'transactionBuyerIdentifier' => 'buyer_id',
            'transactionProductIdentifier' => 'product_id',
            'transactionQuantity' => 'quantity',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at',
        ];
        return $attributes[$key] ?? null;
    }
}
