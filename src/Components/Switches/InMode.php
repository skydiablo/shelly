<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Switches;

enum InMode: string
{
    case MOMENTARY = 'momentary';
    case FOLLOW = 'follow';
    case FLIP = 'flip';
    case DETACHED = 'detached';
    case CYCLE = 'cycle';
    case ACTIVATE = 'activate';
}
