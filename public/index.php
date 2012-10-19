<?php
require '../vendor/autoload.php';

use GithubWebhook\Application;
header('Content-Type: text/plain; charset=utf-8');
ini_set('html_errors', 0);

$app = new Application;

$app->set('config', function() {
    $config = false;

    $configFile = __DIR__ . '/../config/config.json';
    if (is_file($configFile)) {
        $jsonConfig = file_get_contents($configFile);
    } elseif (is_file($configFile . '.dist')) {
        $jsonConfig = file_get_contents($configFile . '.dist');
    } else {
        throw new Exception('Please setup your config file in config/config.json.');
    }
    $config = json_decode($jsonConfig);
    return $config;
});

// Get the payload
$payload = null;
if (isset($_POST['payload'])) {
    $payload = $_POST['payload'];
}

$app->run($payload);
