<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app['club_provider'] = function () {
    return new Hapodico\Service\ClubProviderService();
};

$app['debug'] = true;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', array(
        'clubs' => $app['club_provider']->fetchClubs()
    ));
});

$app->get('/club/{code}', function ($code) use ($app) {
    return $app['twig']->render('club.twig', array(
        'teams' => $app['club_provider']->fetchTeams($code)
    ));
});

$app->run();