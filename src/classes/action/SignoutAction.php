<?php

namespace iutnc\deefy\action;

class SignoutAction extends Action {
    public function execute() : string {
        session_destroy();
        return "<h2>Vous êtes déconnecté</h2>";
    }
}
