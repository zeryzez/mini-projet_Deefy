<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\exception\AuthException;
use iutnc\deefy\repository\DeefyRepository;

class AuthnProvider {
    public static function signin(String $email, String $password): void {
        $repo = DeefyRepository::getInstance();
        $user = $repo->getUserFromEmail($email);
        if (is_null($user)) throw new AuthException("Auth error : invalid credentials");
        if (!password_verify($password, $user->getHash())) throw new AuthException("Auth error : invalid credentials");
        $_SESSION['user'] = $user;
        return;
    }

    public static function register(String $email, String $password): void{
        $repo = DeefyRepository::getInstance();
        $length = (strlen($password) <= 10);
        $user = $repo->getUserFromEmail($email);
        if(!is_null($user)){
            throw new AuthException("Email already exists");
        }else if($length){
            throw new AuthException("Le mot de passe doit contenir au moins 10 caractères");
        }else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $repo->insertUser($email, $hash);
        }
    }

    public function getSignedInUser(){
        session_start();
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }else{
            throw new AuthException("Aucun utilisateur connecté");
        }
    }
}