<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Switches;

enum InitialState: string
{
    case OFF = 'off';
    case ON = 'on';
    case RESTORE_LAST = 'restore_last';
    case MATCH_INPUT = 'match_input';
}
