<?php

namespace App\Enums;

enum RetailerEnum: string
{
    case Coolblue = 'Coolblue';

    case Bol = 'Bol';

    case Mediamarkt = 'Mediamarkt';

    public function getSpiderClass(): string
    {
        return 'App\\Spiders\\' . $this->name . 'Spider';
    }
}
