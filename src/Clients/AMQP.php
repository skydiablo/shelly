<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Clients;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Configuration;
use React\EventLoop\Loop;
use React\Promise\PromiseInterface;
use SKBX\ECamper\Services\Shelly\ShellyBroker;
use SkyDiablo\Shelly\Model\ShellyInterface;
use SkyDiablo\Shelly\Payload\Payload;

use function React\Promise\resolve;

class AMQP implements ClientInterface
{

    protected const string DEFAULT_SOURCE = 'shelly-amqp-client';

    protected Client $client;
    protected Channel $channel;
    protected string $source = self::DEFAULT_SOURCE;

    public function __construct(
        Configuration $configuration,
        protected ?string $queueName = null,
    ) {
        $this->queueName ??= bin2hex(random_bytes(12));
        $this->client = new Client($configuration);

        $this->channel = $this->client->channel();
        $this->channel->queueDeclare(
            $this->queueName,
            false,
            true,
            false,
            false,
        );
        $this->channel->queueBind('amq.topic', $this->queueName, '#', true);
    }

    public function handle(ShellyInterface $shelly, Payload $payload, int $id = 1): PromiseInterface
    {
        $body = [
            'id'     => $id,
            'src'    => $this->source, // 'e-camper',
            'method' => $payload->command,
            'params' => $payload->params,
        ];

        return resolve(
            $this->channel->publish(
                json_encode($body),
                [],
                'amq.topic',
                $this->generateRoutingKey($shelly),
            ),
        );
    }

    protected function generateRoutingKey(ShellyInterface $shelly): string
    {
        return sprintf('%s.rpc', $shelly->id);
    }
}