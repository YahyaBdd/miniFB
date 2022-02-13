<?php include_once APPROOT . '/views/inc/header.php'; ?>
<form action="<?php echo URLROOT; ?>UtiliCtrl/auth" method="POST">
<p>Connexion au site:</p>
<table>
    <tr>
        <td>Identifiant:</td>
        <td><input type="text" name="login" size="32" maxlength="128"></td>
    </tr>
    <tr>
        <td>Mot de passe:</td>
        <td><input type="password" name="password" size="32" maxlength="32"></td>
    </tr>
    <tr><td colspan="2" align="center">
            <input type="submit" value="Se connecter">
            <input type="reset" value="Effacer">
        </td></tr>
</table>
</form>
<hr>
<p><a href="inscription.html">S'inscrire</a></p>
<?php include_once APPROOT . '/views/inc/footer.php'; ?>
