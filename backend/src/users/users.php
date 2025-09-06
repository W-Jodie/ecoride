<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=ecoride', 'root', '');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: connexion.php");
    exit();
}

$stmt = $pdo->prepare("SELECT pseudo, credit FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon compte - EcoRide</title>
</head>
<body>
    <h1>Bonjour, <?= htmlspecialchars($user['pseudo']) ?></h1><br>
    <p><a href="../index.html">retour à l'accueil</a><br>
    <a href="logout.php">Se déconnecter</a>
    </p>

    <p>Vous avez actuellement <strong><?= $user['credit']?> crédits</strong></p><br><hr>
<br>
    <a href="carsregister.php"><h2>Vos voitures enregistrer</h2></a><br>
    <p>Desirez vous être Chauffeur ?</p><br>
    <p>Vous n'avez pas encore enregistré de voiture. <a href="ajout_cars.php">Ajouter une voiture</a></p>
<hr>
<a href="ajout_trajet.php"><h3>Ajouter un trajet</h3></a><br>
<a href="historique.php"><p>Voir mes trajets</p></a><br><hr>

<a href="signalement.php"><h3><strong>Signalement</strong></h3></a><br>

</body>
</html>