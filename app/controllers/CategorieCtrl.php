<?php
require_once '../app/libraries/Controllers.php';
require_once '../app/libraries/boite_outils.php';
class CategorieCtrl extends Controllers
{
    public function __construct()
    {
        $this->catModel = $this->model('Categorie');
        $this->photoModel = $this->model('Photo');
    }

    public function affiche($param)
    {
        $photos = array(array());
        $catID = $this->catModel->getCatID($param);
        $photosID = $this->catModel->getPhotoFromCat($catID->id);
        foreach ($photosID as $item){
            $photo = $this->photoModel->getPhotoById($item->photo_id);
            array_push($photos,$photo);
        }
        $data = [
            'photos' => $photos
        ];
        $this->view("photo/lister",$data);
    }
}