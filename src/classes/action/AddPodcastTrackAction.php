<?php
namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;

class AddPodcastTrackAction extends Action{
    
    public function execute() : string{
        session_start();
        $html = " ";
        
        if($this->http_method === 'GET'){
            // Formulaire permettant de saisir le nom de la piste et d'uploader un fichier audio
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

                if($fileExtension === '.mp3' && $fileType === 'audio/mpeg') {
                    $randomFileName = uniqid() . '.mp3';
                    $uploadDirectory = __DIR__ . '/../../audio/';
                    $uploadFilePath = $uploadDirectory . $randomFileName;
                    if(!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }
                    if(move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                        $track = new PodcastTrack($name, $uploadFilePath);
                        $_SESSION['playlist']->ajdPiste($track);
                        $playlistRenderer = new AudioListRenderer($_SESSION['playlist']);
                        $html .= <<<END
                            <h1>Votre playlist</h1>
                            {$playlistRenderer->render()}
                            <a href="?action=add-track">Ajouter encore une piste</a>
                        END;
                    } else {
                        $html .= "<p>Erreur lors de l'upload du fichier. Veuillez réessayer.</p><br>";
                    }
                } else {
                    $html .= "<p>Le fichier doit être un fichier .mp3 de type audio/mpeg.</p>
                    <a href='?action=add-track'>Ajouter encore une piste</a>";
                }
            }
        }
        
        return $html;
    }
}
