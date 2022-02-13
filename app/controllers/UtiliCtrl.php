<?php
require_once '../app/libraries/Controllers.php';

class UtiliCtrl extends Controllers
{
    public function  __construct()
    {

        $this->userModel = $this->model('Utilisateur');
        $this->photoModel = $this->model('Photo');
        $this->catModel = $this->model('Categorie');
    }

    public function index(){
        if (!isset($_SESSION['login'])){
           $this->view("utilisateur/login");
        } else {
            $categories = $this->catModel->getAllCat();
            $users = $this->userModel->getAllUsers();
            $data = [
                'categories' => $categories,
                'users' => $users
            ];
            $this->view("utilisateur/profil",$data);
        }


    }

    public function auth()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->userModel->auth($_POST['login'],$_POST['password'])){
                $_SESSION['login'] = $_POST['login'];
                $data = $this->userModel->getAllUsers();
                //print_r($data[0]->login);
                $this->view("utilisateur/profil",$data);

            }
        }
    }

    public function photoPersonne($param)
    {

        $photosByDate=$this->photoModel->getByUser($param);
        $_SESSION['photode']=$param;
        $data =[
            'user' => $param,
            'photos'=> $photosByDate
        ];
        $this->view("photo/photoPersonne",$data);
    }

    public function deconnect()
    {
        session_unset();
        session_destroy();
        redirect('');
    }
}