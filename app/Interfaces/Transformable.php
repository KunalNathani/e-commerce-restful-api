<?php

namespace App\Interfaces;

interface Transformable
{
    /**
     * returns transformer class.
     */
    public function getTransformer();
}
