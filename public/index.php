<?php
// web/index.php/*

require_once __DIR__ . '/../public/bootstrap/bootstrap.php';
require_once __DIR__ . '/../app/PetController.php';
/*var_dump($_SERVER['DOCUMENT_ROOT']);*/
define('UPLOAD_PATH' , $_SERVER['DOCUMENT_ROOT'] . '/tmp/img/pets/');

$app->run();