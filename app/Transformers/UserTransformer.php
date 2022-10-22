<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identifier' => (int)$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'isVerified' => (boolean)$user->isVerified(),
            'isAdmin' => (boolean)$user->isAdmin(),
            'creationDate' => $user->created_at,
            'lastChangeDate' => $user->updated_at,
            'deletionDate' => isset($user->deleted_at) ? (string)$user->deleted_at : null
        ];
    }
}
