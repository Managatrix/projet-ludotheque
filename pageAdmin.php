<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ludotheque - Admin</title>
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
            <li class="active" id="admin"><a href="pageAdmin.php">Admin</a></li>
        </ul>
    </nav>
    <div class="twoCol">
        <h3>Ajouter une nouvelle fiche de jeu</h3>
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
                    <input type="text" id="abstract" name="abstract">
                </li>
                <li>
                    <input type="submit" value="Creer la fiche de jeu">
                </li>
            </ul>
        </form>
        <h3>Ajouter un nouveau membre</h3>
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
                    <input type="submit" value="Creer le membre">
                </li>
            </ul>
        </form>
    </div>
</body>

</html>