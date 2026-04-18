<?php
// app/Models/EventSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSetting extends Model
{
    protected $fillable = ['form_open', 'header_image'];

    protected $casts = ['form_open' => 'boolean'];

    public static function current(): self
    {
        return self::firstOrCreate([], ['form_open' => true]);
    }
}
