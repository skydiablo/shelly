<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Model;

use PhpExtended\Ip\Ipv4Address;
use PhpExtended\Ip\Ipv4AddressInterface;
use PhpExtended\Mac\MacAddress48Bits;
use PhpExtended\Mac\MacAddress48BitsInterface as MacAddressInterface;

class Shelly implements ShellyInterface
{
    public function __construct(
        public Ipv4AddressInterface $ip {
            get {
                return $this->ip;
            }
            set {
                $this->ip = $value;
            }
        },
        public MacAddressInterface $mac {
            get {
                return $this->mac;
            }
            set {
                $this->mac = $value;
            }
        },
        public ?string $id
        = null {
            get {
                return $this->id;
            }
        },
    ) {
        $this->id ??= str_replace(':', '', (string)$this->mac);
    }

    static function byMac(MacAddressInterface $mac, ?string $id = null): self
    {
        return new static(new Ipv4Address(0, 0, 0, 0), $mac, $id);
    }

    static function byIP(Ipv4AddressInterface $ip, ?string $id = null): self
    {
        return new static($ip, new MacAddress48Bits(0, 0), $id);
    }

}