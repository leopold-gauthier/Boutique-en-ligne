function validerFormulaire() {
    var login = document.getElementById("login").value;
    var nom = document.getElementById("lastname").value;
    var prenom = document.getElementById("firstname").value;
    var email = document.getElementById("email").value;
    var tel = document.getElementById("tel").value;
    var mdp = document.getElementById("password").value;
    var mdp_confirm = document.getElementById("password_confirm").value;

    // Vérification du nom et du prénom
    if (nom === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer votre nom.";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }
    // Vérification du login
    if (login === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer un login.";
        return false;
    }
    else {
        document.getElementById("erreur").textContent = "";
    }

    if (prenom === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer votre prénom.";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

     // Vérification du tel
     if (tel === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer un numéro de téléphone.";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

    // Vérification de l'email
    if (email === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer une adresse email valide.";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

    // Vérification du mot de passe
    if (mdp === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer un mot de passe";
        return false;
    } else if (/^[a-zA-Z0-9]+$/.test(mdp)) {
        document.getElementById("erreur").textContent = "Le mot de passe doit contenir caractére spécial.";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

    // Vérification de la confirmation du mot de passe
    if (mdp_confirm !== mdp) {
        document.getElementById("erreur").textContent = "Les mots de passe ne sont pas identiques.";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

    return true;
}

