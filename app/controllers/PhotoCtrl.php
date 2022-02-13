<?php
require_once '../app/libraries/Controllers.php';
require_once '../app/libraries/boite_outils.php';

class PhotoCtrl extends Controllers
{

    public function __construct()
    {
        $this->photoModel = $this->model('Photo');
        $this->catModel = $this->model('Categorie');
        $this->commentModel = $this->model('Commentaire');
    }

    public function add()
    {
        if (isset($_POST['description'])) {
            $description = addslashes($_POST['description']);
        } else {
            $description = "";
        }


        if (isset($_POST['date_photo'])) {
            $date_photo = verifie_date($_POST['date_photo']);
        } else {
            $date_photo = date('Y-m-d');
        }

        $fichier = sauve_photo('photo');

        if ($fichier != null) {

            $photo = [
                'fichier' => $fichier,
                'date' => $date_photo,
                'description' => $description,
                'proprietaire' => $_SESSION['login']
            ];

            if($this->photoModel->addPhoto($photo)){
                if (isset($_POST['cat'])){
                    $this->catModel->addPhotoToCat($this->photoModel->getLastId(),$this->catModel->getCatID($_POST['cat'])->id);
                };
                $lien = explode("\\",$fichier);
                $data = [
                    'fichier' => end($lien),
                    'date' => $date_photo,
                    'description' => $description,
                    'proprietaire' => $_SESSION['login']
                ];

                $this->view("photo/affiche",$data);
            };

        }	else {
            print "<p><b>Echec de l'ajout de la photo !!!</b></p>";
        }
    }

    public function edit()
    {
        
    }

    public function afficheById($param)
    {

        $photo = $this->photoModel->getPhotoById($param);
        $commentaires=$this->commentModel->getPhotoComment($param);

        $data = [
            'photo' => $photo,
            'commentaires' => $commentaires
        ];
        $this->view("photo/photoWithComment",$data);
    }

    public function photoDe($param)
    {

        $photos = $this->photoModel->getPhotoByLogin($param);
        $data = [
            'photos' => $photos
        ];

        $this->view("photo/lister",$data);
    }

}