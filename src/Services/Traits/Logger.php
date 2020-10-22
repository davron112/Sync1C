<?php

namespace Davron112\Sync1C\Services\Traits;

use GuzzleHttp\Psr7\Response;

/**
 * Trait Logger
 * @package namespace Davron112\Sync1C\Services\Traits;
 */
trait Logger
{
    /**
     * Write log row.
     *
     * @param array $config 1c-sync config
     * @param string $url call url
     * @param string $method call method
     * @param array $headers call headers
     * @param \GuzzleHttp\Psr7\Response $response response
     *
     * @return void
     */
    private function log(
        array $config,
        string $url,
        string $method,
        array $headers,
        Response $response
    ): void {
        if (empty($config['log_path'])) {
            return;
        }

        $path = $config['log_path'] . date('Y-m-d') . '.txt';
        if (strpos($url, '/login') !== false) {
            unset($headers['json']);
        }
        $request = [
            'Request :' => [
                'url'     => preg_replace('/\bticket=.*$/', 'ticket=xxx', $url),
                'method'  => $method,
                'headers' => $headers,
            ]
        ];

        $response = [
            'Response :' => [
                'StatusCode'    => $response->getStatusCode(),
            ]
        ];

        $this->writeRow($path, PHP_EOL . date('Y/m/d h:i:s') . ' (' . time() . ')');
        $this->writeRow($path, json_encode($request));
        $this->writeRow($path, json_encode($response));
    }

    /**
     * Write log row.
     *
     * @param string $path destination file path
     * @param string $content content
     *
     * @return mixed int|bool
     */
    private function writeRow(string $path, string $content)
    {
        return file_put_contents($path, $content . PHP_EOL, FILE_APPEND);
    }
}
