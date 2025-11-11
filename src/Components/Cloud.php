<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components;

use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Payload\Payload;

class Cloud extends Executer
{

    const string METHOD_PREFIX = 'Cloud.';

    protected function prepareCommand(string $baseMethod): string
    {
        return self::METHOD_PREFIX.$baseMethod;
    }

    protected function generatePayload(string $command, array $params = []): Payload
    {
        return Payload::create($this->prepareCommand($command), $params);
    }

    public function enable(bool $enable): PromiseInterface
    {
        return $this->execute($this->generatePayload('SetConfig', ['config' => ['enable' => $enable]]));
    }

    public function getConfig(): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetConfig'));
    }

}