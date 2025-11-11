<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components;

use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Clients\ClientInterface;
use SkyDiablo\Shelly\Model\ShellyInterface;
use SkyDiablo\Shelly\Payload\Payload;

abstract class Executer
{

    public function __construct(
        protected ShellyInterface $shelly,
        protected ClientInterface $client,
    ) {}

    protected function execute(Payload $payload): PromiseInterface
    {
        return $this->client->handle($this->shelly, $payload);
    }

}