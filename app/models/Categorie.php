<?php
require_once '../app/libraries/Database.php';
class Categorie
{
    public function __construct($login = null, $password = null)
    {
        $this->db = new Database();
    }
    public function getAllCat()
    {
        $this->db->query("select * from categories");
        return $this->db->fetchAll();
    }

    public function addPhotoToCat($id_photo,$id_cat)
    {
        $this->db->query("INSERT INTO cat_photo(photo_id,categorie_id)
                                VALUES(:idPhoto,:idCAt)");
        $this->db->bind(":idPhoto", $id_photo);
        $this->db->bind(":idCAt", $id_cat);
        if ($this->db->execute()) return true;
        else return false;
    }

    public function getPhotoFromCat($id_cat)
    {
        $this->db->query("SELECT photo_id FROM cat_photo WHERE categorie_id=:cat");
        $this->db->bind(":cat",$id_cat);
        return $this->db->fetchAll();
    }

    public function getCatID($cat_name)
    {
        $this->db->query("select id from categories where nom =:name");
        $this->db->bind(":name",$cat_name);
        return $this->db->fetch();
    }

}