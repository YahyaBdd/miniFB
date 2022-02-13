<?php include_once APPROOT . '/views/inc/header.php'; ?>
<div>
    <p align='center'><img src='<?php echo $data['photo']->fichier;?>'></p>
    <p>Photo de <a href="<?php echo URLROOT.'PhotoCtrl/photoDe/'.$_SESSION['photode']?>"><?php echo $_SESSION['photode'];?></a> prise le <?php echo $data['photo']->date_photo;?>.</p>
    <p><?php echo $data['photo']->description;?></p>
</div>
<?php
foreach ($data['commentaires'] as &$comment) { ?>
<div>
    <hr>
    <p><a href="<?php echo URLROOT.'PhotoCtrl/photoDe/'.$comment->auteur;?>"><b><?php echo $comment->auteur;?></b></a> <?php echo $comment->depot;?>:</p>
    <p><?php echo $comment->contenu;?></p>
<!--    <a href="--><?php //echo URLROOT.'CommentCtrl/deleteComment/'.$comment->id;?><!--">Supprimer</a>-->
    <form action='<?php echo URLROOT.'CommentCtrl/deleteComment/'.$comment->id;?>' method='POST'>
        <input type='hidden' name='id' value='<?php echo $data['photo']->id;?>'>
        <p><input type='submit' value='Supprimer'></p>
    </form>

</div>
<?php }?>
<div>
    <form action='<?php echo URLROOT.'CommentCtrl/addComment';?>' method='POST'>
        <h3>Ajouter un commentaire</h3>
        <p><textarea name='contenu' rows='10' cols='60'></textarea></p>
        <input type='hidden' name='id' value='<?php echo $data['photo']->id;?>'>
        <p><input type='submit' value='Ajouter'><input type='reset' value='Vider'></p>
    </form>
</div>
<?php include_once APPROOT . '/views/inc/footer.php'; ?>
