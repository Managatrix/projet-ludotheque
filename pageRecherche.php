<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Recherche</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="shortcut icon" href="favicon.ico">
    <script src="afficherInfos.js"></script>

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
            <li class="active"><a href="pageRecherche.php">Recherche</a></li>
            <li id="admin"><a href="pageAdmin.php">Admin</a></li>
        </ul>
    </nav>
    <table class="lcolumn">
        <tr>
            <td id="filtresBox">
                <ul class="filtres">
                    <form action="" method="POST">
                        <li>
                            <h4>Filtres</h4>
                        </li>
                        <!-- <li>
                            <label for="nbPersonnes">Nombre de personnes</label>
                            <input class="inputBar" id="nbPersonnes" name="nbPersonnes" type="number" value="">
                        </li> -->
                        <li>
                            <label>Type de jeu</label>
                            <ul class="sousFiltres">
                                <?php
                                $checks = array();
                                //Ecriture de la requête
                                $QueryTypes = "SELECT * FROM game";
                                //Envoi de la requête                                
                                $ResultTypes = $Connect->query($QueryTypes);
                                while ($Data = mysqli_fetch_array($ResultTypes)) { // Create checkbox filters according to DB
                                    if (array_search($Data[4], $checks) === false) { //Checks if type isn't already present in $checks array
                                        $idType = "check" . $Data[4];
                                        echo "<li><input type='checkbox' id='$idType' name='checkbox[]' value='$Data[4]'><label for='$idType'>$Data[4]</label></li>";
                                        array_push($checks, $Data[4]);
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <!-- <li>
                            <label>Disponibilité</label>
                            <ul class="sousFiltres">
                                <li><input type="checkbox" id="checkStock" name="checkStock"><label for="checkStock">En stock</label></li>
                                <li><input type="checkbox" id="checkAlmostStock" name="checkAlmostStock"><label for="checkAlmostStock">Bientôt en stock</label></li>
                            </ul>
                        </li> -->
                        <li>
                            <label>Tranche d'âge</label>
                            <ul class="sousFiltres">
                                <li>
                                    <label for="ageMin">Age min</label>
                                    <input class="inputBar" id="ageMin" name="ageMin" type="number" value="0">
                                </li>
                                <li>
                                    <label for="ageMax">Age max</label>
                                    <input class="inputBar" id="ageMax" name="ageMax" type="number" value="100">
                                </li>
                            </ul>
                        </li>
                        <li>
                            <input type="submit" value="Filtrer">
                        </li>
                    </form>
                </ul>
            </td>
            <td>
                <div>
                    <table>
                        <tr>
                            <form action="" method="POST">
                                <td><input type="text" id="recherche" name="recherche" class="searchBar"></td>
                                <td><input type="submit" value="Recherche"></td>
                            </form>
                        </tr>
                        <tr>
                            <table class="resultats">
                                <tr>
                                    <script>
                                        let gamesArray = [0]; //Initialisation avec 0 pour que l'indice corresponde avec l'IDGame
                                        let gameObject = [];
                                    </script>

                                    <?php
                                    $nbColonnesMax = 5;

                                    $nbColonnes = 0;
                                    $numJeu = 1;
                                    //Traitement de la réponse

                                    if (isset($_POST['recherche'])) {
                                        $Query = "SELECT * FROM game WHERE Abstract LIKE '%$_POST[recherche]%' OR Name like '%$_POST[recherche]%' OR Type LIKE '%$_POST[recherche]%'";
                                    } else if (isset($_POST['ageMin'])) { //Création de la requête filtrée par les checkboxes
                                        $checkboxSQL = "";
                                        if (isset($_POST['checkbox'])) {
                                            foreach ($_POST["checkbox"] as $index => $checkbox) {
                                                if ($checkboxSQL == "") {
                                                    $checkboxSQL = "AND Type IN ('";
                                                }
                                                $checkboxSQL .= $checkbox . "', '";
                                            }
                                            if ($checkboxSQL != "") {
                                                $checkboxSQL = rtrim($checkboxSQL, ", '");
                                                $checkboxSQL .= "')";
                                            }
                                        }
                                        $Query = "SELECT * FROM game WHERE AgeMin >= $_POST[ageMin] AND AgeMax <= $_POST[ageMax] " . $checkboxSQL;
                                    } else {
                                        $Query = "SELECT * FROM game";
                                    }

                                    $Result = $Connect->query($Query);

                                    while ($Data = mysqli_fetch_array($Result)) {
                                    ?>
                                        <script>
                                            gameObject = {
                                                IDGame: <?php echo $Data[0]; ?>,
                                                Name: "<?php echo $Data[1]; ?>",
                                                AgeMin: <?php echo $Data[2]; ?>,
                                                AgeMax: <?php echo $Data[3]; ?>,
                                                Type: "<?php echo $Data[4]; ?>",
                                                Abstract: "<?php echo $Data[5]; ?>"
                                            }
                                            gamesArray.push(gameObject);
                                        </script>
                                    <?php
                                    }

                                    $Result = $Connect->query($Query);

                                    while ($Data = mysqli_fetch_array($Result)) {
                                        if ($nbColonnes < $nbColonnesMax) {
                                            $stringIDJeu = "jeu" . $numJeu;
                                            $stringHref = "#?idJeu=" . $Data[0];
                                            echo "
                                            <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                            $nbColonnes++;
                                            $numJeu++;
                                        } else {
                                            $stringIDJeu = "jeu" . $numJeu;
                                            $stringHref = "#?idJeu=" . $Data[0];
                                            echo "</tr><tr>
                                            <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                            $nbColonnes = 1;
                                            $numJeu++;
                                        }
                                    }
                                    ?>
                                </tr>
                            </table>
                        </tr>
                    </table>
                </div>
            </td>
            <td>
            </td>
            <!-- </tr> -->
    </table>
    <div class="rcolumn">
        <h4>Jeu selectionné : </h4>
        <p id="nomJeuSelectionne"></p>
        <h4>Description : </h4>
        <p id="descriptionJeuSelectionne"></p>
        <h4>Type de jeu : </h4>
        <p id="typeJeuSelectionne"></p>
        <h4>Tranche d'age : </h4>
        <p id="trancheAgeJeuSelectionne"></p>
        <form action="" method="post">
            <label for="identifiant">Identifiant</label>
            <input type="text" name="identifiant" id="identifiant">
            <input type="submit" name="reserveButton" id="reserveButton" value="Réserver">
        </form>
    </div>
    <?php
    if (isset($_POST["reserveButton"])) {
        if ($_POST['identifiant'] == null) {
            echo "<center class='failure'>Il faut se connecter!</center>";
        } else {
            $Query = "SELECT Name FROM member WHERE Name = '$_POST[identifiant]'";
            $Result = $Connect->query($Query);
            if (mysqli_num_rows($Result) != 0) { //If connexion successful
                $today = date('Y-m-d');
                $tomorrowRaw = mktime(0, 0, 0, date('m') + 1, date('d'), date('Y'));
                $tomorrow = date('Y-m-d', $tomorrowRaw);

                $Query = "SELECT IDMember FROM member WHERE Name = '$_POST[identifiant]'"; //Correspondance IDMember avec Name
                $Result = $Connect->query($Query);
                $idMember = mysqli_fetch_array($Result);

                $Query = "SELECT IDGame FROM booking WHERE IDMember = $idMember[0] AND IDGame = $_GET[idJeu]";
                $Result = $Connect->query($Query);
                if (mysqli_num_rows($Result) != 0) { //If game already booked by user
                    echo "<center class='failure'>Echec de la réservation : vous avez déjà réservé ce jeu</center>";
                } else {
                    $Query = "SELECT IDGame FROM booking WHERE IDMember = $idMember[0]";
                    $Result = $Connect->query($Query);
                    if (mysqli_num_rows($Result) >= 3) { //If member has already more than 3 bookings
                        echo "<center class='failure'>Echec de la reservation : vous avez déjà 3 réservations</center>";
                    } else {
                        $Query = "INSERT INTO booking (IDMember, IDGame, Date, ReturnDate) VALUES ($idMember[0], $_GET[idJeu], '$today', '$tomorrow')";
                        $Connect->query($Query);
                        echo "<center class='success'>Reservation pour 1 mois prise en compte</center>";
                    }
                }
            } else {
                echo "<center class='failure'>Connexion échouée</center>";
            }
        }
    }
    // while($Data = mysqli_fetch_array($Result))
    // {
    //     echo "IDGame : $Data[0], Name : $Data[1], AgeMin : $Data[2], AgeMax : $Data[3], Type : $Data[4], Abstract : $Data[5], ImagePath : $Data[6]</br></br>";
    // }
    mysqli_close($Connect);
    ?>
</body>

</html>