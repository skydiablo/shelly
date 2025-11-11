<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Model;

use PhpExtended\Ip\Ipv4AddressInterface;
use PhpExtended\Mac\MacAddress48Bits;
use PhpExtended\Mac\MacAddress48Parser;
use React\Promise\PromiseInterface;
use SkyDiablo\Shelly\Clients\ClientInterface;
use SkyDiablo\Shelly\Clients\HTTP;

class Factory
{

    public function __construct(protected MacAddress48Parser $macParser)
    {
    }

    /**
     * @param Ipv4AddressInterface $ipAddress
     * @param ClientInterface|null $client
     *
     * @return PromiseInterface<Shelly>
     */
    public function shelly(Ipv4AddressInterface $ipAddress, ?ClientInterface $client = null): PromiseInterface
    {
        $client ??= new HTTP();
        $shellyComponent = new \SkyDiablo\Shelly\Components\Shelly(new Shelly($ipAddress, new MacAddress48Bits(0, 0)), $client);

        return $shellyComponent->getDeviceInfo()->then(function ($deviceInfo) use ($ipAddress) {
            $rawMac = $deviceInfo['result']['mac'];
            $rawMac = preg_replace('/[^0-9a-f]/i', '', $rawMac);
            $rawMac = implode(':', str_split($rawMac, 2));

            $mac = $this->macParser->parse($rawMac);

            return new Shelly(
                $ipAddress,
                $mac,
            );
        });
    }
}