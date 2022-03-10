<?php

namespace App\Services;

class Uuid
{
    public static function isValidUuid($uuid)
    {
        if (!is_string($uuid) || (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) !== 1)) {
            return false;
        }

        return true;
    }
}
