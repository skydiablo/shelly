<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Clients;

use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Model\ShellyInterface;
use SkyDiablo\Shelly\Payload\Payload;

interface ClientInterface
{

    public function handle(ShellyInterface $shelly, Payload $payload): PromiseInterface;

}