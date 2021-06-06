function afficherTitre(idJeu) {
    console.log(gamesArray[idJeu]);
    document.getElementById("nomJeuSelectionne").innerHTML = gamesArray[idJeu].Name;
    document.getElementById("descriptionJeuSelectionne").innerHTML = gamesArray[idJeu].Abstract;
    document.getElementById("typeJeuSelectionne").innerHTML = gamesArray[idJeu].Type;
    document.getElementById("trancheAgeJeuSelectionne").innerHTML = gamesArray[idJeu].AgeMin + " - " + gamesArray[idJeu].AgeMax;

    localStorage.setItem("id", gamesArray[idJeu].Name);
    localStorage.setItem("abstract", gamesArray[idJeu].Abstract);
    localStorage.setItem("type", gamesArray[idJeu].Type);
    localStorage.setItem("ageMin", gamesArray[idJeu].AgeMin);
    localStorage.setItem("ageMax", gamesArray[idJeu].AgeMax);
}

window.addEventListener("DOMContentLoaded", (event) => {

    if (localStorage.getItem('id')) {
        document.getElementById("nomJeuSelectionne").innerHTML = localStorage.getItem('id');
        document.getElementById("descriptionJeuSelectionne").innerHTML = localStorage.getItem('abstract');
        document.getElementById("typeJeuSelectionne").innerHTML = localStorage.getItem('type');
        document.getElementById("trancheAgeJeuSelectionne").innerHTML = localStorage.getItem('ageMin') + " - " + localStorage.getItem('ageMax');
    }
    let i = 1;
    let jeuStr = "jeu";
    while (document.getElementById(jeuStr.concat(i)) !== null) {
        document.getElementById(jeuStr.concat(i)).addEventListener('click', afficherTitre.bind(this, i), false);
        // .bind to adjust the scope of the function/parameters
        i++;
    }
})