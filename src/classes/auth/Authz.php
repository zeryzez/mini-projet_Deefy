<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;

class Authz{
    public function checkRole($role): bool{
        if(isset($_SESSION['user'])){
            if($_SESSION['user'].getRole() == $role){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function checkPlaylistOwner($id): bool {
        if (!isset($_SESSION['user'])) {
            return false;
        }
        $repo = DeefyRepository::getInstance();
        $userRoleActuelle = $repo->getUserRolefromId($_SESSION['user']->getId());
        if ($userRoleActuelle == '100') {
            return true;
        }
        $role_user = $repo->getUserRolefromId($repo->getUserIdFromPlaylist($id));
        if ($role_user=="-1") {
            return false;
        }
        if ($role_user == $userRoleActuelle) {
            return true;
        }
        return false;
    }

}