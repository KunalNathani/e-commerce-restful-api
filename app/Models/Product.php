<?php

namespace App\Models;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use HasFactory, SoftDeletes;

    const UNAVAILABLE_PRODUCT = 0;
    const AVAILABLE_PRODUCT = 1;

    public $transformer = ProductTransformer::class;

    public static function boot()
    {
        parent::boot();
        self::updated(function (Product $product) {
            if($product->quantity === 0 && $product->isAvailable()) {
                $product->status = Product::UNAVAILABLE_PRODUCT;
                $product->save();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'image',
        'status',
        'seller_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'pivot',
    ];

    /**
    * RELATIONSHIP METHODS
    */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /*
     * HELPER METHODS
     */
    public function isAvailable()
    {
        return $this->status === Product::AVAILABLE_PRODUCT;
    }
}
