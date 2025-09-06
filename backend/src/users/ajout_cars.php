<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

$email = $_SESSION['email'];
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
$user_id = $user['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $plaque = $_POST['plaque'];
    $annee = $_POST['annee'];
    $modele = $_POST['modele'];
    $eco = $_POST['eco'];
    $place = $_POST['place'];
    $fumeur = $_POST['fumeur'];
    $animal = $_POST['animal'];
    $preference = isset($_POST['preference']) ? $_POST['preference'] : '';

    $stmt = $pdo->prepare("INSERT INTO cars (user_id, plaque, annee, modele, eco, place, fumeur, animal, preference) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $plaque, $annee, $modele, $eco, $place, $fumeur, $animal, $preference]);

    $message = "Voiture enregistrée avec succès !";
}

$stmt = $pdo->prepare("SELECT * FROM cars WHERE user_id = ?");
$stmt->execute([$user_id]);
$voiture = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une voiture</title>
</head>
<body>
    <h1>Ajouter une voiture</h1>

    <?php if (isset($message)) : ?>
        <p style="color: green;"><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label>Plaque d'immatriculation :</label>
        <input type="text" name="plaque" required><br><br>

        <label>Date 1ère immatriculation :</label>
        <input type="date" name="annee" required><br><br>

        <label>Modèle :</label>
        <input type="text" name="modele" required><br><br>

        <label>Ecologique "electrique" :</label><br>
        <input type="radio" name="eco" value="1"> Oui<br><br>
        <input type="radio" name="eco" value="0" checked> Non<br><br>

        <label>Nombre de places disponible :</label>
        <input type="number" name="place" required><br><br>

        <label>Êtes-vous fumeur ?</label><br>
        <input type="radio" name="fumeur" value="1"> Oui<br><br>
        <input type="radio" name="fumeur" value="0" checked> Non<br><br>

        <label>Acceptez-vous les animaux ?</label><br><br>
        <input type="radio" name="animal" value="1"> Oui<br><br>
        <input type="radio" name="animal" value="0" checked> Non<br><br>

        <label>Préférences ou remarques :</label><br><br>
        <textarea name="preference" rows="4" cols="40" placeholder="Écrivez vos préférence, choix de musique..."></textarea><br><br>

        <button type="submit">Enregistrer</button>
    </form>

</body>
</html>
