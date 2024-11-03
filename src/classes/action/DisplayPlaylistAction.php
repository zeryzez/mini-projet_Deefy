<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\auth\Authz;

class DisplayPlaylistAction extends Action {
    
    public function execute(): string {
        $repo = DeefyRepository::getInstance();
        $html = "";
        if(!isset($_SESSION['user'])){
            $html.= "Vous devez être connecté pour accéder à cette page <a href='?action=signin'>Se connecter</a>";
        }else if(!isset($_GET['id']) || empty($_GET['id'])){
            $html.= "Aucun id de playlist fourni";
        }else if(!(new Authz())->checkPlaylistOwner($_GET['id'])){
            $html.= "Vous n'êtes pas autorisé à accéder à cette playlist";
        }else{
            $_SESSION['playlist'] = $repo->findPlaylistTracksById($_GET['id']);
            $_SESSION['playlistId']=$_GET['id'];
            $html .= (new AudioListRenderer($_SESSION['playlist']))->render();
            $html .= "<br><a href=?action=add-track> ajouter une piste </a>";
        }
        return $html;
    }

}