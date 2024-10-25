<?php
namespace iutnc\deefy\audio\tracks;

use \iutnc\deefy\exception\InvalidPropertyNameException;
use \iutnc\deefy\exception\InvalidDurationException;

abstract class AudioTrack{
    protected ?string $titre = null;
    protected ?string $genre = null;
    protected ?int $duree = null;
    protected ?string $nomFichierAudio = null;

    public function __construct(String $titreA, String $cheminFichAudio){
        $this->titre = $titreA;
        $this->nomFichierAudio = $cheminFichAudio;
    } 

    public function __get($name){
        if(property_exists($this, $name)){
            return $this->$name;
        }else{
            throw new InvalidPropertyNameException("La propriété ".$name." n'existe pas \n");
        }
    }

    public function setGenre(String $genreA){
        $this->genre = $genreA;
    }

    public function setDuree(int $dureeA){
        if($dureeA < 0){
            throw new InvalidDurationException("La durée ne peut pas être négative \n");
        }else{
            $this->duree = $dureeA;
        }
    }
}
