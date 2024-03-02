<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterstitialAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_path',
        'media_link',
        'click_url',
        'click_count',
    ];
}
