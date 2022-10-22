<?php

namespace App\Models;

use App\Models\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    use HasFactory;
    protected $table = "users";
    public $transformer = BuyerTransformer::class;
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
