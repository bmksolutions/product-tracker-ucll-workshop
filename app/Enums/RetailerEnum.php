<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum RetailerEnum: string
{
    case Coolblue = 'Coolblue';

    case Bol = 'Bol';

    case Mediamarkt = 'Mediamarkt';

    public function getSpiderClass(): string
    {
        return 'App\\Spiders\\' . Str::studly($this->name) . 'Spider';
    }
}
