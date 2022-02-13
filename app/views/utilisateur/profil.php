<?php include_once APPROOT . '/views/inc/header.php'; ?>

<h2> Bienvenue <?php echo $_SESSION['login'];?></h2>
<h3>Voir les photos de:</h3>
<ul>
<?php
foreach ($data['users'] as &$user) {
    echo '<li><a href=\''.URLROOT.'UtiliCtrl/photoPersonne/'.$user->login.'\'>'.$user->login.'</a></li>';

}
?>
</ul>
<h3>photos par categorie:</h3>
<ul>
    <?php
    foreach ($data['categories'] as &$cat) {
        echo '<li><a href=\''.URLROOT.'CategorieCtrl/affiche/'.$cat->nom.'\'>'.$cat->nom.'</a></li>';
    }
    ?>
</ul>
<hr>
<h3>Ajouter une photo � ma collection</h3>
<form action="<?php echo URLROOT; ?>PhotoCtrl/add" method="POST" enctype="multipart/form-data" name="add_photo">
    <p>Fichier de la photo: <input type="file" name="photo" size=30></p>
    <p>Description de la photo:</p>
    <p><textarea name="description" rows="10" cols="60">Entrez la description de la photo ici.
	</textarea></p>
    <p>Date de la photo: <? input_date('date_photo','add_photo'); ?></p>
    <label>Choisir categorie: </label>
    <select name="cat">
        <option  value="sport" >Sport</option>
        <option  value="cuisine">Cuisine</option>
        <option  value="lecture">Lecture</option>
        <option  value="humeur">Humeur</option>
        <option  value="voyage">Voyage</option>
    </select>
    <p>
        <input type="submit" value="Ajouter la photo">
        <input type="reset" value="Annuler">
    </p>

</form>

<?php include_once APPROOT . '/views/inc/footer.php'; ?>
