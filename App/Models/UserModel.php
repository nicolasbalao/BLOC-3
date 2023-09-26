<?php


namespace App\Models;

class UserModel extends Model
{

    protected $id;
    protected $email;
    protected $password;

    public function __construct()
    {
        $this->table = "users";
    }

    public function setSession()
    {

        $_SESSION["user"] = [
            "id" => $this->id,
            "email" => $this->email
        ];
    }

    public function findOneByEmail(string $email)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE email=?", [$email])->fetch();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        return $this->password = $password;
    }
}
