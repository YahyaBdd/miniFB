<?php include_once APPROOT . '/views/inc/header.php'; ?>

<h2>Photos de <?php echo $data['user'];?> trier par dates:</h2>
<ol>
<?php
foreach ($data['photos'] as &$photo) {

    echo '<li><a href=\''.URLROOT.'PhotoCtrl/afficheById/'.$photo->id.'\'>'.$photo->description.'</a></li>';

}
?>
</ol>

<?php include_once APPROOT . '/views/inc/footer.php'; ?>

