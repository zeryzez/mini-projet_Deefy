<?php
namespace iutnc\deefy\audio\lists;
class Album extends AudioList{
    protected String $artisteAlbum, $anneeSortie;

    public function __construct(String $nomListe,Array $listeP){
        parent::__construct($nomListe, $listeP);
    }

    public function setArtisteAlbum(String $artisteAlbumA){
        $this->artisteAlbum = $artisteAlbumA;
    }

    public function setAnneeSortie(String $anneeSortieA){
        $this->anneeSortie = $anneeSortieA;
    }

    public function __toString(): String{
        $str = parent::__toString();
        $str .= "Artiste de l'album: ".$this->artisteAlbum."\n"."Année de sortie: ".$this->anneeSortie."\n";
        return $str;
    }

}