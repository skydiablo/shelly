<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Wifi;

use PhpExtended\Ip\Ipv4AddressInterface;

class Station implements ConfigurationInterface
{
    public function __construct(
        protected ?string $ssid = null,
        protected ?string $password = null,
        protected bool $enable = true,
        protected IPv4Mode $mode = IPv4Mode::DHCP,
        protected ?Ipv4AddressInterface $ipv4Address = null,
        protected ?Ipv4AddressInterface $netmask = null,
        protected ?Ipv4AddressInterface $gateway = null,
        protected ?Ipv4AddressInterface $nameserver = null,
    ) {
        if ($this->mode === IPv4Mode::DHCP) {
            $this->ipv4Address
                = $this->netmask
                = $this->gateway
                = $this->nameserver = null;
        }
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'sta' => [
                'ssid'       => $this->ssid,
                'pass'       => $this->password,
                'enable'     => $this->enable,
                'ipv4mode'   => $this->mode->value,
                'ip'         => $this->ipv4Address ? (string)$this->ipv4Address : null,
                'netmask'    => $this->netmask ? (string)$this->netmask : null,
                'gw'         => $this->gateway ? (string)$this->gateway : null,
                'nameserver' => $this->nameserver ? (string)$this->nameserver : null,
            ],
        ];
    }
}