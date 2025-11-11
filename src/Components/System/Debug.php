<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\System;

class Debug implements ConfigurationInterface
{
    public function __construct(
        protected bool $mqtt = false,
        protected bool $websocket = false,
        protected ?string $address = null,
    ) {}


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'debug' => [
                'mqtt'      => [
                    'enabled' => $this->mqtt,
                ],
                'websocket' => [
                    'enabled' => $this->websocket,
                ],
                'udp'       => [
                    'addr' => $this->address,
                ],
            ],
        ];
    }
}