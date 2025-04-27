<?php
namespace Demetech;

require_once __DIR__ . '/../controllers/Autoloader.php';
\Demetech\Autoloader::register();

use Demetech\User;
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["mail"]) && !empty($_POST["password"])) {
        $mail = trim($_POST["mail"]);
        $password = trim($_POST["password"]);

        $utilisateur = new User();
        $userData = $utilisateur->read($mail);

        if ($userData && password_verify($password, $userData["password"])) {
            session_regenerate_id(true);

            $_SESSION["user"] = [
                "id_user" => $userData["id"],
                "prenom" => $userData["firstname"],
                "nom" => $userData["lastname"],
                "mail" => $userData["mail"]
            ];

            echo $_SESSION["user"]["prenom"];

            echo "Connexion réussie ! Bienvenue, " . $_SESSION["user"]["prenom"] . " " . $_SESSION["user"]["nom"] . "!";

            // header("Location: dashboard.php");
            // exit;
            
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     if (!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["mail"]) && !empty($_POST["password"]) && !empty($_POST["Iconfirm_password"])) {
//         $lastname = trim($_POST["lastname"]);
//         $firstname = trim($_POST["firstname"]);
//         $mail = trim($_POST["mail"]);
//         $Ipassword = trim($_POST["Ipassword"]);
//         $Iconfirm_password = trim($_POST["Iconfirm_password"]);
//     }

//     if ($Ipassword !== $Iconfirm_password) {
//         $error = "Les mots de passe ne correspondent pas.";
//     } else {
//         $utilisateur = new User();
//         if ($utilisateur->create($lastname, $firstname, $mail, $Ipassword)) {
//             echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
//         } else {
//             $error = "Erreur lors de l'inscription. L'utilisateur existe peut-être déjà.";
//         }
//     }
//     if (isset($error)) {
//         echo "<p style='color: red;'>$error</p>";
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <h1>connexion</h1>
        <label for="mail">Email:</label>
        <input type="email" name="mail" id="mail" required><br>

        <label for="mdp">Mot de passe:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Se connecter</button>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
    </form>
    <!-- <form action="" method="POST" style="margin-top: 20px;">
        <h1>inscription</h1>
        <label for="lastname">Nom:</label>
        <input type="text" name="lastname" required><br>

        <label for="firstname">Prénom:</label>
        <input type="text" name="firstname" required><br>

        <label for="mail">Email:</label>
        <input type="email" name="mail" required><br>

        <label for="password">Mot de passe:</label>
        <input type="password" name="Ipassword" required><br>

        <label for="confirm_password">Confirmer le mot de passe:</label>
        <input type="password" name="Iconfirm_password" required><br>

        <button type="submit">S'inscrire</button>
    </form> -->
</body>
</html>