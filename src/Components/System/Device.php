<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\System;

class Device implements ConfigurationInterface
{

    public function __construct(
        protected string $name,
        protected bool $ecoMode = false,
        protected string $profile = '',
        protected bool $discoverable = true,
        protected ?AddonType $addonType = null,
        protected bool $sysButtonToggle = true,

    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'device' => [
                'name'            => $this->name,
                'ecoMode'         => $this->ecoMode,
                'profile'         => $this->profile,
                'discoverable'    => $this->discoverable,
                'addonType'       => $this->addonType?->value,
                'sysButtonToggle' => $this->sysButtonToggle,
            ],
        ];
    }
}