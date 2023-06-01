function validerFormulaire() {
    var login = document.getElementById("login").value;
    var mdp = document.getElementById("password").value;

    // Vérification du nom et du prénom
    if (login === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer votre login.";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

    if (mdp === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer un mot de passe";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

    return true;
}

