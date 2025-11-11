<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Payload;

class Payload
{

    private function __construct(
        public string $command {
            get {
                return $this->command;
            }
        },
        public array $params = [] {
            get {
                return $this->params;
            }
        },
    ) {}

    /**
     * @param string $command
     * @param array  $params
     *
     * @return Payload
     */
    public static function create(string $command, array $params = []): Payload
    {
        return new static($command, $params);
    }

}