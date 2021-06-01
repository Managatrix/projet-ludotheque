<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Mes Réservations</title>
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
    <nav class="header">
        <ul>
            <li><a href="pageAccueil.php">Accueil</a></li>
            <li class="active"><a href="pageConnexion.php">Mes Réservations</a></li>
            <li><a href="pageRecherche.php">Recherche</a></li>
            <li id="admin"><a href="pageAdmin.php">Admin</a></li>
        </ul>
    </nav>
    <table>
        <tr>
            <td>
                <ul class="filtres">
                    <form action="pageRecherche.php" method="POST">
                        <li>
                            <h4>Filtres</h4>
                        </li>
                        <li>
                            <label for="nbPersonnes">Nombre de personnes</label>
                            <input class="inputBar" id="nbPersonnes" name="nbPersonnes" type="number" value="">
                        </li>
                        <li>
                            <label>Type de jeu</label>
                            <ul class="sousFiltres">
                                <li><input type="checkbox" id="checkStrategie" name="checkStrategie"><label for="checkStrategie">Stratégie</label></li>
                                <li><input type="checkbox" id="checkRapidite" name="checkRapidite"><label for="checkRapidite">Rapidité</label></li>
                                <li><input type="checkbox" id="checkPuzzle" name="checkPuzzle"><label for="checkPuzzle">Puzzle</label></li>
                            </ul>
                        </li>
                        <li>
                            <label>Disponibilité</label>
                            <ul class="sousFiltres">
                                <li><input type="checkbox" id="checkStock" name="checkStock"><label for="checkStock">En stock</label></li>
                                <li><input type="checkbox" id="checkAlmostStock" name="checkAlmostStock"><label for="checkAlmostStock">Bientôt en stock</label></li>
                            </ul>
                        </li>
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
                            <td><input type="text"></td>
                            <td><input type="submit" value="Recherche"></td>
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
                                    $nbLignes = 0;
                                    $nbColonnesMax = 2;
                                    //Traitement de la réponse

                                    // if (isset($_POST['ageMin']) && isset($_POST['ageMax'])) {
                                    // }

                                    if (isset($_POST['ageMin']) && isset($_POST['ageMax'])) {
                                        while ($Data = mysqli_fetch_array($Result)) {
                                            if (($Data[2] >= $_POST['ageMin']) && ($Data[2] <= $_POST['ageMax'])) {
                                                if ($nbColonnes < $nbColonnesMax) {
                                                    echo "
                                                    <td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                    $nbColonnes++;
                                                } else {
                                                    echo "</tr><td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td><tr>";
                                                    $nbColonnes = 0;
                                                }
                                            }
                                        }
                                    } else {
                                        while ($Data = mysqli_fetch_array($Result)) {
                                            if ($nbColonnes < $nbColonnesMax) {
                                                echo "
                                                <td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td>";
                                                $nbColonnes++;
                                            } else {
                                                echo "</tr><td><a href=''><img class='jeu' title='$Data[1]' src='$Data[6]' alt='$Data[1]'></a></td><tr>";
                                                $nbColonnes = 0;
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
        </tr>
    </table>
    <?php
    // while($Data = mysqli_fetch_array($Result))
    // {
    //     echo "IDGame : $Data[0], Name : $Data[1], AgeMin : $Data[2], AgeMax : $Data[3], Type : $Data[4], Abstract : $Data[5], ImagePath : $Data[6]</br></br>";
    // }
    mysqli_close($Connect);
    ?>
</body>

</html>