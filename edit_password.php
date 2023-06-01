<?php
ob_start();
include_once("./class/User.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <script src="./js/edit_password.js" defer></script>
    <?php include_once("./include/head_inc.php") ?>
    <title>Edit profil</title>
</head>

<body>
    <header>
        <?php include_once('./include/nav_inc.php') ?>
    </header>
    <main>
        <div class="container">
            <h3>Modifiez mot de passe :</h3>
            <div class="edit_form">
                <form method="post" onsubmit="return validerFormulaire()">
                    <div class=" mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe :</label>
                        <input type="password" id="new_password" name="new_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirm" class="form-label">Confirmer nouveau mot de passe :</label>
                        <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmer mot de passe actuel :</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <div id="erreur"></div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm" class="form-label">Pour enregistrer vos changements veuillez saissir votre mot de passe.</label><br>
                        <button type="submit" id="confirm" name="submit" class="btn btn-primary"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>&nbsp;Modifier votre profil</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>
</body>

</html>

<?php
if (isset($_POST['submit'])) {

    // Récupérer les valeurs des champs
    $newPassword = $_POST['new_password'];
    $newPasswordConfirm = $_POST['new_password_confirm'];
    $currentPassword = $_POST['password_confirm'];

    // Vérifier si les champs sont vides
    if (!empty($newPassword) && !empty($newPasswordConfirm) && !empty($currentPassword)) {
        // Vérifier si les mots de passe correspondent
        if ($newPassword === $newPasswordConfirm) {
            // Vérifier si le mot de passe actuel est correct
            if (password_verify($currentPassword, $_SESSION['user']->password)) {
                // Générer le hash du nouveau mot de passe
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe dans la base de données
                $updatePassword = $bdd->prepare("UPDATE users SET password = ? WHERE users.id = ?");
                $updatePassword->execute([$newPasswordHash, $_SESSION['user']->id]);

                // Rediriger vers la page de modification
                header("Location: ./edit.php");
                exit;
            } else {
                echo '<script>
                    document.getElementById("erreur").textContent = "Le mot de passe actuel est incorrect.";
                </script>';
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>