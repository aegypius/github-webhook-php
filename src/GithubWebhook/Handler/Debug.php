<?php

namespace GithubWebhook\Handler;

use GithubWebhook\Application;
use GithubWebhook\Structure\Payload;

class Debug implements HandlerInterface
{

    private $app;
    private $payload;

    public function __construct(Application $app, Payload $payload)
    {
        $this->app = $app;
        $this->payload = $payload;
    }

    public function execute()
    {
        var_dump($this->payload);
    }

}
