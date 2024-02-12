<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'link_type',
        'thumbnail',
        'description',
        'views',
    ];
}
