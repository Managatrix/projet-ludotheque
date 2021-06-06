function afficherTitre(idJeu) {
    document.getElementById("nomJeuSelectionne").innerHTML = document.getElementById(idJeu).title;
}

window.addEventListener("DOMContentLoaded", (event) => {
    let i = 1;
    let jeuStr = "jeu";
    while (document.getElementById(jeuStr.concat(i)) !== null) {
        document.getElementById(jeuStr.concat(i)).addEventListener('click', afficherTitre.bind(this, jeuStr.concat(i)), false);
        // .bind to adjust the scope of the function/parameters
        i++;
    }
})