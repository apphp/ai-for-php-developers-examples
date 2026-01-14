<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

class RouteStatusTest extends TestCase
{
    private Client $client;

    /** @var array<int, array{0:string,1:string,2:int}> */
    private static array $routes = [];

    protected function setUp(): void
    {
        $baseUri = getenv('APP_TEST_BASE_URI')
            ?: getenv('APP_URL')
            ?: 'http://localhost:8088/';

        $baseUri = rtrim($baseUri, '/') . '/';

        $this->client = new Client([
            'base_uri' => $baseUri,
            'http_errors' => false,
            'allow_redirects' => false,
        ]);
    }

    public function routeProvider(): array
    {
        if (self::$routes === []) {
            self::$routes = self::discoverRoutes();
        }

        return self::$routes;
    }

    #[Test]
    #[DataProvider('routeProvider')]
    #[TestDox('[$method] $uri should return $expectedStatus')]
    public function testRoutesReturnExpectedStatus(string $method, string $uri, int $expectedStatus): void
    {
        $response = $this->client->request($method, ltrim($uri, '/'));

        self::assertSame(
            $expectedStatus,
            $response->getStatusCode(),
            sprintf('Failed asserting that %s %s returns %d', $method, $uri, $expectedStatus)
        );
    }

    /**
     * @return array<int, array{0:string,1:string,2:int}>
     */
    private static function discoverRoutes(): array
    {
        $app = self::createApp();

        $list = [];

        foreach ($app->getRouteCollector()->getRoutes() as $route) {
            foreach ($route->getMethods() as $method) {
                if ($method !== 'GET') {
                    continue;
                }

                $pattern = $route->getPattern();

                if ($pattern === '/set-lang/{lang}') {
                    $cases = [
                        ['GET', '/set-lang/en', 302],
                        ['GET', '/set-lang/ru', 302],
                    ];
                } else {
                    $cases = [
                        ['GET', $pattern, 200],
                    ];
                }

                foreach ($cases as [$m, $uri, $status]) {
                    $key = sprintf('%s %s => %d', $m, $uri, $status);
                    $list[$key] = [$m, $uri, $status];
                }
            }
        }

        return $list;
    }

    private static function createApp(): App
    {
        $root = dirname(__DIR__);

        require $root . '/app/global.php';
        require $root . '/vendor/autoload.php';
        require $root . '/app/functions.php';

        $app = AppFactory::create();

        if (defined('APP_URL_DIR') && APP_URL_DIR) {
            $app->setBasePath(APP_URL_DIR);
        }

        $renderer = new PhpRenderer($root . '/views');

        require $root . '/app/routes.php';

        return $app;
    }
}
