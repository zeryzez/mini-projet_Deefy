<?php
namespace iutnc\deefy\render;
use \iutnc\deefy\audio\lists\AudioList;
use \iutnc\deefy\audio\tracks\PodcastTrack;
use \iutnc\deefy\audio\tracks\AlbumTrack;

class AudioListRenderer implements Renderer{
    protected AudioList $audioList;

    public function __construct(AudioList $audioList){
        $this->audioList = $audioList;
    }

    public function render(String $selector = " "):String{
        $str = "Nom de la liste: ". $this->audioList->nom."<br>";
        foreach($this->audioList->listePistes as $piste){
            if($piste instanceof PodcastTrack){
                $audiorender = new PodcastTrackRenderer($piste);
            }else{
                $audiorender = new AlbumTrackRenderer($piste);
            }
            $str .= $audiorender->render($selector)."\n";
        }
        $str .= "Durée totale: ".$this->audioList->dureeTotale."<br>". "Nombre de pistes: ".$this->audioList->nbPistes."<br>";
        return $str;
    }
}