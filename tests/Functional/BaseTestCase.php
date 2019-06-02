<?php

namespace Tests\Functional;

use Dotenv\Dotenv;
use PDO;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends TestCase
{
    /**
     * Absolute path to database test fixtures
     */
    const FIXTURE_PATH = __DIR__ . '/fixtures/';

    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

    /**
     * @var App
     */
    protected $app;

    /**
     * @before
     */
    protected function setUpApp()
    {
        $dotenv = Dotenv::create(__DIR__ . '/../../');
        $dotenv->load();

        // Use the application settings
        $settings = require __DIR__ . '/../../src/settings.php';

        // Instantiate the application
        $app = new App($settings);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../../src/dependencies.php';
        $dependencies($app);

        // Register middleware
        if ($this->withMiddleware) {
            $middleware = require __DIR__ . '/../../src/middleware.php';
            $middleware($app);
        }

        // Register routes
        $routes = require __DIR__ . '/../../src/routes.php';
        $routes($app);

        $this->app = $app;
    }

    protected function setUp(): void
    {
        $fixtureFiles = glob(self::FIXTURE_PATH . '/*');

        $fixtures = array_reduce(
            $fixtureFiles,
            function ($carry, $next) {
                return array_merge_recursive($carry ?? [], include $next);
            }
        );

        foreach ($fixtures as $table => $records) {
            // Truncate table
            $this->database()->exec("TRUNCATE TABLE $table");
            foreach ($records as $record) {
                // Populate fixtures
                $query = sprintf(
                    'INSERT INTO %s (%s) VALUES (%s)',
                    $table,
                    implode(',', array_keys($record)), // columns
                    implode(',', array_fill(0, count($record), '?')) // placeholders
                );
                $statement = $this->database()->prepare($query);
                $statement->execute(array_values($record));
            }
        }
    }

    /**
     * @return PDO
     */
    protected function database()
    {
        return $this->app->getContainer()->get(PDO::class);
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Process the application
        $response = $this->app->process($request, $response);

        // Return the response
        return $response;
    }
}
