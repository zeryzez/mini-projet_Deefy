<?php

class Psr4ClassLoader{
    private String $prefixe, $chemin;

    public function __construct(String $prefixeA, String $cheminA){
        $this->prefixe = $prefixeA;
        $this->chemin = $cheminA;
    }

    public function loadClass(String $nomClasse){
        if(strpos($nomClasse, $this->prefixe) !== 0) return;
        $nomClasse = str_replace($this->prefixe, $this->chemin, $nomClasse);
        $nomClasse = str_replace("\\", "/", $nomClasse);
        $nomClasse = $nomClasse.".php";
        if(file_exists($nomClasse)){
            require_once($nomClasse);
        }
    }

    public function register(){
        spl_autoload_register(array($this, 'loadClass'));
    }
}