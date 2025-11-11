<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components;

use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Components\Switches\ConfigurationInterface;
use SkyDiablo\Shelly\Payload\Payload;
use SkyDiablo\Shelly\Utils\ArrayUtils;

class Switches extends Executer
{

    const string METHOD_PREFIX = 'Switch.';

    protected function prepareCommand(string $baseMethod): string
    {
        return self::METHOD_PREFIX.$baseMethod;
    }

    protected function generatePayload(string $command, array $params = []): Payload
    {
        return Payload::create($this->prepareCommand($command), $params);
    }

    public function setConfig(int $id, ConfigurationInterface $config): PromiseInterface
    {
        return $this->execute($this->generatePayload('SetConfig', [
            'id'     => $id,
            'config' => $config,
        ]));
    }

    public function getConfig(int $id): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetConfig', ['id' => $id]));
    }

    public function getStatus(int $id): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetStatus', ['id' => $id]));
    }

    /**
     * This method sets the output of the Switch component to on or off. It can be
     * used to trigger webhooks. More information about the events triggering webhooks
     * available for this component can be found below.
     *
     * @param int      $id          Id of the Switch component instance.
     * @param bool     $on          True for switch on, false otherwise.
     * @param int|null $toggleAfter Optional flip-back timer in seconds.
     *
     * @return PromiseInterface
     */
    public function set(int $id, bool $on, ?int $toggleAfter = null): PromiseInterface
    {
        return $this->execute($this->generatePayload('Set', ArrayUtils::arrayFilterNull([
            'id'          => $id,
            'on'          => $on,
            'toggle_after' => $toggleAfter,
        ])));
    }

    /**
     * This method toggles the output state. It can be used to trigger webhooks. More
     * information about the events triggering webhooks available for this component
     * can be found below.
     *
     * @param int $id Id of the Switch component instance.
     *
     * @return PromiseInterface
     * @see https://shelly-api-docs.shelly.cloud/gen2/ComponentsAndServices/Switch#switchtoggle
     */
    public function toggle(int $id): PromiseInterface
    {
        return $this->execute($this->generatePayload('Toggle', ['id' => $id]));
    }

    /**
     * This method resets associated counters (if applicable).
     *
     * @param int   $id   Id of the Switch component instance
     * @param array $type Array of strings, selects which counter to reset Optional
     *
     * @return PromiseInterface
     */
    public function resetCounters(int $id, array $type = []): PromiseInterface
    {
        return $this->execute($this->generatePayload('ResetCounters', [
            'id'   => $id,
            'type' => $type,
        ]));
    }

//    /**
//     * Through this endpoint, a switch can be turned on/off with or without a timer.
//     * This can be used to trigger webhooks. More information about the events triggering
//     * webhooks available for this component can be found below.
//     *
//     * @param int      $id
//     * @param Turn     $turn  Action to be executed. Range of values: on, off, toggle
//     * @param int|null $timer A one-shot flip-back timer in seconds.
//     *
//     * @return PromiseInterface
//     */
//    public function relay(int $id, Turn $turn, ?int $timer = null): PromiseInterface
//    {
//        $url = new Uri(implode('/', [
//            'http'.($this->secure ? 's' : '').':/',
//            $this->shelly->getIP(),
//            'relay',
//            $id,
//        ]))->withQuery(
//            http_build_query(ArrayUtils::arrayFilterNull([
//                'turn'  => $turn,
//                'timer' => $timer,
//            ])),
//        );
//
//        return $this->client->get($url);
//    }
}