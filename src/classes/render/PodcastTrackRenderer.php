<?php
/*EXERCICE 3*/
namespace iutnc\deefy\render;
use \iutnc\deefy\audio\tracks\PodcastTrack;
class PodcastTrackRenderer extends AudioTrackRenderer{
    public PodcastTrack $at;

    public function __construct(PodcastTrack $altr){
        $this->at = $altr;
    }

    protected function renderLong(): String {
        return "Titre: ".$this->at->titre . "<br>Auteur: "
        .$this->at->auteur  . 
        "<br>Genre: ".$this->at->genre . "<br>Durée: ".$this->at->duree . 
        "<br> Année de sortie: ".$this->at->date
        . "<br><audio controls src=\'".$this->at->nomFichierAudio."'></audio><br>";
    }

    protected function renderCompact(): String {
        return "Titre: ".$this->at->titre . "<br>Auteur: "
        .$this->at->auteur. "<br><audio controls src=\'".$this->at->nomFichierAudio."'></audio><br>" ;
    }
}