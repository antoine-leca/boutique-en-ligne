<?php
namespace Demetech;

require_once __DIR__ . '/../controllers/Autoloader.php';
\Demetech\Autoloader::register();

use Demetech\User;
error_reporting(E_ALL);
ini_set('display_errors', 1);

$toastMessage = '';
$toastType = ''; // 'success' ou 'error'

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["form_type"]) && $_POST["form_type"] === "connexion") {
        // Traitement du formulaire de connexion
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
                $toastMessage = "Connexion réussie ! Bienvenue, " . $_SESSION["user"]["prenom"] . " " .  "!";
                $toastType = 'success';
            } else {
                $toastMessage = "Email ou mot de passe incorrect.";
                $toastType = 'error';
            }
        } else {
            $toastMessage = "Veuillez remplir tous les champs.";
            $toastType = 'error';
        }
    } elseif (isset($_POST["form_type"]) && $_POST["form_type"] === "inscription") {
        // Traitement du formulaire d'inscription
        if (!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["mail"]) && !empty($_POST["Ipassword"]) && !empty($_POST["Iconfirm_password"])) {
            $lastname = trim($_POST["lastname"]);
            $firstname = trim($_POST["firstname"]);
            $mail = trim($_POST["mail"]);
            $Ipassword = trim($_POST["Ipassword"]);
            $Iconfirm_password = trim($_POST["Iconfirm_password"]);

            if ($Ipassword !== $Iconfirm_password) {
                $toastMessage = "Les mots de passe ne correspondent pas.";
                $toastType = 'error';
            } else {
                $utilisateur = new User();
                if ($utilisateur->create($lastname, $firstname, $mail, $Ipassword)) {
                    $toastMessage = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    $toastType = 'success';
                } else {
                    $toastMessage = "Erreur lors de l'inscription. L'utilisateur existe peut-être déjà.";
                    $toastType = 'error';
                }
            }
        } else {
            $toastMessage = "Veuillez remplir tous les champs.";
            $toastType = 'error';
        }
    }
}
?>

<script>
    const toastMessage = "<?php echo $toastMessage; ?>";
    const toastType = "<?php echo $toastType; ?>";
</script>

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
         <button id="modalCRbtn" class="hover:cursor-pointer">afficher modal</button>
        <!-- modal de connexion inscription -->
         <!-- NE PAS OUBLIER DAJOUTER LE HIDDEN DANS LES CLASSES DU MODAL -->
        <div id="modalCR" class="modal h-[250px] w-[250px] fixed top-10 left-10 hidden">
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
                <input type="hidden" name="form_type" value="connexion">
                <div class="flex flex-col">
                    <label for="mail">Email:</label>
                    <input class="goated-input-settings" type="email" name="mail" id="mail" required><br>
                </div>
                <div class="flex flex-col mt-2">
                    <label for="mdp">Mot de passe:</label>
                    <input class="goated-input-settings" type="password" name="password" id="password" required><br>
                </div>
                <button class="bg-blue-custom bg-grey-custom p-1 my-2 rounded-md text-white" type="submit">Se connecter</button>
                <?php if (isset($error) && $form_type === 'connexion'): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <p>Pas encore de compte ? <br> <span id="switchToInscription" class="hover:underline hover:cursor-pointer">Inscrivez-vous</span></p>
            </form>

            <!-- Formulaire d'inscription -->
            <form id="inscriptionForm" action="" method="POST" style="display: none;">
                <input type="hidden" name="form_type" value="inscription">
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
                <?php if (isset($error) && $form_type === 'inscription'): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
            <!-- Toast pour les messages -->
            <div id="toast-container" class="fixed top-5 right-5 z-50 space-y-4">
                <!-- Toast de succès -->
                <div id="toast-success" class="hidden flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        <span class="sr-only">Check icon</span>
                    </div>
                    <div id="toast-success-message" class="ml-3 text-sm font-normal">Succès !</div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <!-- Toast d'erreur -->
                <div id="toast-error" class="hidden flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                        </svg>
                        <span class="sr-only">Error icon</span>
                    </div>
                    <div id="toast-error-message" class="ml-3 text-sm font-normal">Erreur !</div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-error" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <script src="\Demetech\public\js\modalCR.js" defer></script>
</body>
</html>