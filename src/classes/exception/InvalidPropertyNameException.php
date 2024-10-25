<?php
namespace iutnc\deefy\exception;

class InvalidPropertyNameException extends \Exception{
    public function __construct(String $message){
        parent::__construct($message);
    }
}
