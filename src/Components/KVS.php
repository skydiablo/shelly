<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components;

use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Payload\Payload;

class KVS extends Executer
{

    const string METHOD_PREFIX = 'KVS.';

    protected function prepareCommand(string $baseMethod): string
    {
        return self::METHOD_PREFIX.$baseMethod;
    }

    protected function generatePayload(string $command, array $params = []): Payload
    {
        return Payload::create($this->prepareCommand($command), $params);
    }

    public function set(string $key, $value, ?string $etag = null): PromiseInterface
    {
        return $this->execute($this->generatePayload('Set', ['key' => $key, 'value' => $value, 'etag' => $etag]));
    }

    public function get(string $key): PromiseInterface
    {
        return $this->execute($this->generatePayload('Get', ['key' => $key]));
    }

    /**
     * @param string $match  Pattern against which keys are matched
     *                       If match is specified the keys are matched according to the following rules:
     *                       matches zero or more characters
     *                       ? Matches exactly one character
     *                       ',' divides alternative patterns
     *                       any other character matches itself
     *                       Match is case-insensitive.
     * @param int    $offset Index of the list from which to start generating the result
     *
     * @return PromiseInterface
     */
    public function getMany(string $match = '*', int $offset = 0): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetMany', ['match' => $match, 'offset' => $offset]));
    }

    /**
     * @param string $match behavior like "get"
     *
     * @return PromiseInterface
     */
    public function list(string $match = '*'): PromiseInterface
    {
        return $this->execute($this->generatePayload('List', ['match' => $match]));
    }

    /**
     * When etag is present it should specify the value for existing pair and is
     * checked against the one in the store so that the key is deleted only if they match.
     * Otherwise, error is returned.
     * If the key does not exist error is returned.
     *
     * @param string      $key
     * @param string|null $etag
     *
     * @return PromiseInterface
     */
    public function delete(string $key, ?string $etag = null): PromiseInterface
    {
        return $this->execute($this->generatePayload('Delete', ['key' => $key, 'etag' => $etag]));
    }

}