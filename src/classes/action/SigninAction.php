<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class SigninAction extends Action{
    public function execute() : string{
        $html = " ";
        if($this->http_method === 'GET'){
            $html .= <<<END
            <h1>Connexion</h1>
            <form action="?action=signin" method="POST">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="TOTO@mail.com">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Votre Mot de passe">
                <input type="submit" value="Connexion">
            </form>
            END;
        }else if($this -> http_method === 'POST'){
            if($_POST['email'] !== filter_var($_POST['email'],FILTER_SANITIZE_EMAIL)){
                $html .= "Email invalide";
                return $html;
            }
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            try{
                AuthnProvider::signin($email, $password);
                $html .= "Vous êtes connecté";
            }catch(\AuthException $e){
                $html .= "Error: " . $e->getMessage();
            }
        }
        return $html;
    }
}