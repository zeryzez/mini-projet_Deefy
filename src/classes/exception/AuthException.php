<?php

namespace iutnc\deefy\exception;

class AuthException extends \Exception{
    public function __construct(String $message){
        parent::__construct($message);
    }
}