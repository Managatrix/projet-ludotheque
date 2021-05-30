<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Connexion</title>
    <link rel="stylesheet" href="accueilSS.css">
    <link rel="shortcut icon" href="favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
    <nav class="header">
        <ul>
            <li><a href="pageAccueil.php">Accueil</a></li>
            <li><a href="pageConnexion.php">Mes Réservations</a></li>
            <li><a href="pageRecherche.php">Recherche</a></li>
            <li id="admin"><a href="pageAdmin.php">Admin</a></li>
        </ul>
    </nav>
    <form class="connexion" action="pageConnexion.php" method="post">
        <div><label for="identifiant">Identifiant</label></div>
        <div><input type="text" name="identifiant" id="identifiant"></div>
        <div><input type="submit" value="Se Connecter"></div>
    </form>
    <?php
    //paramètres de connexion à la base de données
    $Server = "localhost";
    $User = "root";
    $Pwd = "";
    $DB = "projet-ludotheque";
    //connexion au serveur où se trouve la base de données
    $Connect = mysqli_connect($Server, $User, $Pwd, $DB);
    if (!$Connect) {
        echo "Connexion à la base impossible";
    }

    $Acces = false;
    if (isset($_POST['identifiant'])) {
        //Ecriture de la requête
        $Query = "SELECT * FROM member";
        //Envoi de la requête
        $Result = $Connect->query($Query);
    }
    while ($Data = mysqli_fetch_array($Result)) {
        if ($_POST['identifiant'] == $Data[1]) {
            $Acces = true;
            header('Location: pageReservations.php');
        }
    }
    if ($Acces) {
        header('Location: pageReservations.php');
    }
    mysqli_close($Connect);
    ?>
</body>

</html>