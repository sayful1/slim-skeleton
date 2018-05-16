<?php

use Dotenv\Dotenv;
use Noodlehaus\Config;
use Slim\App;

// Include vendor autoload file
require dirname(__DIR__) . '/vendor/autoload.php';

// load .env file
$dotenv = new Dotenv(dirname(__DIR__));
$dotenv->load();

// Get all Configuration from config directory
$config = Config::load(dirname(__DIR__) . '/config');

// Session
session_name($config->get('session.name'));
session_save_path($config->get('session.path'));
session_start();

// Instantiate the app
$settings = [
    'settings' => [
        'displayErrorDetails'    => $config->get('app.debug'),
        'addContentLengthHeader' => false,
    ],
];

$app = new App($settings);

// functions
require __DIR__ . '/functions.php';

// Set up dependencies
require __DIR__ . '/dependencies.php';

// Register middleware
require __DIR__ . '/middleware.php';

// Register routes
require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/rest.php';