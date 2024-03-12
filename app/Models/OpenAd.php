<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'link',
        'display_second',
        'image_link',
        'click_count',
        'player_marquee_ad',
    ];
}
