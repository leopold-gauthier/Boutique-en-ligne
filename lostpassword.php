<?php
// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    include_once("./include/bdd.php");

    // Récupérer l'email depuis le formulaire
    $email = $_POST['email'];

    // Vérifier si l'email existe dans la base de données
    $stmt = $bdd->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Générer un token unique pour le client
        $token = bin2hex(random_bytes(32));

        // Insérer le token dans la base de données
        $stmt = $bdd->prepare('INSERT INTO reset_tokens (email, token) VALUES (:email, :token)');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // Envoyer un email au client avec un lien de réinitialisation
        $resetLink = 'localhost/reset.php?token=' . $token;

        $message = "Bonjour,\n\nVeuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : $resetLink";

        // Envoyer l'email
        $headers = 'From: leopold.gauthier-de-porry@laplateforme.io' . "\r\n" .
            'Reply-To: leopold.gauthier-de-porry@laplateforme.io' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (mail($email, 'Réinitialisation du mot de passe', $message, $headers)) {
            // L'email a été envoyé avec succès
            header('Location: confirmation.php');
            exit;
        } else {
            // Une erreur s'est produite lors de l'envoi de l'email
            echo 'Une erreur s\'est produite lors de l\'envoi de l\'email.';
        }
    } else {
        // Email non trouvé dans la base de données
        echo 'Email non trouvé.';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once("./include/head_inc.php"); ?>
    <title>Réinitialisation du mot de passe</title>
</head>

<body style="margin-top:8%; display:flex; flex-direction:column; align-items:center;">
    <h1>Réinitialisation du mot de passe</h1>
    <form style="width:50%;text-align:center;" method="post" action="">
        <label class="form-label" for="email">Saissisez votre e-mail :</label>
        <input class="form-control" type="email" name="email" required><br>
        <p>
            Vous recevrez une confirmation dans votre boite mail.
        </p>
        <input type="submit" value="Envoyer">
    </form>
</body>

</html>