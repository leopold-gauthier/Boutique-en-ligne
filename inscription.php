<?php
ob_start();
include("./class/User.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <script src="./js/inscription.js" defer></script>
    <?php include_once("./include/head_inc.php") ?>
    <title>Inscription</title>
</head>

<body>
    <header>
        <?php include_once("./include/nav_inc.php") ?>
    </header>
    <main>
        <div class="container">
            <form action="" method="post" onsubmit="return validerFormulaire()">
                <div class="mb-3">
                    <div id="erreur_login"></div><br>
                    <div class="d-flex" id="suggestion_login"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="name">Login: </label>
                    <input class="form-control" type="text" name="login" id="login">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email: </label>
                    <input class="form-control" type="email" name="email" id="email">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="firstname">Firstname: </label>
                    <input class="form-control" type="text" name="firstname" id="firstname">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="lastname">Lastname: </label>
                    <input class="form-control" type="text" name="lastname" id="lastname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lastname">Tél: </label>
                    <input class="form-control" type="tel" name="tel" id="tel">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password: </label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password Confirm: </label>
                    <input class="form-control" type="password" name="password_confirm" id="password_confirm">
                </div>
                <div class="mb-3">
                    <div id="erreur"></div>
                </div>
                <div class="mb-3">
                    <input class="form-control" class="button" type="submit" name="submit" value="S'inscrire">
                </div>
            </form>
        </div>

    </main>




</body>

</html>
<?php

if (isset($_POST['submit'])) {
    $login = htmlspecialchars($_POST["login"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hashage du mot de passe
    $email = htmlspecialchars($_POST["email"]);
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $tel = htmlspecialchars($_POST["tel"]);

    $user = new User(NULL, $login, $password, $email, $firstname, $lastname, $tel);

    if ($user->verify_login($bdd) == false) { ?>
        <script>
            let loginValue = "<?= $_POST['login'] ?>";
            document.getElementById('erreur_login').textContent = 'Le login est déjà existant veuillez en choisir un autre.';

            var suggestionContainer = document.getElementById('suggestion_login');
            var loginInput = document.getElementById('login');

            // Créer une fonction pour générer les suggestions
            function generateSuggestion(value) {
                var suggestion = document.createElement('p');
                suggestion.textContent = value;
                suggestion.addEventListener('click', function() {
                    // Récupérer la valeur du paragraphe cliqué
                    var valeur = suggestion.textContent;

                    // Effacer la valeur actuelle du champ d'entrée
                    loginInput.value = '';

                    // Ajouter la valeur au champ d'entrée
                    loginInput.value += valeur;
                });

                return suggestion;
            }

            // Générer les suggestions
            var suggestions = [
                loginValue + '_user',
                loginValue + '_BigOne',
                loginValue + '_mister',
                loginValue + 'mystic',
                loginValue + '193',
                loginValue + '83',
                loginValue + '_Flex_',

            ];

            // Ajouter les suggestions à l'élément parent
            suggestions.forEach(function(suggestion) {
                var suggestionElement = generateSuggestion(suggestion);
                suggestionContainer.appendChild(suggestionElement);
            });
        </script>
<?php
    } else {
        $user->register($bdd);
        header('Location: ./index.php');
        exit();
    }
}

?>