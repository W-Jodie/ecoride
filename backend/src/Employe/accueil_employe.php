<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employe') {
    header("Location: connexion_employe.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Espace Employé</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['pseudo']) ?></h1>

    <ul>
        <li><a href="moderation_avis.php">Modération des avis</a></li>
        <li><a href="validation_trajet.php">Traiter les trajets</a></li>
        <li><a href="validation_trajet.php">Traiter les participations</a></li>
        <li><a href="traiter_avis.php">Traiter les Avis</a></li>
        <li><a href="trajets_signales.php">Trajets signalés</a></li>
        <li><a href="logout.php">Se déconnecter</a></li>
    </ul>
</body>
</html>
