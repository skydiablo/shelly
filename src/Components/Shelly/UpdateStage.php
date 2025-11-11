<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Shelly;

enum UpdateStage : string {
    case STABLE = 'stable';
    case BETA = 'beta';
}
