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

    public function insertUser($email, $password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "Insert into user (email, passwd, role) values (:email, :passwd, :role)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email, 'passwd' => $hash, 'role' => '1']);
    }

    public function findAllPlaylistById() : array{
        $query = "Select * from playlist";
        $stmt=$this->pdo->prepare($query);
        $stmt->execute();
        $playlists = [];
        foreach($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row){
            $playlists[] = new Playlist($row['nom']);

        }
        echo "OK";
        return $playlists;
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

    public function playlistLinkTrack(Playlist $playlist, AudioTrack $track){
        try {
            $stmtPlaylist = $this->pdo->query("SELECT id FROM playlist WHERE nom = '" . $playlist->__get('nom') . "'");
            $idPlaylist = $stmtPlaylist->fetch(\PDO::FETCH_ASSOC)['id'];
            $stmtTrack = $this->pdo->query("SELECT id FROM track WHERE titre = '" . $track->__get('titre') . "'");
            $idAudioTrack = $stmtTrack->fetch(\PDO::FETCH_ASSOC)['id'];
            $query = "INSERT INTO playlist2track (id_pl, id_track) VALUES (:id_playlist, :id_track)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id_playlist' => $idPlaylist, 'id_track' => $idAudioTrack]);
    
            echo "OK";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function findPlaylistById(int $id): Playlist {
        $stmtPlaylist = $this->pdo->query("SELECT * FROM playlist WHERE id = " . $id);
        $playlist = $stmtPlaylist->fetch(\PDO::FETCH_ASSOC);
        $stmtTracks = $this->pdo->query("SELECT * FROM track JOIN playlist2track ON track.id = playlist2track.id_track WHERE playlist2track.id_pl = " . $id);
        $tracks = [];
        foreach ($stmtTracks->fetchAll(\PDO::FETCH_ASSOC) as $track) {
            if ($track['type'] == 'P') {
                $tracks[] = new PodcastTrack($track['titre'], $track['filename']);
            } else {
                $tracks[] = new AlbumTrack($track['titre'], $track['filename']);
            }
        }
        return new Playlist($playlist['nom'], $tracks);
    }
    
}