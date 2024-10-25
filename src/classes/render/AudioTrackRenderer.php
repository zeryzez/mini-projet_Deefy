<?php
namespace iutnc\deefy\render;
use \iutnc\deefy\render\Renderer;
use \iutnc\deefy\audio\tracks\AudioTrack;

abstract class AudioTrackRenderer implements Renderer{
    private AudioTrack $at;

    public function __construct(AudioTrack $altr){
        $this->at = $altr;
    }

    public function render(String $selector = Renderer::COMPACT):String{
        switch($selector){
            case Renderer::COMPACT :
                return $this->renderCompact();
            case Renderer::LONG :
                return $this->renderLong();

            default:
                return $this->renderCompact();

        }
    }

    public function __get($name){
        return $this->at->$name;
    }

    public function __set($name, $value){
        $this->at->$name = $value;
    }


    protected abstract function renderLong(): String;
    protected abstract function renderCompact(): String;
}