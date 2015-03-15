<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 17.06.14
 * Time: 10:34
 */

define('_T', 'Classes\Models\Track');

// Include Composer Autoload (relative to project root).
/** @noinspection PhpIncludeInspection */
require_once __DIR__ . "/../vendor/autoload.php";

/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
   DOCTRINE2:
*/

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$useEchoSQLLogger = false;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/Classes/Models"], $isDevMode);

// database configuration parameters
$conn_general = [
    'driver'        => 'pdo_mysql',
    'dbname'        => 'cse',
    'driverOptions' => [1002 => 'SET NAMES utf8'],
];
$conn_credentials = [
    'uhrendb' => [
        'user'     => 'cse',
        'password' => '123',
    ],
    'root'    => [
        'user'     => 'root',
        'password' => '123',
    ]
];

// obtaining the entity manager
$entityManager = EntityManager::create(array_merge($conn_general, $conn_credentials['root']), $config);
if ($isDevMode && $useEchoSQLLogger) {
    $entityManager->getConnection()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
}
