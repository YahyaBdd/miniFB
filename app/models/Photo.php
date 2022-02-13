<?php
require_once '../app/libraries/Database.php';
class Photo
{
    public $db;
    //public $id,$fichier,$date_photo,$description,$proprietaire;


    public function __construct()
    {
        $this->db = new Database();
    }

    public function addPhoto($post)
    {
        $this->db->query("INSERT INTO photo(fichier, date_photo, description, proprietaire) VALUES (:fichier,:date,:description,:proprietaire)");
        $this->db->bind(":fichier", $post['fichier']);
        $this->db->bind(":date", $post['date']);
        $this->db->bind(":description", $post['description']);
        $this->db->bind(":proprietaire", $post['proprietaire']);

        if ($this->db->execute()) return true;
        else return false;
    }

    public function getLastId()
    {
        $this->db->query("select * from photo");
        $rs = $this->db->fetchAll();
        return end($rs)->id;
    }

    public function getByUser($user)
    {
        $this->db->query("SELECT * FROM photo where proprietaire =:user ORDER BY date_photo DESC;");
        $this->db->bind(":user", $user);
        $rs = $this->db->fetchAll();
        return $rs;
    }

    public function getPhotoById($id)
    {
        $this->db->query("SELECT * FROM photo where id =:id ;");
        $this->db->bind(":id", $id);
        return $this->db->fetch();
    }

    public function getPhotoByLogin($login)
    {
        $this->db->query("SELECT * FROM photo where proprietaire =:id ;");
        $this->db->bind(":id", $login);
        return $this->db->fetchAll();
    }

}