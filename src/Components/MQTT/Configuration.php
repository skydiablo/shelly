<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\MQTT;

use SkyDiablo\Shelly\Components\MQTT\ConfigurationInterface;
use SkyDiablo\Shelly\Utils\ArrayUtils;

class Configuration implements ConfigurationInterface
{
    public function __construct(
        protected bool $enabled = true,
        protected ?string $server = null,
        protected ?int $port = null,
        protected ?string $clientId = null,
        protected ?string $username = null,
        protected ?string $password = null,
        protected SSLCa $sslCa = SSLCa::Plain,
        protected ?string $topicPrefix = null,
        protected bool $rpcNotification = true,
        protected bool $statusNotification = false,
        protected bool $useClientCert = false,
        protected bool $enableControl = true,
    ) {}


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return ArrayUtils::arrayFilterNull([
            'enable'          => $this->enabled,
            'server'          => $this->server.($this->port ? ':'.$this->port : ''),
            'client_id'       => $this->clientId,
            'user'            => $this->username,
            'pass'            => $this->password,
            'ssl_ca'          => $this->sslCa->value ?: null,
            'topic_prefix'    => $this->topicPrefix,
            'rpc_ntf'         => $this->rpcNotification,
            'status_ntf'      => $this->statusNotification,
            'use_client_cert' => $this->useClientCert,
            'enable_control'  => $this->enableControl,
        ], ['ssl_ca']);
    }
}