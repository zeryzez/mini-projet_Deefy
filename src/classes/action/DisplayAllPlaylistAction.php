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
            $html .= "<p> Vous devez être connecté pour accéder à cette page </p><a href='?action=signin'>Se connecter</a>";
        } else {
            $playlists = $repo->findAllPlaylistByUser();
            $html .= "<h1> Voici toute vos playlists </h1>";
            foreach ($playlists as $playlist) {
                $playlistName = $playlist->__get("nom");
                $playlistData = $repo->getPlaylistByName($playlistName);
                $playlistId = $playlistData['id'] ?? null;
                if ($playlistId) {
                    if((new Authz())->checkPlaylistOwner($playlistId)) {
                        $html .= <<<END
                        <h1>{$playlist->__get("nom")}</h1>
                        <a href='?action=display-playlist&id=$playlistId'>{$playlist->__toString()}</a><br><br>
                        END;
                    }
                }
            }

            $html .= "<br><h2><a href='?action=add-playlist'> ajouter une playlist </a></h2>";
        }

        return $html;
    }
}
