<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Connexion</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="shortcut icon" href="favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
    ?>
</head>

<body>
    <nav class="header">
        <ul>
            <li><a href="pageAccueil.htm">Accueil</a></li>
            <li><a href="pageConnexion.php">Mes Réservations</a></li>
            <li><a href="pageRecherche.php">Recherche</a></li>
            <li id="admin"><a href="pageAdmin.php">Admin</a></li>
        </ul>
    </nav>
    <h1 class="title">Mon espace reservations</h1>
    <form class="connexion" action="" method="post">
        <div><label for="identifiant">Identifiant</label></div>
        <div><input type="text" name="identifiant" id="identifiant"></div>
        <div><input type="submit" value="Se Connecter"></div>
    </form>
    <?php
    $Acces = false;
    if (isset($_POST['identifiant'])) {
        $Query = "SELECT Name FROM member WHERE Name = '$_POST[identifiant]'";
        $Result = $Connect->query($Query);

        if (mysqli_num_rows($Result) != 0) {
            $locationString = "Location: pageReservations.php?member=".$_POST['identifiant'];
            header($locationString);
        } else {
            echo "<center class='failure'>Connexion échouée</center>";
        }
    }
    mysqli_close($Connect);
    ?>
</body>

</html>