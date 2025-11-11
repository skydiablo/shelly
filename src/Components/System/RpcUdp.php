<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\System;

class RpcUdp implements ConfigurationInterface
{

    /**
     * @param string   $destinationAddress
     * @param int|null $listenPort Port number for inbound UDP RPC channel, null disables. Restart is required for changes to apply
     */
    public function __construct(
        protected string $destinationAddress,
        protected ?int $listenPort,
    ) {}


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'rpc_udp' => [
                'dst_addr'    => $this->destinationAddress,
                'listen_port' => $this->listenPort,
            ],
        ];
    }
}