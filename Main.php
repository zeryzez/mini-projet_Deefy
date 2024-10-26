<?php

require_once 'vendor/autoload.php';

use \iutnc\deefy\audio\tracks\AlbumTrack;
use \iutnc\deefy\audio\tracks\PodcastTrack;
use \iutnc\deefy\render\AlbumTrackRenderer;
use \iutnc\deefy\render\PodcastTrackRenderer;
use \iutnc\deefy\audio\lists\Album;
use \iutnc\deefy\audio\lists\Playlist;
use \iutnc\deefy\render\AudioListRenderer;
use \iutnc\deefy\dispatch\Dispatcher;
use \iutnc\deefy\repository\DeefyRepository;

iutnc\deefy\repository\DeefyRepository::setConfig('src/classes/repository/Config.db.ini');
$repo = DeefyRepository::getInstance();

$dispatcher = new Dispatcher();
$dispatcher->run();



