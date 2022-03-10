<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Movimentation as Model_Movimentation;

class Movimentation
{
    public static function create($params)
    {
        $movimentation = new Model_Movimentation();

        return $movimentation->create($params);
    }
}
