<?php
session_start();
require_once '../BACK/db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employe') {
    header('Location: ../connexion.php');
    exit();
}

$message = $_GET['message'] ?? null;

$stmt = $pdo->query("
    SELECT t.id, t.depart, t.arrivee, t.date_depart, t.prix, t.places_disponibles, u.pseudo
    FROM trajets t
    JOIN users u ON t.chauffeur_id = u.id
    WHERE t.statut = 'en_attente'
    ORDER BY t.date_depart ASC
");
$trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des trajets</title>
</head>
<body>
    <h1>Trajets à valider</h1>

    <?php if ($message): ?>
        <p style="color: green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (count($trajets) > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date</th>
                <th>Prix</th>
                <th>Places</th>
                <th>Chauffeur</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($trajets as $trajet): ?>
                <tr>
                    <td><?= $trajet['id'] ?></td>
                    <td><?= htmlspecialchars($trajet['depart']) ?></td>
                    <td><?= htmlspecialchars($trajet['arrivee']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($trajet['date_depart'])) ?></td>
                    <td><?= $trajet['prix'] ?> €</td>
                    <td><?= $trajet['places_disponibles'] ?></td>
                    <td><?= htmlspecialchars($trajet['pseudo']) ?></td>
                    <td>
                        <form method="POST" action="traiter_validation_trajet.php" style="display:inline;">
                            <input type="hidden" name="trajet_id" value="<?= $trajet['id'] ?>">
                            <button type="submit" name="action" value="valider">✅ Valider</button>
                            <button type="submit" name="action" value="refuser" onclick="return confirm('Refuser ce trajet ?')">❌ Refuser</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun trajet en attente de validation.</p>
    <?php endif; ?>
</body>
</html>