
<div id="contenuAccueil">
    <h1 class="suppCapteur">Supprimer un Capteur</h1>
    <div id="blocSupprimer">
        <form class="formSupprimer"action="" method="POST">
            <div>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]); ?>"/>
                <label>Êtes-vous sure de vouloir supprimer ce capteur ?</label>
                <p>
                    <input type="submit" value="Oui">
                    <a class="styleBTN" href="index.php?cible=admin&fonction=capteur">Non</a>
                </p>
            </div>
        </form>
    </div>
</div>
</div>