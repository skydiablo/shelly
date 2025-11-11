<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Wifi;

class Roaming implements ConfigurationInterface
{
    public function __construct(
        protected int $rssiThreshold = -80,
        protected int $interval = 60,
    ) {}


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'roam' => [
                'rssi_thr' => $this->rssiThreshold,
                'interval' => $this->interval,
            ],
        ];
    }
}