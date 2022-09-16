<?php

namespace App\Models;

use App\Models\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    use HasFactory;
    protected $table = "users";

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new BuyerScope());
    }

    /**
    * RELATIONSHIP METHODS
    */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
