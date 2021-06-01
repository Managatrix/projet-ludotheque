<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Admin</title>
    <link rel="stylesheet" href="accueilSS.css">
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

    <?php
    //Ecriture de la requête
    $Query = "SELECT COUNT(*) FROM game";
    //Envoi de la requête
    $Result = $Connect->query($Query);
    $DataGame = mysqli_fetch_array($Result);
    ?>

    <nav class="header">
        <ul>
            <li><a href="pageAccueil.php">Accueil</a></li>
            <li><a href="pageConnexion.php">Mes Réservations</a></li>
            <li><a href="pageRecherche.php">Recherche</a></li>
            <li class="active" id="admin"><a href="pageAdmin.php">Admin</a></li>
        </ul>
    </nav>
    <div class="col">
        <h3 class="formTitle">Ajouter une nouvelle fiche de jeu</h3>
        <form action="pageAdmin.php" method="post">
            <ul>
                <li>
                    <label for="gameName">Nom du jeu</label>
                    <input type="text" id="gameName" name="gameName">
                </li>
                <li>
                    <label for="gameType">Type de jeu</label>
                    <input type="text" id="gameType" name="gameType">
                </li>
                <li>
                    <label for="minAge">Age minimum</label>
                    <input type="number" id="minAge" name="minAge" value="0">
                </li>
                <li>
                    <label for="maxAge">Age maximum</label>
                    <input type="number" id="maxAge" name="maxAge" value="100">
                </li>
                <li>
                    <label for="abstract">Description</label>
                    <textarea name="abstract" id="abstract" cols="21" rows="7"></textarea>
                </li>
                <li>
                    <input type="submit" class="submitButton" value="Creer la fiche de jeu">
                </li>
            </ul>

            <?php
            if (isset($_POST['gameName'])) {
                //Ecriture de la requête
                $idJeu = $DataGame[0] + 1;
                $imagePath = $_POST['gameName'] . "Image.jpg";
                $Query = "INSERT INTO game (IDGame, Name, AgeMin, AgeMax, Type, Abstract, ImagePath, NbPersonnes) VALUES ($idJeu, '$_POST[gameName]', $_POST[minAge], $_POST[maxAge], '$_POST[gameType]', '$_POST[abstract]', '$imagePath', NULL)";
                // echo $Query;
                if (strpos($_POST['abstract'], "'") !== false) {
                    echo "</br></br>Reqête invalide car apostrophe dans description";
                }
                //Envoi de la requête
                $Connect->query($Query);
            }
            ?>

    </div>
    <div class="col">
        </form>
        <h3 class="formTitle">Ajouter un nouveau membre</h3>
        <form action="pageAdmin.php" method="post">
            <ul>
                <li>
                    <label for="memberName">Nom</label>
                    <input type="text" id="memberName" name="memberName">
                </li>
                <li>
                    <label for="memberAddress">Adresse mail</label>
                    <input type="text" id="memberAddress" name="memberAddress">
                </li>
                <li>
                    <input type="submit" class="submitButton" value="Creer le membre">
                </li>
            </ul>
        </form>
        <?php
        $Query = "SELECT COUNT(*) FROM member";
        //Envoi de la requête
        $Result = $Connect->query($Query);
        $DataMember = mysqli_fetch_array($Result);
        if (isset($_POST['memberName'])) {
            //Ecriture de la requête
            $idMembre = $DataMember[0] + 1;
            $Query = "INSERT INTO member (IDMember, Name, EMailAddress) VALUES ($idMembre, '$_POST[memberName]', '$_POST[memberAddress]')";
            // echo $Query;
            //Envoi de la requête
            $Connect->query($Query);
        }
        mysqli_close($Connect);
        ?>
    </div>
</body>

</html>