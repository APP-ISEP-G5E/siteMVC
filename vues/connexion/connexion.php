<div id="connexion">
    <h1 class="connex">Connexion</h1>
    <form method="POST" action="index.php">
        <label for="username"><?php echo _NOM_UTILISA; ?></label>
        <input type="text" id="username" name="connex_login" placeholder="username">

        <label for="password"><?php echo _MDP; ?></label>
        <input type="password" id="password" name="connex_mdp" placeholder="password">

        <input type="checkbox" id="souvenir" value="Rester connecté"/>
        <label for="souvenir"><?php echo _SOUVENIR; ?></label></br>
        <input type="hidden" name="cible" value="utilisateurs"/>
        <input type="hidden" name="fonction" value="connexion"/>
        <input type="submit" value="SUBMIT">
    </form>
</div>
<div id="espace">

</div>

