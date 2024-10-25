<?php
namespace iutnc\deefy\audio\lists;
use \iutnc\deefy\audio\tracks\PodcastTrack;
use \iutnc\deefy\audio\lists\PlayList;

class Playlist extends AudioList{
    public function ajdPiste(PodcastTrack $piste):void{
        array_push($this->listePistes, $piste);
        $this->nbPistes++;
        if($this->nbPistes == 1 || $this->dureeTotale == 0){
            $this->dureeTotale = 0;
        }else{
            $this->dureeTotale += $piste->duree;
        }
    }

    public function supprPiste(int $indice):void{
        if($indice < $this->nbPistes && $indice >= 0){
            $this->dureeTotale -= $this->listePistes[$indice]->duree;
            array_splice($this->listePistes, $indice, 1);
            $this->nbPistes--;
        }
    }

    public function ajdListePiste(Array $listeP):void{
        foreach($this->listePistes as $piste){
            foreach($listeP as $piste2){
                if($piste == $piste2){
                    unset($listeP[array_search($piste2, $listeP)]);
                }
            }
        }

        $this->listePistes = array_merge($this->listePistes, $listeP);
    }
}