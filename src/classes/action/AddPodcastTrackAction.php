<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPodcastTrackAction extends Action{
    
    public function execute() : string{
        $html = " ";
        if(isset($_SESSION['user'])){
            if(isset($_SESSION['playlist'])){
                if($this->http_method === 'GET'){
                    $html .= <<<END
                    <form action="?action=add-track" method="POST" enctype="multipart/form-data">
                        <label for="name">Nom:</label>
                        <input type="text" id="name" name="name" required>
                        
                        <label for="audioFile">Fichier audio (.mp3 uniquement):</label>
                        <input type="file" id="audioFile" name="audioFile" accept=".mp3" >
                        
                        <input type="submit" value="Ajouter la piste">
                    </form>
                    END;
    
                } else if($_SERVER['REQUEST_METHOD'] === 'POST') { 
                        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                        if(isset($_FILES['audioFile'])) {
                            $file = $_FILES['audioFile'];
                            $fileExtension = substr($file['name'], -4);
                            $fileType = $file['type'];
            
                                $randomFileName = uniqid() . '.mp3';
                                $uploadDirectory = __DIR__ . '/../../audio/';
                                $uploadFilePath = $uploadDirectory . $randomFileName;
                                if(!is_dir($uploadDirectory)) {
                                    mkdir($uploadDirectory, 0777, true);
                                }
                                $track = new PodcastTrack($name, $uploadFilePath);
                                $_SESSION['playlist']->ajdPiste($track);
                                $repo = DeefyRepository::getInstance();
                                $repo->saveTrack($track);
                                $repo->playlistLinkTrack($_SESSION['playlist'],$track);
                                $_SESSION['playlist'] = $repo->findPlaylistTracksById($_SESSION['playlistId']);
                                $playlistRenderer = new AudioListRenderer($_SESSION['playlist']);
                                $html .= <<<END
                                    <h1>Votre playlist</h1>
                                    {$playlistRenderer->render()}
                                    <a href="?action=add-track">Ajouter encore une piste</a>
                                END;
                    }  
                }
            }else{
                $html .= <<<END
                <h1>Erreur</h1>
                <p>Vous devez d'abord avoir une playlist en session, Veuillez d'abord choisir la playlist ou vous souhaitez ajouter une piste</p>
                <a href="?action=display-all-playlist">Choisir une playlist</a>
                END;
            } 
        }else{
            $html.= <<<END
            <p> veuillez vous connecter pour ajouter une piste</p>
            <a href="?action=signin">Se connecter</a>
            END;
        }
            
        
        return $html;
    }
}
