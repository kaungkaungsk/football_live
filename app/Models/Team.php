<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'logo',
        'description',
    ];

    public function footballMatches(): HasMany
    {
        return ($this->hasMany(FootballMatch::class, 'team1_id'))->union($this->hasMany(FootballMatch::class, 'team2_id'));
    }
}
