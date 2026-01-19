<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components;

use React\Http\Message\Uri;
use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Components\Shelly\ComponentIncludes;
use SkyDiablo\Shelly\Components\Shelly\UpdateStage;

use SkyDiablo\Shelly\Payload\Payload;

use function React\Async\async;
use function React\Async\await;

class Shelly extends Executer
{

    const string PASSWORD_HASH_ALGORITHM = 'sha256';
    const string METHOD_PREFIX = 'Shelly.';

    protected function prepareCommand(string $baseMethod): string
    {
        return self::METHOD_PREFIX.$baseMethod;
    }

    protected function generatePayload(string $command, array $params = []): Payload
    {
        return Payload::create($this->prepareCommand($command), $params);
    }

    public function status(): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetStatus'));
    }

    public function config(): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetConfig'));
    }

    public function listMethods(): PromiseInterface
    {
        return $this->execute($this->generatePayload('ListMethods'));
    }

    public function getDeviceInfo(bool $ident = false): PromiseInterface
    {
        return $this->execute($this->generatePayload('GetDeviceInfo', ['ident' => $ident]));
    }

    public function listProfiles(): PromiseInterface
    {
        return $this->execute($this->generatePayload('ListProfiles'));
    }

    public function setProfile(string $profile): PromiseInterface
    {
        return $this->execute($this->generatePayload('SetProfile', ['name' => $profile]));
    }

    public function listTimezones(int $offset = 0): PromiseInterface
    {
        return $this->execute($this->generatePayload('ListTimezones', ['offset' => $offset]));
    }

    public function detectLocation(): PromiseInterface
    {
        return $this->execute($this->generatePayload('DetectLocation'));
    }

    public function checkForUpdate(): PromiseInterface
    {
        return $this->execute($this->generatePayload('CheckForUpdate'));
    }

    public function update(UpdateStage $updateStage = UpdateStage::STABLE, ?Uri $uri = null): PromiseInterface
    {
        if ($uri) {
            $params = ['url' => (string)$uri];
        } else {
            $params = ['stage' => $updateStage->value];
        }

        return $this->execute($this->generatePayload('Update', $params));
    }

    public function factoryReset(): PromiseInterface
    {
        return $this->execute($this->generatePayload('FactoryReset'));
    }

    public function resetWiFiConfig(): PromiseInterface
    {
        return $this->execute($this->generatePayload('ResetWiFiConfig'));
    }

    public function reboot(int $delayMs = 1000): PromiseInterface
    {
        $delayMs = max($delayMs, 1000);
        $params = ['delay_ms' => $delayMs];

        return $this->execute($this->generatePayload('Reboot', $params));
    }

    /**
     * @param string|null $password null to disable authentication
     * @param string|null $realm    null to auto detect
     *
     * @return PromiseInterface
     * @throws \Throwable
     */
    public function setAuth(?string $password = null, ?string $realm = null): PromiseInterface
    {
        $realm ??= $this->shelly;
        $params = [
            'user'  => $user = 'admin', // Must be set to admin.
            'realm' => $realm, // Must be the id of the device
            'ha1'   => $password
                ? hash(
                    self::PASSWORD_HASH_ALGORITHM,
                    implode(':', [$user, $realm, $password]),
                ) : null,
        ];

        return $this->execute($this->generatePayload('SetAuth', $params));
    }


    protected function putTLS(string $command, ?string $data = null): PromiseInterface
    {
        return async(function ($command, $data) {
            $lines = explode("\n", (string)$data);
            for ($i = 0; $i < count($lines); $i++) {
                $params = ['data' => $lines[$i], 'append' => ($i !== 0)]; //replace existing
                await($this->execute($this->generatePayload($command, $params)));
            }

            return true;
        })(
            $command,
            $data,
        );
    }

    public function putUserCA(?string $data = null): PromiseInterface
    {
        return $this->putTLS('PutUserCA', $data);
    }

    public function putTLSClientCert(?string $data = null): PromiseInterface
    {
        return $this->putTLS('PutTLSClientCert', $data);
    }

    public function putTLSClientKey(?string $data = null, bool $append = false): PromiseInterface
    {
        return $this->putTLS('PutTLSClientKey', $data);
    }

    /**
     * @param int                      $offset
     * @param array<ComponentIncludes> $includes
     * @param array                    $keys
     * @param bool                     $dynamic_only
     *
     * @return PromiseInterface
     */
    public function getComponents(int $offset = 0, array $includes = [], array $keys = [], bool $dynamic_only = false): PromiseInterface
    {
        $params = [
            'offset'       => $offset,
            'include'      => array_filter(array_map(function ($include) {
                if ($include instanceof ComponentIncludes) {
                    return $include->value;
                }

                return null;
            }, $includes)),
            'keys'         => $keys,
            'dynamic_only' => $dynamic_only,
        ];

        return $this->execute($this->generatePayload('Shelly.GetComponents', $params));
    }
}