<?php

if (session_status() != 2) {
    session_start();
}

include('./modele/requetes.utilisateurs.php');

// si la fonction n'est pas définie, on choisit d'afficher l'accueil
if (!isset($_GET['fonction']) || empty($_GET['fonction'])) {
    $function = "accueil";
} else {
    $function = htmlspecialchars($_GET['fonction']);
}

if (!isset($_SESSION['connecter']) || empty($_SESSION['connecter'])) {
    $_SESSION['connecter'] = _CONNEXION;
} else {
    $_SESSION['connecter'] = $_SESSION['connecter'];
}

if (!isset($_SESSION['type']) || empty($_SESSION['type'])) {
    $_SESSION['type'] = 'null';
}
$alerte = false;

switch ($function) {

    case 'accueil':
        $title = "Accueil";
        if ($_SESSION['type'] == 'null') {
            $css = "accueil/CSSaccueil";
            $vue = "accueil/accueil";
        } elseif ($_SESSION['type'] == 'candidat') {
            $css = "accueil/CSSaccueil";
            $vue = "accueil/accueilClient";
        } elseif ($_SESSION['type'] == 'gestionnaire') {
            $css = "accueil/CSSnav";
            $vue = "accueil/accueilGestionnaire";
        } elseif ($_SESSION['type'] == 'admin') {
            $css = "accueil/CSSnav";
            $vue = "accueil/accueilAdmin";
        }
        $donneesQSN = recupereTous($bdd, "donneesfixes");
        break;

    case 'contacter':
        $css = "header/CSSlegal";
        $vue = "header/nousContacter";
        $title = "Nous Contacter";
        $donneesNousContacter = recupereTous($bdd, "donneesfixes");
        break;

    case 'cgu':
        $css = "header/CSSlegal";
        $vue = "header/cgu";
        $title = "CGU";
        $donneesCGU = recupereTous($bdd, "donneesfixes");
        break;

    case 'mentionLegale':
        $css = "header/CSSlegal";
        $vue = "header/mentionLegale";
        $title = "Mentions légales";
        $donneesML = recupereTous($bdd, "donneesfixes");
        break;

    case 'langue':
        $vue = "accueil/accueil";
        $css = "accueil/CSSaccueil";
        $title = "Accueil";
        if ($_SESSION['lang'] == "fr") {
            $_SESSION['lang'] = "en";
        } elseif ($_SESSION['lang'] == "en") {
            $_SESSION['lang'] = "fr";
        }
        break;

    case 'connexion':
        if ($_SESSION['connecter'] == _CONNEXION) {
            $css = "connexion/CSSconnexion";
            $vue = "connexion/connexion";
            $title = "Connexion";
            // Cette partie du code est appelée si le formulaire a été posté
            if (isset($_POST['connex_login']) and isset($_POST['connex_mdp'])) {
                $values = [
                    'username' => htmlspecialchars($_POST['connex_login']),
                    'password' => htmlspecialchars($_POST['connex_mdp'])
                ];
                $connexion = bddContient($bdd, $values);
                if ($connexion['mot_de_passe'] == HachagePassword(htmlspecialchars($_POST['connex_mdp']))) {
                    $_SESSION['connecter'] = _DECONNEXION;
                    $_SESSION['type'] = $connexion['type'];
                    $_SESSION['nom'] = $connexion['nom'];
                    $_SESSION['prenom'] = $connexion['prenom'];
                    $_SESSION['numero_telephone'] = $connexion['numero_telephone'];
                    $_SESSION['email'] = $connexion['adresse_mail'];
                    $_SESSION['login'] = $connexion['login'];
                    $_SESSION['id'] = $connexion['id'];
                    if ($connexion['type'] == 'admin') {
                        $css = "accueil/CSSnav";
                        $vue = "accueil/accueilAdmin";
                        $title = "Accueil Admin";
                    } elseif ($connexion['type'] == 'gestionnaire') {
                        $css = "accueil/CSSnav";
                        $vue = "accueil/accueilGestionnaire";
                        $title = "Accueil Gestionnaire";
                    } elseif ($connexion['type'] == 'candidat') {
                        $css = "accueil/CSSaccueil";
                        $vue = "accueil/accueilClient";
                        $title = "Accueil";
                        $donneesQSN = recupereTous($bdd, "donneesfixes");   //sinon dès qu'on se connecte en tant que candidat, le contenu de QSN bug
                    }
                } else {
                    $alerte = "Login ou mot de passe incorrect";
                }

            }
        } else {
            $css = "connexion/CSSconnexion";
            $vue = "connexion/deconnexion";
            $title = "Deconnexion";
            $_SESSION['connecter'] = _CONNEXION;
            session_destroy();
        }
        break;

    case 'faq':
        $title = "FAQ";
        $vue = "faq/faq";
        $css = "faq/CSSfaq";
        $donneesfaq = recupereTous($bdd, "faq");
        break;

    default:
        // si aucune fonction ne correspond au paramètre function passé en GET
        $vue = "erreur404";
        $css = "CSSerreur";
        $title = "error404";
        $message = "Erreur 404 : la page recherchée n'existe pas.";
}

include('vues/header/header.php');
include('vues/' . $vue . '.php');
if ($vue == 'accueil/accueil' or $vue == 'accueil/accueilClient') {
    include('vues/header/footer.php');
} else {
    include('vues/header/footerFixed.php');
}
