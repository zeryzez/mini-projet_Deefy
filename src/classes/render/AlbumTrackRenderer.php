<?php
/*EXERCICE 3*/
namespace iutnc\deefy\render;
use \iutnc\deefy\audio\tracks\AlbumTrack;
class AlbumTrackRenderer extends AudioTrackRenderer{
    public AlbumTrack $at;

    public function __construct(AlbumTrack $altr){
        $this->at = $altr;
    }

    protected function renderLong(): String{
        return "Titre: ".$this->at->titre . "<br>Artiste: "
        .$this->at->artiste . "<br>Album: ".$this->at->album . "<br>Genre: ".$this->at->genre . 
        "<br>Durée: ".$this->at->duree ."<br>Année de sortie". $this->at->date .
         "<br>Numéro de piste: ".$this->at->numPiste . 
        "<br><audio controls src=\'".$this->at->nomFichierAudio."'></audio><br>";
    }

    protected function renderCompact(): String{
        return "Titre: ".$this->at->titre . "<br>" . "Artiste: "
        .$this->at->artiste . "<br>" . "Album: ".$this->at->album . "<br>" . 
        "Durée: ".$this->at->duree . "<br>" .
         "<audio controls src=\'".$this->at->nomFichierAudio."'></audio><br>" ;
    }
}