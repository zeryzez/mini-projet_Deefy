<?php
namespace iutnc\deefy\audio\lists;

abstract class AudioList{
    protected int $nbPistes, $dureeTotale;
    protected String $nom;
    protected array $listePistes;

    public function __construct(String $nomListe, Array $listeP = []){
        $this->nom = $nomListe;
        $this->listePistes = $listeP;
        $this->nbPistes = count($listeP);
        $this->dureeTotale = 0;
        foreach($listeP as $piste){
            $this->dureeTotale += $piste->duree;
        } 
    }

    public function __toString(): String{
        $str = "Nom de la liste: ".$this->nom."\n"."Nombre de pistes: ".$this->nbPistes."\n"."Durée totale: ".$this->dureeTotale."\n";
        foreach($this->listePistes as $piste){
            $str .= $piste->__toString();
        }
        return $str;
    }

    public function __get($name){
        if(property_exists($this, $name)){
            return $this->$name;
        }else{
            throw new InvalidPropertyNameException("La propriété ".$name." n'existe pas \n");
        }
    }
}