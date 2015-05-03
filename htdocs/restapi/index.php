<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 24.06.14
 * Time: 00:05
 */

use Classes\Models\Point;
use Classes\Models\Track;
use Slim\Slim;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

require_once __DIR__ . '/../../src/bootstrap.php';

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
})->name('get_homepage');

$app->get('/tracks/?', function () use ($app, $entityManager) {
    /** @var Track $track */
    foreach ($entityManager->getRepository(_T)->createQueryBuilder('t')->getQuery()->getResult() as $track) {
        echo json_encode($track->getId()) . ": ";
        /** @var Point $point */
        foreach ($track->getPoints() as $point) {
            echo json_encode($point->getId());
        }
    }
})->name('get_tracks');

$app->get('/track/:id', function ($id) use ($app, $entityManager) {
    try {
        $track = $entityManager->getRepository(_T)->createQueryBuilder('t')
            ->where('t.id LIKE :id')->setParameter('id', $id)
            ->getQuery()->getSingleResult();
    } catch (Doctrine\ORM\NoResultException $e) {
        $app->notFound();
        return;
    }
    echo json_encode($track);
})->name('get_track');

$app->put('/track/?', function () use ($app, $entityManager) {
    $normalizer = new GetSetMethodNormalizer();
    $encoder = new JsonEncoder();
    $serializer = new Serializer([$normalizer], [$encoder]);
    $request_body_json = $app->request->getBody();

    //$track = new Track();
    //$entityManager->persist($track);
    echo "<pre>";
    /** @var Track $track_from_json */
    $track_from_json = Track::deserialize($request_body_json, get_class(new Track()));
    var_export(['$track_from_json' => $track_from_json]);
    // this is a workaround until implementation of: deserialize 'points' array to ArrayCollection
    /*
    $request_body = json_decode($request_body_json);
    $points = new ArrayCollection();
    foreach ($request_body->points as $point_raw) {
        $point = new Point();
        $point->setTrack($track);
        $point->deserialize(json_encode($point_raw));
        var_export($point);
        die();
        $entityManager->persist($point);
        $points->add($point);
    }
    $track->setPoints($points);
    */
    // end of workaround

    $entityManager->persist($track_from_json);
    $entityManager->flush();
    echo $track_from_json->getId();
})->name('put_track');

$app->get('/test/?', function () {
    require_once __DIR__ . '/../../src/workarounds.php';
    echo "<pre>";
    test_track();
})->name('get_test');

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
