<?php
namespace iutnc\deefy\audio\tracks;
class PodcastTrack extends AudioTrack{
    protected ?String $date = null;
    protected ?String $auteur = null;

    public function __toString(): String {
        $str = "Titre: ".$this->titre . "\n" . "Artiste: ".$this->auteur . "\n" 
                    . "\n" . "Genre: ".$this->genre . "\n" . 
                   "Durée: ".$this->duree . "\n"
                   . "Nom du fichier audio: ".$this->nomFichierAudio . "\n";
           return $str;
       }

    public function setDate(String $dateA){
        $this->date = $dateA;
    }

    public function setAuteur(String $auteurA){
        $this->auteur = $auteurA;
    }
}