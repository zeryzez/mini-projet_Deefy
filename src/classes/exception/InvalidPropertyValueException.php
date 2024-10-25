<?php
namespace iutnc\deefy\exception;
class InvalidPropertyValueException extends \Exception{
    public function __construct(String $message){
        parent::__construct($message);
    }
}