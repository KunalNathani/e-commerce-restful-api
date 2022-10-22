<?php

namespace App\Models;

use App\Interfaces\Transformable;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model implements Transformable
{
    /**
     * The transformer class associated with the model
     */
    public $transformer;

    public function getTransformer()
    {
        return $this->transformer;
    }
}
