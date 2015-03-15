<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 16.06.14
 * Time: 19:33
 */

require_once 'src/bootstrap.php';

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($entityManager->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager),
));
