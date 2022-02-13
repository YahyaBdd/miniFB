<?php
require_once '../app/libraries/Database.php';
class Utilisateur
{
    private $db;


    public function __construct()
    {
        $this->db = new Database();

    }

    public function auth($login,$pass)
    {
        $this->db->query("select * from utilisateur where login=:login and password=:pass");
        $this->db->bind(":login",$login);
        $this->db->bind(":pass",$pass);
        $this->db->execute();
        if ($this->db->rowCount()) return true;
        else return false;
    }

    public function getAllUsers()
    {
        $this->db->query("select login from utilisateur");
        $rs  = $this->db->fetchAll();
        return $rs;
    }


}