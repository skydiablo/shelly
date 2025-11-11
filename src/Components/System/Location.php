<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\System;

class Location implements ConfigurationInterface
{


    public function __construct(
        protected ?string $timezone = null,
        protected ?float $latitude = null,
        protected ?float $longitude = null,
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'location' => [
                'tz'  => $this->timezone,
                'lat' => $this->latitude,
                'lon' => $this->longitude,
            ],
        ];
    }
}