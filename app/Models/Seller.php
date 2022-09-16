<?php

namespace App\Models;

use App\Models\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    use HasFactory;
    protected $table = "users";

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new SellerScope());
    }

    /**
    * RELATIONSHIP METHODS
    */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
