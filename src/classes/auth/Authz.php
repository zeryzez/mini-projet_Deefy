<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;

class Authz{
    public function checkRole($role): bool{
        if(isset($_SESSION['user'])){
            if($_SESSION['user']['role'] == $role){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function checkPlaylistOwner($id): bool {
        $userIdActuelle = $_SESSION['user']->getId();
        if ($userIdActuelle == '100') {
            return true;
        }
        $repo = DeefyRepository::getInstance();
        $id_user = $repo->getUserIdFromPlaylist($id);
        if ($id_user=="-1") {
            return false;
        }
        if ($id_user == $userIdActuelle) {
            return true;
        }
        return false;
    }

}