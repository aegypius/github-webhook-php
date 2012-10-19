<?php

namespace GithubWebhook\Handler;

use GithubWebhook\Application;
use GithubWebhook\Structure\Payload;

interface HandlerInterface
{
    public function __construct(Application $app, Payload $payload);
    public function execute();
}
