<?php
namespace iutnc\deefy\dispatch;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\DisplayAllPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\SigninAction;
use iutnc\deefy\action\SignoutAction;


class Dispatcher {

    protected string $action;

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void{
        session_start();
        switch($this->action){
            case 'display-playlist':
                $action = new DisplayPlaylistAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'display-all-playlist':
                $action = new DisplayAllPlaylistAction();
                $html = $this->renderPage($action->execute());
                break;
            case 'add-track':
                $action = new AddPodcastTrackAction();
                $this->renderPage($action->execute());
                break;
            case 'add-playlist':
                $action = new AddPlaylistAction();
                $this->renderPage($action->execute());
                break;
            case 'add-user':
                $action = new AddUserAction();
                $this->renderPage($action->execute());
                break;
            case 'signin':
                $action = new SigninAction();
                $this->renderPage($action->execute());
                break;
            case 'signout':
                $action = new SignoutAction();
                $this->renderPage($action->execute());
                break;
            default:
                $action = new DefaultAction();
                $this->renderPage($action->execute());
                break;
            
        }
    }

    private function renderPage(string $html): void {
        $playlistId = isset($_SESSION['playlistId']) ? htmlspecialchars($_SESSION['playlistId'], ENT_QUOTES, 'UTF-8') : '';
    
        echo <<<END
        <!DOCTYPE html>
        <html lang="FR">
            <head>
                <meta charset="UTF-8">
                <title>Deefy</title>
                <link rel="stylesheet" href="src/style/style.css">
            </head>
            <body>
                <nav>
                    <ul>
                        <div>
                            <li><a href='?action=display-playlist&id={$playlistId}'>voir playlist actuelle</a></li>
                            <li><a href='?action=add-track'>ajouter track</a></li>
                            <li><a href='?action=add-playlist'>ajouter playlist</a></li>
                            <li><a href='?action=display-all-playlist'>voir toute playlist</a></li>
                        </div>
                        <div>
                            <li><a href='?action=default'>accueil</a></li>
                        </div>
                        <div>
                            <li><a href='?action=add-user'>s'inscrire</a></li>
                            <li><a href='?action=signin'>connexion</a></li>
                            <li><a href='?action=signout'>déconnexion</a></li>
                        </div>
                    </ul>              
                </nav>
                <main>
                    $html
                </main>
                <footer>
                    <p>Mini_Projet_Deefy - 2024 @CopyRight Mathys Blonbou </p>
                </footer>
            </body>
        </html>
        END;
    }
    
}