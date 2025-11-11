<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Shelly;

enum ComponentIncludes : string {
    case CONFIG = 'config';
    case STATUS = 'status';
}
