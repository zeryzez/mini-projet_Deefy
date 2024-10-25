<?php
namespace iutnc\deefy\tools;

class User{
    private string $id;
    private string $email;
    private string $role;
    private string $hash;

    public function __construct(string $id, string $email, string $role, string $hash){
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
        $this->hash = $hash;
    }

    public function getId(): string{
        return $this->id;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getRole(): string{
        return $this->role;
    }

    public function getHash(): string{
        return $this->hash;
    }

}