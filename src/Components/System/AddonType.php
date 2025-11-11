<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\System;

enum AddonType: string
{
    case Sensor = 'sensor';
    case ProOutput = 'prooutput';
    case LoRa = 'loRa';
}
