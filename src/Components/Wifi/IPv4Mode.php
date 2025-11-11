<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Wifi;

enum IPv4Mode: string
{

    case DHCP = 'dhcp';
    case STATIC = 'static';

}
