<?php

require_once 'vendor/autoload.php';

use \iutnc\deefy\dispatch\Dispatcher;
use \iutnc\deefy\repository\DeefyRepository;

iutnc\deefy\repository\DeefyRepository::setConfig('src/classes/repository/Config.db.ini');
$repo = DeefyRepository::getInstance();

$dispatcher = new Dispatcher();
$dispatcher->run();



