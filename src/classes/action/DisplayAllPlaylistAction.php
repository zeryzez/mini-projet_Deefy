<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\auth\Authz;

class DisplayAllPlaylistAction extends Action {
    
    public function execute(): string {
        $repo = DeefyRepository::getInstance();
        $html = "";
        if (!isset($_SESSION['user'])) {
            $html.= "Vous devez être connecté pour accéder à cette page";
        }else{
            $playlists = $repo->findAllPlaylistByUser();
            foreach($playlists as $playlist){
                $html .="<a href='?action=display-playlist&id=" . $repo->getPlaylistByName($playlist->__get("nom"))['id'] ."'>" . $playlist->__toString() . "</a><br><br>";
            }
        }
        return $html;
    }

}