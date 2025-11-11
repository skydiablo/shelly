<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components;

use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Components\Wifi\ConfigurationInterface;
use SkyDiablo\Shelly\Payload\Payload;

class Wifi extends Executer
{

    const string METHOD_PREFIX = 'WiFi.';

    protected function prepareCommand(string $baseMethod): string
    {
        return self::METHOD_PREFIX.$baseMethod;
    }

    protected function generatePayload(string $command, array $params = []): Payload
    {
        return Payload::create($this->prepareCommand($command), $params);
    }

    /**
     * @return PromiseInterface https://shelly-api-docs.shelly.cloud/gen2/ComponentsAndServices/WiFi#status
     */
    public function getConfig(): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetConfig'));
    }

    public function setConfig(ConfigurationInterface $config): PromiseInterface
    {
        return $this->execute($this->generatePayload('SetConfig', ['config' => json_encode($config)]));
    }

    public function getStatus(): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetStatus'));
    }

    public function scan(): PromiseInterface
    {
        return $this->execute($this->generatePayload('Scan'));
    }

    public function listApClients(): PromiseInterface
    {
        return $this->execute($this->generatePayload('ListAPClients'));
    }

}