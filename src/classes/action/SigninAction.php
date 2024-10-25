<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class SigninAction extends Action{
    public function execute() : string{
        session_start();
        $html = " ";
        if($this->http_method === 'GET'){
            $html .= <<<END
            <form action="?action=signin" method="POST">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <input type="submit" value="Submit">
            </form>
            END;
        }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = filter_var($_POST['email']);
            $password = filter_var($_POST['password']);
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