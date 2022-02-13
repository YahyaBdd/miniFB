<?php include_once APPROOT . '/views/inc/header.php'; ?>
<div>
    <img src='<?php echo APPROOT.'/photos/'.$_SESSION['login'].'/'.$data['fichier'];?>'>
    <img src='<?php echo PUBLICROOT.$_SESSION['login'].'/framework.PNG';?>'>
    <?php echo PUBLICROOT?>
    <p>Photo de <?php echo $_SESSION['login'];?> prise le <?php echo $data['date'];?>.</p>
    <p><?php echo $data['description'];?></p>
</div>
<p><a href='<?php echo URLROOT.'UtiliCtrl';?>'>Retour ? l'accueil</a></p>
<?php include_once APPROOT . '/views/inc/footer.php'; ?>
