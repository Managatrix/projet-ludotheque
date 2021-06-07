<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Mes Réservations</title>
    <link rel="stylesheet" href="accueilSS.css">
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
            <li><a href="pageAccueil.php">Accueil</a></li>
            <li class="active"><a href="pageConnexion.php">Mes Réservations</a></li>
            <li><a href="pageRecherche.php">Recherche</a></li>
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
                            <input type="submit" value="OK">
                        </li>
                    </form>
                </ul>
            </td>
            <td>
                <div>
                    <table>
                        <tr>
                            <form action="" method="POST">
                                <td><input type="text" id="recherche" name="recherche"></td>
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
                                    //Ecriture de la requête
                                    $Query = "SELECT * FROM game";
                                    //Envoi de la requête
                                    $Result = $Connect->query($Query);

                                    $nbColonnesMax = 4;

                                    $nbColonnes = 0;
                                    $numJeu = 1;
                                    //Traitement de la réponse

                                    // /!\ UTILISER AJAX POUR LES FONCTION ONCLICK


                                    if (isset($_POST['recherche'])) {
                                        $Query = "SELECT * FROM game INNER JOIN booking ON game.IDGame = booking.IDGame INNER JOIN member ON member.IDMember = booking.IDMember WHERE member.Name = '$_GET[member]' AND Abstract LIKE '%$_POST[recherche]%' OR game.Name like '%$_POST[recherche]%' OR Type LIKE '%$_POST[recherche]%'";
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
                                                $stringHref = "?idJeu=" . $Data[0];
                                                echo "
                                                    <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes++;
                                                $numJeu++;
                                            } else {
                                                $stringIDJeu = "jeu" . $numJeu;
                                                $stringHref = "?idJeu=" . $Data[0];
                                                echo "</tr><tr>
                                                    <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes = 1;
                                                $numJeu++;
                                            }
                                        }
                                    } else if (isset($_POST['ageMin'])) {

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

                                        $Query = "SELECT * FROM game INNER JOIN booking ON game.IDGame = booking.IDGame INNER JOIN member ON member.IDMember = booking.IDMember WHERE member.Name = '$_GET[member]' AND AgeMin >= $_POST[ageMin] AND AgeMax <= $_POST[ageMax] " . $checkboxSQL;

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
                                                $stringHref = "?idJeu=" . $Data[0];
                                                echo "
                                                    <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes++;
                                                $numJeu++;
                                            } else {
                                                $stringIDJeu = "jeu" . $numJeu;
                                                $stringHref = "?idJeu=" . $Data[0];
                                                echo "</tr><tr>
                                                    <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes = 1;
                                                $numJeu++;
                                            }
                                        }
                                    } else {
                                        $Query = "SELECT * FROM game INNER JOIN booking ON game.IDGame = booking.IDGame INNER JOIN member ON member.IDMember = booking.IDMember WHERE member.Name = '$_GET[member]'";
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
                                                $stringHref = "?idJeu=" . $Data[0];
                                                echo "
                                                <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes++;
                                                $numJeu++;
                                            } else {
                                                $stringIDJeu = "jeu" . $numJeu;
                                                $stringHref = "?idJeu=" . $Data[0];
                                                echo "</tr><tr>
                                                <td><a href='$stringHref'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes = 1;
                                                $numJeu++;
                                            }
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
    </div>
    <?php
    // while($Data = mysqli_fetch_array($Result))
    // {
    //     echo "IDGame : $Data[0], Name : $Data[1], AgeMin : $Data[2], AgeMax : $Data[3], Type : $Data[4], Abstract : $Data[5], ImagePath : $Data[6]</br></br>";
    // }
    mysqli_close($Connect);
    ?>
</body>

</html>