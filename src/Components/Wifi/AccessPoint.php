<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Wifi;

class AccessPoint implements ConfigurationInterface
{

    public function __construct(
        protected ?string $ssid = null,
        protected ?string $password = null,
        protected bool $isOpen = true,
        protected bool $enable = true,
        protected bool $rangeExtender = true,
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'ap' => [
                'ssid'           => $this->ssid,
                'pass'           => $this->password,
                'is_open'        => $this->isOpen,
                'enable'         => $this->enable,
                'range_extender' => ['enable' => $this->rangeExtender],
            ],
        ];
    }
}