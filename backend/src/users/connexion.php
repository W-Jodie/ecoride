<?php
session_start();
require_once 'db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        if ($user['statut'] === 'suspendu') {
            $error = "Votre compte a été suspendu. Veuillez contacter l’administrateur.";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            switch ($user['role']) {
                case 'employe':
                    header("Location: ../Employe/accueil_employe.php");
                    exit();
                case 'utilisateur':
                    if (isset($_SESSION['pending_trajet'])) {
                        $trajet_id = $_SESSION['pending_trajet'];
                        unset($_SESSION['pending_trajet']); 
                        header("Location: participer.php?from=login&trajet_id=" . urlencode($trajet_id));
                        exit();
                    } else {
                        header("Location: users.php");
                        exit();
                    }
                default:
                    $error = "Accès interdit depuis ce formulaire.";
                    session_destroy();
                    exit();
            }
        }

    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="/EcoRide/BACK/connexion.php">
        <label for="email">Email :</label><br />
        <input type="email" id="email" name="email" required /><br /><br />

        <label for="password">Mot de passe :</label><br />
        <input type="password" id="password" name="password" required /><br /><br />

        <button type="submit">Se connecter</button>
    </form>
    
</body>
</html>