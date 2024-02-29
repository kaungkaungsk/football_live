<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'referer',
        'link',
        'link_type',
        'league',
        'match_date',
        'team1_name',
        'team2_name',
        'vs',
        'team1_logo',
        'team2_logo',
    ];

    protected $casts = [
        'match_date' => 'datetime',
    ];
}
