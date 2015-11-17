<?php

return [
    // inject Session handling
    [new Silex\Provider\SessionServiceProvider(), []],

    // inject UrlGenerator
    [new Silex\Provider\UrlGeneratorServiceProvider(), []],

    // inject Twig
    [new Silex\Provider\TwigServiceProvider(), [
        'twig.path' => __DIR__ . '/../templates',
    ]],

    // inject GameService
    [new Convertize\Bees\Service\Provider\GameServiceProvider(), [
        'game.settings' => require 'settings.php',
    ]],
];
