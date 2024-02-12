<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppData extends Model
{
    use HasFactory;

    protected $fillable = [
        'interstitial_frequency',
        'help_center_link',
        'privacy_policy_link',
    ];
}
