<?php
session_start();
require_once '../BACK/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        header("Location: espace_admin.php");
        exit();
    } else {
        $error = "Accès refusé, seuls les administrateurs peuvent se connecter ici.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin - EcoRide</title>
</head>
<body>
    <h1>Connexion Administrateur</h1>
    <?php if ($error): ?>
        <p style="color: red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Mot de passe: <input type="password" name="password" required></label><br><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>

