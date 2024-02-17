<?php

namespace App;

class Helper
{

    public static function titleFormat($league)
    {
        return '🏆 ' . $league . ' ပွဲစဉ်စတင်ပါပြီ';
    }

    public static function messageFormat($home, $away)
    {
        return '🤩 ' . $home . ' vs ' . $away . ' 🤩';
    }
}
