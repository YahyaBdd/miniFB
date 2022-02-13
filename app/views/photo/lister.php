<?php include_once APPROOT . '/views/inc/header.php'; ?>
<?php
foreach ($data['photos'] as &$photo) { ?>
    <img src="<?php echo $photo->fichier;?>">
    <h4>Prise le <?php echo $photo->date_photo;?></h4>
    <p><?php echo $photo->description;?></p>
    <br>
    <hr>
<?php }?>

<?php include_once APPROOT . '/views/inc/footer.php'; ?>
