<?php
require_once '../app/libraries/Controllers.php';
require_once '../app/libraries/boite_outils.php';
class CommentCtrl extends Controllers
{
    public function __construct()
    {
        $this->commentModel = $this->model('Commentaire');
    }

    public function addComment()
    {
        echo $_POST['contenu'];
        echo $_POST['id'];
        $this->commentModel->addComment($_POST['id'],$_POST['contenu']);

        redirect('PhotoCtrl/afficheById/'.$_POST['id']);
    }

    public function deleteComment($param)
    {
        //echo $param;
        $this->commentModel->deleteComment($param);
        redirect('PhotoCtrl/afficheById/'.$_POST['id']);
    }
}