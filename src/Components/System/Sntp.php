<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\System;

class Sntp implements ConfigurationInterface
{
    public function __construct(
        protected string $server,
    ) {}


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'sntp' => [
                'server' => $this->server,
            ],
        ];
    }
}