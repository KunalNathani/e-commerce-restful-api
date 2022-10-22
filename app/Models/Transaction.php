<?php

namespace App\Models;

use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    public $transformer = TransactionTransformer::class;

    /**
    * RELATIONSHIP METHODS
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
