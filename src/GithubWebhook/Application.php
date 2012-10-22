<?php

namespace GithubWebhook;

use GithubWebhook\Structure\Payload;

class Application extends \ArrayObject
{

    public function __construct()
    {
        $this['config'] = null;
    }

    public function set($key, \Closure $callback)
    {
        if (!is_string($key))
            throw new \InvalidArgumentException('$key must be a string');

        $this[$key] = $callback();
        return $this;
    }

    public function run($json)
    {
        // Load Config from object storage
        $config = $this->offsetGet('config');
        if (empty($config)) {
            throw new \RuntimeException('Missing configuration');
        }

        try {
            // Prevent webhook to be triggered by anyone but Github
            if (is_array($config->github->allowedIps) && !in_array($_SERVER['REMOTE_ADDR'], $config->github->allowedIps)) {
                throw new \Exception('Forbidden', 403);
            }

            // Decoding payload
            $payload = Payload::fromJSON($json);

            if ($payload) {
                // Logging payload
                if (isset($config->log->enabled) && $config->log->enabled) {
                    if (isset($config->log->path) && ($configDir = realpath(__DIR__ . '/../../' . $config->log->path)) !== false) {
                        if (isset($payload->repository->owner->name) && isset($payload->repository->name)) {
                            $logFile = sprintf(
                                '%s/%s.%s.log',
                                $configDir,
                                $payload->repository->owner->name,
                                $payload->repository->name
                            );
                        } else {
                            $logFile = sprintf('%s/github.log', $configDir);
                        }
                        file_put_contents($logFile, print_r($payload, true), FILE_APPEND);
                    }
                }

                if ($config->debug) {
                    $obj = new Handler\Debug($this, $payload);
                } else {
                    // Check if a specific handler exists
                    $handlerClass = sprintf(
                        '%s\\%s',
                        Util::camelize($payload->repository->owner->name, true),
                        Util::camelize($payload->repository->name, true)
                    );

                    if (class_exists($handlerClass) && $handlerClass instanceof Handler\HandlerInterface) {
                        $obj = new $handlerClass($this, $payload);
                    } else {
                        throw new \Exception(
                            sprintf(
                                "No action defined for '%s/%s' (%s).",
                                $payload->repository->owner->name,
                                $payload->repository->name,
                                $handlerClass
                            ),
                            501
                        );
                    }
                }

            }

        } catch(\Exception $e) {
            header('HTTP/1.1 '. $e->getCode() .' ' . $e->getMessage());
            header('Content-Type: application/json;charset=utf-8');
            echo json_encode(array(
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ));
            exit(0);
        }

    }

}
