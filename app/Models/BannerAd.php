<?php

namespace App\Models;

use App\Enums\BannerAdLocationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class BannerAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_path',
        'media_link',
        'click_url',
        'height',
        'width',
        'location',
        'click_count',
    ];
}
