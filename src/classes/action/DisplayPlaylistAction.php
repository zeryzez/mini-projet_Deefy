<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\auth\Authz;

class DisplayPlaylistAction extends Action {
    
    public function execute(): string {
        session_start();
        $repo = DeefyRepository::getInstance();
        $html = "";
        $check = new Authz();
        if (!isset($_SESSION['user'])) {
            $html.= "Vous devez être connecté pour accéder à cette page";
        }elseif(!$check->checkPlaylistOwner($_GET['id'])){
            $html.= "Vous n'avez pas les droits pour accéder à cette page";
        }else{
            $idPlaylist = $_GET['id'];
            $playlist = $repo->findPlaylistById($idPlaylist);
            $html .= (new AudioListRenderer($playlist))->render();
        }
        return $html;
    }

}