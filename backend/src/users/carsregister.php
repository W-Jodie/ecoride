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

if (!$user) {
    die("Utilisateur non trouvé");
}

$user_id = $user['id'];

$stmt = $pdo->prepare("SELECT * FROM cars WHERE user_id = ?");
$stmt->execute([$user_id]);
$cars = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon compte - EcoRide</title>
</head>
<body>
    <h1>Vos voiture enregistrée(s) :</h1>
        <?php if (count($cars) > 0): ?>
        <?php foreach ($cars as $car): ?>
            <ul>
                <li><strong>Plaque :</strong> <?= htmlspecialchars($car['plaque']) ?></li>
                <li><strong>Date immatriculation :</strong> <?= htmlspecialchars($car['annee']) ?></li>
                <li><strong>Modèle :</strong> <?= htmlspecialchars($car['modele']) ?></li>
                <li><strong>Couleur :</strong> <?= htmlspecialchars($car['couleur']) ?></li>
                <li><strong>Places disponibles :</strong> <?= htmlspecialchars($car['place']) ?></li>
                <li><strong>Fumeur :</strong> <?= $car['fumeur'] ? 'Oui' : 'Non' ?></li>
                <li><strong>Animaux acceptés :</strong> <?= $car['animal'] ? 'Oui' : 'Non' ?></li>
                <?php if (!empty($car['preference'])): ?>
                    <li><strong>Préférences :</strong> <?= htmlspecialchars($car['preference']) ?></li>
                <?php endif; ?>
            </ul>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Vous n'avez pas encore enregistré de voiture. <a href="ajout_cars.php">Ajouter une voiture</a></p>
    <?php endif; ?>

</body>
</html>



