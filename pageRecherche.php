<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Recherche</title>
    <link rel="stylesheet" href="accueilSS.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
    <nav class="header">
        <ul>
            <li><a href="pageAccueil.htm">Accueil</a></li>
            <li><a href="pageConnexion.htm">Mes Réservations</a></li>
            <li class="active"><a href="pageRecherche.htm">Recherche</a></li>
        </ul>
    </nav>
    <table>
        <tr>
            <td>
                <ul class="filtres">
                    <li>
                        <h4>Filtres</h4>
                    </li>
                    <li>
                        <label for="">Nombre de personnes</label>
                        <input class="inputBar" type="number" value="">
                    </li>
                    <li>
                        <label for="">Type de jeu</label>
                        <ul class="sousFiltres">
                            <li><input type="checkbox"><label for="">Pour les enfants</label></li>
                            <li><input type="checkbox"><label for="">Reflexion</label></li>
                            <li><input type="checkbox"><label for="">Jeu de cartes</label></li>
                        </ul>
                    </li>
                    <li>
                        <label for="">Disponibilité</label>
                        <ul class="sousFiltres">
                            <li><input type="checkbox"><label for="">En stock</label></li>
                            <li><input type="checkbox"><label for="">Bientôt en stock</label></li>
                        </ul>
                    </li>
                    <li>
                        <label for="">Tranche d'âge</label>
                        <ul class="sousFiltres">
                            <li>
                                <label for="">Age min</label>
                                <input class="inputBar" type="number" value="">
                            </li>
                            <li>
                                <label for="">Age max</label>
                                <input class="inputBar" type="number" value="">
                            </li>
                        </ul>
                    </li>
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
                                while($Data = mysqli_fetch_array($Result))
                                {
                                    if ($nbColonnes < $nbColonnesMax)
                                    {
                                        echo "
                                        <td><a href=''><img class='jeu' src='$Data[6]' alt='$Data[1]'></a></td>";
                                        $nbColonnes ++;
                                    }
                                    else
                                    {
                                        echo "</tr><td><a href=''><img class='jeu' src='$Data[6]' alt='$Data[1]'></a></td><tr>";
                                        $nbColonnes = 0;
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
    //Traitement de la réponse
    while($Data = mysqli_fetch_array($Result))
    {
        echo "IDGame : $Data[0], Name : $Data[1], AgeMin : $Data[2], AgeMax : $Data[3], Type : $Data[4], Abstract : $Data[5], ImagePath : $Data[6]</br></br>";
    }
    mysqli_close($Connect);
    ?>
</body>

</html>