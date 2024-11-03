<?php

namespace iutnc\deefy\action;

class SignoutAction extends Action {
    public function execute() : string {
        session_destroy();
        return "<p>Vous êtes déconnecté</p>";
    }
}
