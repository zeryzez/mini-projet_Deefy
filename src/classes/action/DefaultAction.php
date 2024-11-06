<?php
namespace iutnc\deefy\action;

class DefaultAction extends Action {
    
    public function execute() : string{
        return "<h1>Bienvenue!</h1> <p>veuillez vous connecter pour accéder à vos playlists</p>
        <a href='?action=signin'><button>Se connecter</button></a>";
    }
    
}
