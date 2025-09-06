<?php
session_start();
require_once 'db.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header("Location: connexion.php");
    exit();
}

$error = '';
$success = '';

$stmt = $pdo->prepare("
    SELECT t.id, t.depart, t.arrivee, t.date_depart
    FROM trajets t
    INNER JOIN participations p ON t.id = p.trajet_id
    WHERE p.user_id = ?
    ORDER BY t.date_depart DESC
");
$stmt->execute([$userId]);
$trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trajet_id'], $_POST['motif'])) {
    $trajet_id = (int)$_POST['trajet_id'];
    $motif = trim($_POST['motif']);

    if ($trajet_id <= 0 || empty($motif)) {
        $error = "Veuillez sélectionner un trajet et saisir un motif.";
    } else {
        $insert = $pdo->prepare("INSERT INTO signalements (user_id, trajet_id, motif) VALUES (?, ?, ?)");
        if ($insert->execute([$userId, $trajet_id, $motif])) {
            $success = "Signalement envoyé avec succès.";
        } else {
            $error = "Erreur lors de l'enregistrement du signalement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Compte utilisateur - Signaler un trajet</title>
</head>
<body>
    <h1>Signaler un trajet</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="trajet_id">Choisissez un trajet :</label><br />
        <select name="trajet_id" id="trajet_id" required>
            <option value="">-- Sélectionnez un trajet --</option>
            <?php foreach ($trajets as $trajet): ?>
                <option value="<?= $trajet['id'] ?>">
                    <?= htmlspecialchars($trajet['depart']) ?> → <?= htmlspecialchars($trajet['arrivee']) ?> (<?= date('d/m/Y H:i', strtotime($trajet['date_depart'])) ?>)
                </option>
            <?php endforeach; ?>
        </select><br /><br />

        <label for="motif">Motif du signalement :</label><br />
        <textarea id="motif" name="motif" rows="4" cols="50" required></textarea><br /><br />

        <button type="submit">Signaler</button>
    </form>

</body>
</html>
