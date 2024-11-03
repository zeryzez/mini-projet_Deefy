<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPlaylistAction extends Action{
        
        public function execute() : string{
            $html = " ";
            if(!isset($_SESSION['user'])){
                $html.= <<<END
                <p> veuillez vous connecter pour ajouter une playlist</p>
                <a href="?action=signin">Se connecter</a>
                END;
                return $html;
            }
            if($this->http_method === 'GET'){
                $html .= <<<END
                <form action="?action=add-playlist" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <input type="submit" value="Submit">
                </form>
                END;
            }else if($this->http_method === 'POST'){
                if(filter_var($_POST['name']) === $_POST['name']){
                    $playlist = new Playlist($_POST['name']);
                    $repo = DeefyRepository::getInstance();
                    $repo->savePlaylist($playlist);
                    $_SESSION['playlist'] = $playlist;
                    $repo->userLinkPlaylist($_SESSION['user']->getId(), $repo->getIdPlaylist($playlist->__get("nom")));
                    $render = new AudioListRenderer($playlist);
                    $html .= $render->render($playlist) . '<br>';
                    $html .= '<a href="?action=add-track">Ajouter une piste</a>';
                }else{
                    $html .= 'Le nom de la playlist ne doit pas contenir de caractères spéciaux';
                }
            }
            return $html;
        }
}