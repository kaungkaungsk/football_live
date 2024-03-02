<?php

namespace App\Enums;

enum BannerAdLocationEnum: string
{
    case HOME = 'home';
    case HIGHLIGHT = 'highlight';
    case NEWS = 'news';
    case MOVIES = 'movies';
    case CHANNELS = 'channels';
    case PLAYER = 'player';
    case SERVER = 'server';
}
