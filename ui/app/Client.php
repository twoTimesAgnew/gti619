<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public static function getResidential()
    {
        return self::where('type', 1)
                    ->orderBy('id', 'asc')
                    ->get();
    }

    public static function getBusiness()
    {
        return self::where('type', 2)
            ->orderBy('id', 'asc')
            ->get();
    }
}
