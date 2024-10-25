<?php
/*EXERCICE 1*/
namespace iutnc\deefy\audio\tracks;
class AlbumTrack extends AudioTrack{
    protected ?int $numPiste = null;
    protected ?string $album = null;
    protected ?string $artiste = null;
    protected ?string $date = null;

    public function __toString(): String {
     $str = "Titre: ".$this->titre . "\n" . "Artiste: ".$this->artiste . "\n" 
                . "Album: ".$this->album . "\n" . "Genre: ".$this->genre . "\n" . 
                "Durée: ".$this->duree . "\n" . "Date:". $this->date ."\n". 
                "Numéro de piste: ".$this->numPiste . "\n" 
                . "Nom du fichier audio: ".$this->nomFichierAudio . "\n";
        return $str;
    }

    public function setNumPiste(int $numPisteA){
        if($numPisteA < 0){
            throw new InvalidTrackNumberException("Le numéro de piste ne peut pas être négatif \n");
        }else{
            $this->numPiste = $numPisteA;
        }
    }

    public function setAlbum(String $albumA){
        $this->album = $albumA;
    }

    public function setArtiste(String $artisteA){
        $this->artiste = $artisteA;
    }

    public function setDate(String $dateA){
        $this->date = $dateA;
    }
}