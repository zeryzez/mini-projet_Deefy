<?php
namespace iutnc\deefy\action;

class DefaultAction extends Action {
    
    public function execute() : string{
        return "Bienvenue! veuillez vous connecter pour accéder à vos playlists
        <form action='?action=signin' method='GET'>
            <input type='submit' value='Se connecter'>";
    }
    
}
