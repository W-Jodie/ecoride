<?php
session_start();
$pseudo = $_SESSION['pseudo'] ?? 'Utilisateur';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Welcome - EcoRide</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($pseudo) ?></h1>
    <p>Votre inscription à bien était pris en compte.</p><br><br>
    <p>Félicitation vous venez d'obtenir <strong>20crédits</strong></p>
    <form action="users.php" method="get">
    <button type="submit"> Mon compte</button>
    </form>
</body>
</html>