<?php

/**
 * Created by PhpStorm.
 * User: k127
 * Date: 03.05.15
 * Time: 17:07
 */

use Classes\Models\Point;
use Classes\Models\Track;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;


function test_track()
{
    $serializer = new Serializer([
        //new JsonClassHintingNormalizer(),
        new GetSetMethodNormalizer(),
    ], [new JsonEncoder()]);
    // test
    $points = new ArrayCollection();
    for ($i = 0; $i < 10; $i++) {
        $point = new Point();
        $point->setLatitude(rand(-90, 90));
        $point->setLongitude(rand(-180, 180));
        $point->setElevation(rand(0, 2000));
        $points->add($point);
    }
    $test_track = new Track();
    $test_track->setPoints($points);
    var_export(['$test_track' => $test_track]);
    $test_track_json = $serializer->serialize($test_track, 'json');
    var_export(['$test_track_json' => $test_track_json]);
    $track_from_test_track_json = $serializer->deserialize($test_track_json, get_class(new Track()), 'json');
    var_export(['$track_from_test_track_json' => $track_from_test_track_json]);
}
