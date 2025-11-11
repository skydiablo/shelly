<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Clients;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use React\EventLoop\LoopInterface;
use React\Http\Browser;
use React\Http\Message\Uri;
use React\Promise\PromiseInterface;
use React\Socket\ConnectorInterface;
use SkyDiablo\Shelly\Model\ShellyInterface;
use SkyDiablo\Shelly\Payload\Payload;

class HTTP implements ClientInterface
{

    protected const string RPC_PATH = 'rpc';
    protected const string SCHEMA = 'http://';


    protected Browser $browser;
    protected bool $secure = false;


    public function __construct(?ConnectorInterface $connector = null, ?LoopInterface $loop = null)
    {
        $this->browser = new Browser($connector, $loop)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');
    }

    public function useAuth(?string $password): self
    {
        return $this;
    }

    protected function post(UriInterface $url, Payload $payload, array $headers = []): PromiseInterface
    {
        $body = json_encode([
            'id'     => 1,
            'method' => $payload->command,
            'params' => $payload->params,
        ]);

        return $this->browser
            ->post($url, $headers, $body)
            ->then(function (ResponseInterface $response) {
                return json_decode($response->getBody()->getContents(), true);
            })->catch(function (\Throwable $e) {
                //TODO: handle 401, and resend request with correct auth header!
                //SEE: https://shelly-api-docs.shelly.cloud/gen2/General/Authentication#authentication-process
                throw $e;
            });
    }

    public function handle(ShellyInterface $shelly, Payload $payload): PromiseInterface
    {
        $url = new Uri(
            self::SCHEMA
            .implode('/', [
                (string)$shelly->ip,
                self::RPC_PATH,
            ]),
        );

        return $this->post($url, $payload);
    }
}