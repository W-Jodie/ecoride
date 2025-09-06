<?php
session_start();
require_once '../BACK/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion_admin.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password, role) VALUES (?, ?, ?, 'employe')");
    if ($stmt->execute([$pseudo, $email, $hashedPassword])) {
        $message = "Employé ajouté avec succès !";
    } else {
        $message = "Erreur lors de l'ajout.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un employé</title>
</head>
<body>
    <h2>Ajouter un nouvel employé</h2>

    <?php if ($message): ?>
        <p style="color: green"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Pseudo : <input type="text" name="pseudo" required></label><br><br>
        <label>Email : <input type="email" name="email" required></label><br><br>
        <label>Mot de passe : <input type="password" name="password" required></label><br><br>
        <button type="submit">Ajouter l'employé</button>
    </form>
</body>
</html>
