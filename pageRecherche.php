<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Recherche</title>
    <link rel="stylesheet" href="accueilSS.css">
    <link rel="shortcut icon" href="favicon.ico">

    <script src="reservation.js"></script>
    <!-- <script type="text/javascript">
        function afficherJeu(idJeu) {
            document.getElementById("nomJeuSelectionne").innerHTML = document.getElementById(idJeu).title;
            document.getElementById("descriptionJeuSelectionne").innerHTML = document.getElementById(idJeu).title;
            localStorage.setItem("id", document.getElementById(idJeu).title);
        }

        window.addEventListener("DOMContentLoaded", (event) => {
            if (localStorage.getItem('id')) {
                document.getElementById("nomJeuSelectionne").innerHTML = localStorage.getItem('id');
            }
            let i = 1;
            let jeuStr = "jeu";
            while (document.getElementById(jeuStr.concat(i)) !== null) {
                document.getElementById(jeuStr.concat(i)).addEventListener('click', afficherJeu.bind(this, jeuStr.concat(i)), false);
                // .bind to adjust the scope of the function/parameters
                i++;
            }
        })
    </script> -->

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
            <li><a href="pageConnexion.php">Mes Réservations</a></li>
            <li class="active"><a href="pageRecherche.php">Recherche</a></li>
            <li id="admin"><a href="pageAdmin.php">Admin</a></li>
        </ul>
    </nav>
    <table class="lcolumn">
        <tr>
            <td id="filtresBox">
                <ul class="filtres">
                    <form action="pageRecherche.php" method="POST">
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
                                <script>
                                    let gamesArray = [0]; //Initialisation avec 0 pour que l'indice corresponde avec l'IDGame
                                    let gameObject = [];
                                </script>
                                <?php
                                $checks = array();
                                //Ecriture de la requête
                                $QueryTypes = "SELECT * FROM game";
                                //Envoi de la requête
                                $Result = $Connect->query($QueryTypes);
                                while ($Data = mysqli_fetch_array($Result)) {

                                    // $Data = mysqli_fetch_array($ResultTypes);
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
                                        // console.log(gamesArray);
                                    </script>

                                <?php
                                }
                                $ResultTypes = $Connect->query($QueryTypes);
                                while ($Data = mysqli_fetch_array($ResultTypes)) { // Create checkbox filters according to DB
                                    if (array_search($Data[4], $checks) === false) {
                                        $idType = "check" . $Data[4];
                                        echo "<li><input type='checkbox' id='$idType' name='$idType' checked><label for='$idType'>$Data[4]</label></li>";
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
                            <form action="pageRecherche.php" method="POST">
                                <td><input type="text" id="recherche" name="recherche"></td>
                                <td><input type="submit" value="Recherche"></td>
                            </form>
                        </tr>
                        <tr>
                            <table class="resultats">
                                <tr>
                                    <?php
                                    //Ecriture de la requête
                                    $Query = "SELECT * FROM game";
                                    //Envoi de la requête
                                    $Result = $Connect->query($Query);

                                    $nbColonnes = 0;
                                    $nbColonnesMax = 4;
                                    $numJeu = 1;
                                    //Traitement de la réponse


                                    // /!\ UTILISER DES REQUETES PRECISES AU LIEU DE TRIER AVEC PHP

                                    // /!\ UTILISER AJAX POUR LES FONCTION ONCLICK


                                    if (isset($_POST['recherche']) && $_POST['recherche']) {
                                        while ($Data = mysqli_fetch_array($Result)) {
                                            if (stripos($Data[5], $_POST['recherche']) !== false) {
                                                if ($nbColonnes < $nbColonnesMax) {
                                                    echo "
                                                    <td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                    $nbColonnes++;
                                                } else {
                                                    echo "</tr><tr>
                                                    <td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                    $nbColonnes = 0;
                                                }
                                            }
                                        }
                                        print_r($checks);
                                    } else if (isset($_POST['ageMin']) && isset($_POST['ageMax'])) {
                                        while ($Data = mysqli_fetch_array($Result)) {
                                            if (($Data[2] >= $_POST['ageMin']) && ($Data[2] <= $_POST['ageMax'])) {
                                                if ($nbColonnes < $nbColonnesMax) {
                                                    echo "
                                                    <td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                    $nbColonnes++;
                                                } else {
                                                    echo "</tr><tr>
                                                    <td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                    $nbColonnes = 0;
                                                }
                                            }
                                        }
                                    } else {
                                        while ($Data = mysqli_fetch_array($Result)) {
                                            if ($nbColonnes < $nbColonnesMax) {
                                                $stringIDJeu = "jeu" . $numJeu;
                                                $stringHref = "#" . $Data[1];
                                                $stringHrefAlt = "?idJeu=" . $Data[0];
                                                echo "
                                                <td><a href='$stringHrefAlt'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes++;
                                                $numJeu++;
                                            } else {
                                                $stringIDJeu = "jeu" . $numJeu;
                                                $stringHref = "#" . $Data[1];
                                                $stringHrefAlt = "?idJeu=" . $Data[0];
                                                echo "</tr><tr>
                                                <td><a href='$stringHrefAlt'><img id='$stringIDJeu' class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
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
        <form action="pageRecherche.php" method="post">
            <input type="submit" name="reserveButton" id="reserveButton" value="Réserver">
        </form>
    </div>
    <?php
    if (isset($_POST["reserveButton"])) {
        echo $_GET['idJeu'];
        $Query = "INSERT INTO booking (IDMember, IDGame, Date, ReturnDate) VALUES ($_GET[idJeu], 2, 2021-06-06, 2021-07-06)";
        // $Connect->query($Query);
        echo "Reservation pour 1 mois prise en compte";
    }

    // while($Data = mysqli_fetch_array($Result))
    // {
    //     echo "IDGame : $Data[0], Name : $Data[1], AgeMin : $Data[2], AgeMax : $Data[3], Type : $Data[4], Abstract : $Data[5], ImagePath : $Data[6]</br></br>";
    // }
    mysqli_close($Connect);
    ?>
</body>

</html>