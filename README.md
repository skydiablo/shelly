# SkyDiablo Shelly PHP Library

A PHP library for controlling and managing Shelly devices.

## Requirements

- PHP >= 8.0
- react/http ^3

## Installation

```bash
composer require skydiablo/shelly
```

## Features

- HTTP and AMQP client support for Shelly devices
- Support for various Shelly components:
  - System configuration and management
  - WiFi configuration
  - MQTT configuration
  - Switch control
  - Cloud settings
  - KVS (Key-Value Store)
  - Executer
- Device models for Gen2 devices (Generic, Pro1PM)
- Asynchronous operations using ReactPHP promises

## Usage

```php
use PhpExtended\Ip\Ipv4Address;
use PhpExtended\Mac\MacAddress48Parser;
use SkyDiablo\Shelly\Model\Factory;
use SkyDiablo\Shelly\Model\Shelly;
use PhpExtended\Ip\Ipv4AddressParser;

// Create factory with MAC address parser
$factory = new Factory(new MacAddress48Parser());
$ipParser = Ipv4AddressParser();

$ip = $ipParser->parse('192.168.0.10');

// Create a Shelly device instance from IP address
$factory->shelly($ip)->then(function(Shelly $shelly) {
    // Use the Shelly device instance
    // The factory automatically fetches device info including MAC address
})->otherwise(function($error) {
    // Handle error
});
```

## License

MIT License - see [LICENSE](LICENSE) file for details.

