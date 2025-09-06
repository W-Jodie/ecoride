<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $email = htmlspecialchars($_POST["email"]);
    $password_raw = $_POST["password"];

    if (empty($pseudo) || empty($email) || empty($password_raw)) {
        die('Tous les champs sont obligatoires');
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        die("Cette adresse email est déjà utilisée. Veuillez en choisir une autre.");
    }

    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password) VALUES (:pseudo, :email, :password)");
    $stmt->execute([
        ':pseudo' => $pseudo,
        ':email' => $email,
        ':password' => $password
    ]);

    $user_id = $pdo->lastInsertId();

    $_SESSION['pseudo'] = $pseudo;
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $user_id;
    header("Location: welcome.php");
    exit();
}