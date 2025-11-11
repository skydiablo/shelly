<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\MQTT;

enum SSLCa: string
{

    case Plain = '';
    case TLSDisabledCertificate = '*';
    case TLSUserCa = 'user_ca.pem';
    case TLSBuildInCa = 'ca.pem';

}