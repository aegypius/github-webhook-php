# Webhook

Post-Receive Hook consumer for github

## Writing your hooks

Create an handler class in src/ that inherit from GithubWebhook\Handler\HandlerInterface :

- You must name create a new namespace based on owner name of the repository using cap-styled convention
  Example : for an owner called "john doe" you must create a "JohnDoe" namespace.
- You must create a class implementing sur HandlerInterface named based on the repository name using the same
  convention.
  Example : for a repository called "my-sample-project" you must create a class named MySampleProject.
- You must name your class file the same way.
  Example: MySampleProject.php

Here is an example of this file :

```php
<?php

namespace JohnDoe;

use GithubWebhook\Application;
use GithubWebhook\Structure\Payload;
use GithubWebhook\Handler\HandlerInterface;

class MySampleProject implements HandlerInterface
{
    private $app;
    private $payload;

    public function __construct(Application $app, Payload $payload)
    {
        $this->app     = $app;
        $this->payload = $payload;
    }

    public function execute()
    {
        var_dump($this->payload);
    }

}

```
