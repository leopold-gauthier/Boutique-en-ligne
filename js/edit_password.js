function validerFormulaire() {
    let new_password = document.getElementById("new_password").value;
    let new_password_confirm =  document.getElementById("new_password_confirm").value;
    let old_password = document.getElementById("password_confirm").value;


    // Vérification du nom et du prénom

    if (new_password === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer un mot de passe";
        return false;
    } else if (/^[a-zA-Z0-9]+$/.test(new_password)) {
        document.getElementById("erreur").textContent = "Votre nouveau mot de passe doit contenir au moins 1 caractére spécial.";
        return false;
    }else {
        document.getElementById("erreur").textContent = "";
    }

    if (new_password !== new_password_confirm) {
        document.getElementById("erreur").textContent = "Les nouveaux mots de passe ne correspondent pas.";
        return false;
    }else {
        document.getElementById("erreur").textContent = "";
    }

    if (old_password === "") {
        document.getElementById("erreur").textContent = "Veuillez entrer votre ancien mot de passe";
        return false;
    } else {
        document.getElementById("erreur").textContent = "";
    }

    return true;
}

