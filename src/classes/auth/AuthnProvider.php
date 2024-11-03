<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\exception\AuthException;
use iutnc\deefy\repository\DeefyRepository;

class AuthnProvider {
    public static function signin(String $email, String $password): void {
        $repo = DeefyRepository::getInstance();
        $user = $repo->getUserFromEmail($email);
        if (is_null($user)) throw new AuthException("utilisateur inconnu");
        if (!password_verify($password, $user->getHash())) throw new AuthException("mot de passe incorrect");
        $_SESSION['user'] = $user;
    }

    public static function register(String $email, String $password): void{
        $repo = DeefyRepository::getInstance();
        $length = (strlen($password) <= 10);
        $user = $repo->getUserFromEmail($email);
        if(!is_null($user)){
            throw new AuthException("Email existe deja");
        }else if($length){
            throw new AuthException("Le mot de passe doit contenir au moins 10 caractères");
        }else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $repo->insertUser($email, $hash);
        }
    }
}