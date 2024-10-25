<?php
/*
require_once 'src/classes/render/Renderer.php';
require_once 'src/classes/exception/InvalidPropertyNameException.php';
require_once 'src/classes/exception/InvalidPropertyValueException.php';
require_once 'src/classes/audio/tracks/AudioTrack.php';
require_once 'src/classes/audio/tracks/PodcastTrack.php';
require_once 'src/classes/audio/tracks/AlbumTrack.php';
require_once 'src/classes/render/AudioTrackRenderer.php';
require_once 'src/classes/render/PodcastTrackRenderer.php';
require_once 'src/classes/render/AlbumTrackRenderer.php';
require_once 'src/classes/audio/lists/AudioList.php';
require_once 'src/classes/audio/lists/Album.php';
require_once 'src/classes/audio/lists/Playlist.php';
require_once 'src/classes/render/AudioListRenderer.php';
*/

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



