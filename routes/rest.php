<?php
$app->group('/api', function () {
    /** @var \Slim\App $this */
    $this->get('/test', '\App\Controllers\ApiUserController:test');
});