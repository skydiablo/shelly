<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Switches;

enum Turn: string
{
    case ON = 'on';
    case OFF = 'off';
    case TOGGLE = 'toggle';
}
