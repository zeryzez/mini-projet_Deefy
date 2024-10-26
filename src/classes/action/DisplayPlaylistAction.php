<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\auth\Authz;

class DisplayPlaylistAction extends Action {
    
    public function execute(): string {
        $repo = DeefyRepository::getInstance();
        $html = "";
        if(!isset($_GET['id'])){
            $html.= "Aucun id de playlist fourni";
        }else{
            $_SESSION['playlist'] = $repo->findPlaylistTracksById($_GET['id']);
            $_SESSION['playlistId']=$_GET['id'];
            $html .= (new AudioListRenderer($_SESSION['playlist']))->render();
            $html .= "<br><a href=?action=add-track> ajouter une piste </a>";
        }
        return $html;
    }

}