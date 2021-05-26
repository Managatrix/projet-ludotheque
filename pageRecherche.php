<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Recherche</title>
    <link rel="stylesheet" href="accueilSS.css">
    <link rel="shortcut icon" href="favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
    <nav class="header">
        <ul>
            <li><a href="pageAccueil.php">Accueil</a></li>
            <li><a href="pageConnexion.php">Mes Réservations</a></li>
            <li class="active"><a href="pageRecherche.php">Recherche</a></li>
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
                            <label for="">Nombre de personnes</label>
                            <input class="inputBar" name="nbPersonnes" type="number" value="">
                        </li>
                        <li>
                            <label for="">Type de jeu</label>
                            <ul class="sousFiltres">
                                <li><input type="checkbox" name="checkEnfants"><label for="">Stratégie</label></li>
                                <li><input type="checkbox" name="checkReflexion"><label for="">Rapidité</label></li>
                                <li><input type="checkbox" name="checkCartes"><label for="">Puzzle</label></li>
                            </ul>
                        </li>
                        <li>
                            <label for="">Disponibilité</label>
                            <ul class="sousFiltres">
                                <li><input type="checkbox" name="checkStock"><label for="">En stock</label></li>
                                <li><input type="checkbox" name="checkAlmostStock"><label for="">Bientôt en stock</label></li>
                            </ul>
                        </li>
                        <li>
                            <label for="">Tranche d'âge</label>
                            <ul class="sousFiltres">
                                <li>
                                    <label for="">Age min</label>
                                    <input class="inputBar" name="ageMin" type="number" value="">
                                </li>
                                <li>
                                    <label for="">Age max</label>
                                    <input class="inputBar" name="ageMax" type="number" value="">
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
                                    //Ecriture de la requête
                                    $Query = "SELECT * FROM game";
                                    //Envoi de la requête
                                    $Result = $Connect->query($Query);

                                    $nbColonnes = 0;
                                    $nbLignes = 0;
                                    $nbColonnesMax = 2;
                                    //Traitement de la réponse

                                    if (isset($_POST['ageMin']) && ) {
                                        while ($Data = mysqli_fetch_array($Result)) {
                                            if ($Data[2] >= $_POST['ageMin']) {
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