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

$stmt = $pdo->prepare("
    SELECT depart, arrivee, date_depart, prix, places_disponibles, statut
    FROM trajets
    WHERE chauffeur_id = ?
    ORDER BY date_depart DESC
");
$stmt->execute([$user_id]);
$trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes trajets proposés</title>
</head>
<body>
    <h1>Mes trajets proposés</h1>

    <?php if (count($trajets) > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date</th>
                <th>Prix (€)</th>
                <th>Places</th>
                <th>Statut</th>
            </tr>
            <?php foreach ($trajets as $trajet): ?>
                <tr>
                    <td><?= htmlspecialchars($trajet['depart']) ?></td>
                    <td><?= htmlspecialchars($trajet['arrivee']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($trajet['date_depart'])) ?></td>
                    <td><?= $trajet['prix'] ?></td>
                    <td><?= $trajet['places_disponibles'] ?></td>
                    <td>
                        <?php
                            if ($trajet['statut'] === 'valide') {
                                echo "✅ Validé";
                            } elseif ($trajet['statut'] === 'refuse') {
                                echo "❌ Refusé";
                            } else {
                                echo "⏳ En attente";
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Vous n’avez proposé aucun trajet pour le moment.</p>
    <?php endif; ?>

    <br>
    <a href="users.php">⬅️ Retour à l'accueil</a>
</body>
</html>
