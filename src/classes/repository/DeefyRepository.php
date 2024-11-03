<?php

namespace iutnc\deefy\repository;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\tools\User;


class DeefyRepository{
    private ?\PDO $pdo=null;
    protected static array $tabConf = [];
    private static ?DeefyRepository $instance = null; 

    private function __construct($conf){
        $this->pdo = new \PDO($conf['dsn'], $conf['user'], $conf['pass'],[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public function getPdo(){
        return $this->pdo;
    }

    public static function setConfig($file){
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }
        self::$tabConf = [ 'dsn'=> $conf['driver'],'user'=> $conf['username'],'pass'=> $conf['password']];
    }

    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new DeefyRepository(self::$tabConf);
        }
        return self::$instance;
    }

    public function getPlaylistById($id){
        $query = "Select * from playlist where id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $playlist = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $playlist;
    }

    public function getPlaylistByName($name){
        $query = "SELECT * FROM playlist WHERE nom = :name";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['name' => $name]);
        $playlist = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$playlist) {
            throw new \Exception("Playlist not found with name: $name");
        }
        return $playlist;
    }
    

    public function getUserFromEmail($email){
        $query = "Select * from user where email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $userstmt = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!$userstmt){
            return null;
        }
        $user = new User($userstmt['id'], $userstmt['email'], $userstmt['role'], $userstmt['passwd']);
        return $user;
    }

    public function getUserIdFromPlaylist($id){
        $query = "Select id_user from user2playlist where id_pl = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $idUser = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!$idUser){
            return "-1";
        }
        return $idUser['id_user'];
    }

    public function getUserRolefromId($id){
        if($id == null || $id == "" || $id < 0){
            return -1;
        }
        $query = "Select role from user where id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $role = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $role['role'];
    }

    public function insertUser($email, $password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "Insert into user (email, passwd, role) values (:email, :passwd, :role)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email, 'passwd' => $hash, 'role' => '1']);
    }

    public function findAllPlaylistByUser() : array{
        if(!isset($_SESSION['user'])){
            return [];
        }else if($_SESSION['user']->getRole() == '100'){
            $query = "Select id from playlist";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
        }else{
            $query = "Select id_pl as id from user2playlist where id_user = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $_SESSION['user']->getId()]);
        }
        $playlists = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $plArray = [];
        foreach($playlists as $pl){
            $plArray[] = $this->findPlaylistTracksById($pl['id']);
        }
        return $plArray;
    }

    public function userLinkPlaylist($idUser, $idPlaylist){
        $query = "Insert into user2playlist (id_user, id_pl) values (:idUser, :idPlaylist)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idUser' => $idUser, 'idPlaylist' => $idPlaylist]);
    }

    public function savePlaylist(Playlist $playlist){
        try{
            $query = "Insert into playlist (nom) values (:name)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['name' => $playlist->__get('nom')]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function saveTrack(AudioTrack $at){
        try{
            if($at instanceof PodcastTrack){
                $query = "Insert into track (titre, genre, duree, filename, date_posdcast, type, auteur_podcast) values (:title, :genre, :duration, :filename, :date, :type, :auteur)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['title' => $at->__get('titre'), 'genre' => $at->__get('genre'), 'duration' => $at->__get('duree'), 'filename' => $at->__get('nomFichierAudio'), 'date' => $at->__get('date'),'type'=> 'Podcast','auteur'=>$at->__get('auteur')]);
            }else{
                $query = "Insert into track (titre, genre, duree, filename, type, artiste_album, titre_album, annee_album, numero_album) values (:title, :genre, :duration, :filename, :type, :artiste, :album, :date, :num)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['title' => $at->__get('titre'), 'genre' => $at->__get('genre'), 'duration' => $at->__get('duree'), 'filename' => $at->__get('nomFichierAudio'), 'type'=> 'Album','artiste'=>$at->__get('artiste'),'album'=>$at->__get('album'),'date'=>$at->__get('date'),'num'=>$at->__get('numPiste')]);
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function playlistLinkTrack(Playlist $playlist, AudioTrack $track) {
        try {
            // Get the playlist ID
            $playlistData = $this->getPlaylistByName($playlist->__get('nom'));
            $playlistId = $playlistData['id'] ?? null;
    
            if ($playlistId === null) {
                throw new \Exception("Playlist not found: " . $playlist->__get('nom'));
            }
    
            // Get the track ID
            $queryTrack = "SELECT id FROM track WHERE titre = :title";
            $stmtTrack = $this->pdo->prepare($queryTrack);
            $stmtTrack->execute(['title' => $track->__get('titre')]);
            $trackData = $stmtTrack->fetch(\PDO::FETCH_ASSOC);
            $trackId = $trackData['id'] ?? null;
    
            if ($trackId === null) {
                throw new \Exception("Track not found: " . $track->__get('titre'));
            }
    
            // Insert into playlist2track if both IDs are valid
            $query = "INSERT INTO playlist2track (id_pl, id_track) VALUES (:id_pl, :id_track)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id_pl' => $playlistId, 'id_track' => $trackId]);
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    public function findPlaylistTracksById($id): Playlist {
        $queryPlaylist = "SELECT * FROM playlist WHERE id = :id";
        $stmtPlaylist = $this->pdo->prepare($queryPlaylist);
        $stmtPlaylist->execute(['id' => $id]);
        $playlistData = $stmtPlaylist->fetch(\PDO::FETCH_ASSOC);
    
        if (!$playlistData) {
            throw new \Exception("Playlist not found for ID: $id");
        }
        $queryTracks = "SELECT * FROM track 
                        JOIN playlist2track ON track.id = playlist2track.id_track 
                        WHERE playlist2track.id_pl = :id";
        $stmtTracks = $this->pdo->prepare($queryTracks);
        $stmtTracks->execute(['id' => $id]);
    
        $tracks = [];
        foreach ($stmtTracks->fetchAll(\PDO::FETCH_ASSOC) as $trackData) {
            if ($trackData['type'] === 'Podcast') {
                $tracks[] = new PodcastTrack($trackData['titre'], $trackData['filename'], $trackData['date_posdcast'], $trackData['auteur_podcast']);
            } else {
                $tracks[] = new AlbumTrack($trackData['titre'], $trackData['filename'], $trackData['artiste_album'], $trackData['titre_album'], $trackData['annee_album'], $trackData['numero_album']);
            }
        }
        return new Playlist($playlistData['nom'], $tracks);
    }
    
    
}