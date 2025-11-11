<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components;

use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Components\System\ConfigurationInterface;
use SkyDiablo\Shelly\Payload\Payload;

class System extends Executer
{

    const string METHOD_PREFIX = 'Sys.';

    protected function prepareCommand(string $baseMethod): string
    {
        return self::METHOD_PREFIX.$baseMethod;
    }

    protected function generatePayload(string $command, array $params = []): Payload
    {
        return Payload::create($this->prepareCommand($command), $params);
    }

    public function setConfig(ConfigurationInterface $config): PromiseInterface
    {
        return $this->execute($this->generatePayload('SetConfig', ['config' => json_encode($config)]));
    }

    public function getConfig(): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetConfig'));
    }

    public function getStatus(): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetStatus'));
    }

    public function setTime(float $time): PromiseInterface {
        return $this->execute($this->generatePayload('SetTime', ['unixtime' => $time]));
    }
}