<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Model;

use PhpExtended\Ip\Ipv4AddressInterface;
use PhpExtended\Mac\MacAddress48BitsInterface as MacAddressInterface;

interface ShellyInterface
{
    public MacAddressInterface $mac {
        get;
    }

    public Ipv4AddressInterface $ip {
        get;
    }

    public ?string $id {
        get;
    }

}