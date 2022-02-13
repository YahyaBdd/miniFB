<?php
require_once '../app/libraries/Database.php';
class Commentaire
{
    public $db;



    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPhotoComment($id)
    {
        $this->db->query("SELECT * FROM commentaire WHERE id_photo=:id;");
        $this->db->bind(':id',$id);
        return $this->db->fetchAll();
    }

    public function addComment($id,$content)
    {
        $this->db->query("INSERT INTO commentaire (contenu,id_photo,auteur) VALUES (:contenu,:id,:auth)");
        $this->db->bind(':contenu',$content);
        $this->db->bind(':id',$id);
        $this->db->bind(':auth',$_SESSION['login']);
        $this->db->execute();
    }

    public function deleteComment($id)
    {
        $this->db->query("DELETE FROM commentaire WHERE id=:id");
        $this->db->bind(':id',$id);
        $this->db->execute();
    }
}