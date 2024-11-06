<?php
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthException;
    class AddUserAction extends Action{

        public function execute() : String{
            $html = " ";
            if($this->http_method === 'GET'){
                $html .= <<<END
                <h1>Inscription</h1>
                <form action='?action=add-user' method='POST'>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="TOTO@mail.com" required>
                    <label for="cemail">Confirmez votre Email:</label>
                    <input type="email" id="cemail" name="cemail" placeholder="Confirmez email" required>
                    <br>
                    <label for="mdp">Mot de passe:</label>
                    <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required>
                    <label for="cmdp">Confirmez Mot de passe:</label>
                    <input type="password" id="cmdp" name="cmdp" placeholder="Confirmez mot de passe" required>
                    <br>
                    <input type="submit" value="Inscription">
                </form>
                END;
            }else if($this -> http_method==='POST'){
                if($_POST['email'] !== filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)){
                    $html .= "Email invalide";
                    return $html;
                }
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $cemail = filter_var($_POST['cemail'], FILTER_SANITIZE_EMAIL);
                $mdp = $_POST['mdp'];
                $cmdp = $_POST['cmdp'];

                if($email !== $cemail && $mdp !== $cmdp){
                    $html .= "Les emails et mot de passe ne correspondent pas";
                }else if($email !== $cemail){
                    $html .= "Les emails ne correspondent pas";
                }else if($mdp !== $cmdp){
                    $html .= "Les mots de passe ne correspondent pas";
                }else{
                    try{
                        AuthnProvider::register($email, $mdp);
                        $html .= "Vous êtes maintenant inscrit";
                        $html .= "<a href='?action=signin'>Connectez-vous</a>";
                    }catch(AuthException $e){
                        $html .= "Erreur: veuillez réessayer" . $e->getMessage();
                    }
                }
            }
            return $html;
        }
    }