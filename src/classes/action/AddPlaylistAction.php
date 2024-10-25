<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;

class AddPlaylistAction extends Action{
        
        public function execute() : string{
            session_start();
            $html = " ";
            if($this->http_method === 'GET'){
                $html .= <<<END
                <form action="?action=add-playlist" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                    <input type="submit" value="Submit">
                </form>
                END;
            }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $playlist = new Playlist(filter_var($_POST['name']));
                    $_SESSION['playlist'] = $playlist;
                    $render = new AudioListRenderer($playlist);
                    $html .= $render->render($playlist) . '<br>';
                    $html .= '<a href="?action=add-track">Ajouter une piste</a>';

            }
            return $html;
        }
}