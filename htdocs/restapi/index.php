<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 24.06.14
 * Time: 00:05
 */

use Slim\Slim;

require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/Classes/Models/Track.php';

global $isDevMode, $entityManager;

/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
   SLIM:
*/

$app = new Slim(['debug' => $isDevMode]);
$app->setName(basename(__DIR__));

/* - - - - - - - - - - - -
   Routes
*/

/** @noinspection PhpMethodParametersCountMismatchInspection */
$app->get('/', function () use ($app, $entityManager) {
    echo "<h1>Hi!</h1><p>You found the api</p>";
})->name('homepage');

$app->get('/tracks/?', function () use ($app, $entityManager) {
    $tracks = $entityManager->getRepository(_T)->createQueryBuilder('t')->getQuery()->getResult();
    echo json_encode($tracks);
})->name('tracks');

$app->get('/track/:id', function ($id) use ($app, $entityManager) {
    try {
        $track = $entityManager->getRepository(_T)->createQueryBuilder('t')
            ->where('t.id LIKE :id')->setParameter('id', $id)
            ->getQuery()->getSingleResult();
    } catch (Doctrine\ORM\NoResultException $e) {
        $app->notFound();
    }
    echo json_encode($track);
})->name('track');

/*
   /Routes
 - - - - - - - - - - - - */

if ($isDevMode) {
    $app->notFound(function () use ($app) {
        $app->halt(404, "<h1>" . $app->getName() . ": 404 &mdash; not found: " .
            filter_input(INPUT_SERVER, 'REQUEST_URI') . "</h1><pre>" .
            json_encode(filter_input_array(INPUT_SERVER), JSON_PRETTY_PRINT) . "</pre>");
    });
}

$app->run();
