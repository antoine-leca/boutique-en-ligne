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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["mail"]) && !empty($_POST["Ipassword"]) && !empty($_POST["Iconfirm_password"])) {
        $lastname = trim($_POST["lastname"]);
        $firstname = trim($_POST["firstname"]);
        $mail = trim($_POST["mail"]);
        $Ipassword = trim($_POST["Ipassword"]);
        $Iconfirm_password = trim($_POST["Iconfirm_password"]);
    }

    if ($Ipassword !== $Iconfirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $utilisateur = new User();
        if ($utilisateur->create($lastname, $firstname, $mail, $Ipassword)) {
            echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de l'inscription. L'utilisateur existe peut-être déjà.";
        }
    }
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="\Demetech\public\css\root.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo:ital,wght@0,100..900;1,100..900&family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header>
        <!-- header -->
        <!-- btn afficher modal -->
         <!-- <button id="modalCRbtn" class="hover:cursor-pointer">afficher modal</button> -->
        <!-- modal de connexion inscription -->
         <!-- NE PAS OUBLIER DAJOUTER LE HIDDEN DANS LES CLASSES DU MODAL -->
        <div id="modalCR" class="modal h-[250px] w-[250px] fixed top-10 left-10">
            <div class="modal-content h-full flex flex-col">
                <div class="h-full flex w-full justify-between">
                    <div class="w-1/2 flex items-center justify-center">
                        <h2 id="connexionTab" class="w-full h-full text-center tab-active">Connexion</h2>
                    </div>
                    <div class="w-1/2 flex items-center justify-center">
                        <h2 id="inscriptionTab" class="w-full h-full text-center">Inscription</h2>
                    </div>
                </div>
                <div id="formContainer" class="mt-2">
            <!-- Formulaire de connexion -->
            <form id="connexionForm" action="" method="POST">
                <div class="flex flex-col">
                    <label for="mail">Email:</label>
                    <input class="goated-input-settings" type="email" name="mail" id="mail" required><br>
                </div>
                <div class="flex flex-col mt-2">
                    <label for="mdp">Mot de passe:</label>
                    <input class="goated-input-settings" type="password" name="password" id="password" required><br>
                </div>
                <button class="bg-blue-custom bg-grey-custom p-1 my-2 rounded-md text-white" type="submit">Se connecter</button>
                <?php if (isset($error)): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <p>Pas encore de compte ? <br> <span id="switchToInscription" class="hover:underline hover:cursor-pointer">Inscrivez-vous</span></p>
            </form>

            <!-- Formulaire d'inscription -->
            <form id="inscriptionForm" action="" method="POST" style="display: none;">
                <div class="flex flex-col">
                    <label for="lastname">Nom:</label>
                    <input class="goated-input-settings" type="text" name="lastname" id="lastname" required><br>
                </div>
                <div class="flex flex-col">
                    <label for="firstname">Prénom:</label>
                    <input class="goated-input-settings" type="text" name="firstname" id="firstname" required><br>
                </div>
                <div class="flex flex-col">
                    <label for="mail">Email:</label>
                    <input class="goated-input-settings" type="email" name="mail" id="mail" required><br>
                </div>
                <div class="flex flex-col">
                    <label for="password">Mot de passe:</label>
                    <input class="goated-input-settings" type="password" name="Ipassword" id="Ipassword" required><br>
                </div>
                <div class="flex flex-col">
                    <label for="confirm_password">Confirmer le mot de passe:</label>
                    <input class="goated-input-settings" type="password" name="Iconfirm_password" id="Iconfirm_password" required><br>
                </div>
                <button class="bg-blue-custom bg-grey-custom p-1 my-2 rounded-md text-white" type="submit">S'inscrire</button>
            </form>
        </div>
            </div>
    </header>
    <script src="\Demetech\public\js\modalCR.js" defer></script>
</body>
</html>