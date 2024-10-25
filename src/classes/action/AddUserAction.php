<?php
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
    class AddUserAction extends Action{

        public function execute() : String{
            session_start();
            $html = " ";
            if($this->http_method === 'GET'){
                $html .= <<<END
                <form action='?action=add-user' method='POST'>
                     <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="cemail">Confirmez votre Email:</label>
                    <input type="email" id="cemail" name="cemail" required>

                     <label for="mdp">Mot de passe:</label>
                    <input type="password" id="mdp" name="mdp" required>

                    <label for="cmdp">Confirmez Mot de passe:</label>
                    <input type="password" id="cmdp" name="cmdp" required>

                    <input type="submit" value="Inscription">
                </form>
                END;
            }else if($_SERVER['REQUEST_METHOD']==='POST'){
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $cemail = filter_var($_POST['cemail'], FILTER_SANITIZE_EMAIL);
                $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_STRING);
                $cmdp = filter_var($_POST['cmdp'], FILTER_SANITIZE_STRING);

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
                    }catch(\AuthException $e){
                        $html .= "Erreur: veuillez réessayer";
                    }
                }
            }
            return $html;
        }
    }