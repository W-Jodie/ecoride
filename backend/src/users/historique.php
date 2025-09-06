<?php
session_start();
require_once 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: connexion.php");
    exit();
}

if (isset($_POST['annuler_trajet'])) {
    $trip_id = $_POST['trip_id'];
    $est_chauffeur = $_POST['est_chauffeur'];

    if ($est_chauffeur) {
        $pdo->prepare("UPDATE trajets SET annule = 1 WHERE id = ?")->execute([$trip_id]);

        $stmt = $pdo->prepare("SELECT user_id FROM trip_participants WHERE trip_id = ?");
        $stmt->execute([$trip_id]);
        $passagers = $stmt->fetchAll();

        foreach ($passagers as $passager) {
            $pdo->prepare("UPDATE users SET credit = credit + 10 WHERE id = ?")->execute([$passager['user_id']]);
        }

        $pdo->prepare("UPDATE trip_participants SET annule = 1 WHERE trip_id = ?")->execute([$trip_id]);

    } else {
        $pdo->prepare("UPDATE trip_participants SET annule = 1 WHERE trip_id = ? AND user_id = ?")
            ->execute([$trip_id, $user_id]);

        $pdo->prepare("UPDATE trajets SET places_disponibles = places_disponibles + 1 WHERE id = ?")->execute([$trip_id]);

        $pdo->prepare("UPDATE users SET credit = credit + 10 WHERE id = ?")->execute([$user_id]);
    }
}

$stmt1 = $pdo->prepare("SELECT * FROM trajets WHERE chauffeur_id = ?");
$stmt1->execute([$user_id]);
$trajets_conducteur = $stmt1->fetchAll();

$stmt2 = $pdo->prepare("
    SELECT t.* FROM trip_participants p
    JOIN trajets t ON p.trip_id = t.id
    WHERE p.user_id = ? AND p.annule = 0
");
$stmt2->execute([$user_id]);
$trajets_passager = $stmt2->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des covoiturages</title>
</head>
<body>
    <h1>Historique de vos covoiturages</h1>
    <p><a href="users.php"><button>RETOUR</button></a></p>

    <h2>🚗 En tant que chauffeur</h2>
    <?php if (empty($trajets_conducteur)) : ?>
        <p>Aucun trajet.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($trajets_conducteur as $trajet) : ?>
                <li>
                    <?= htmlspecialchars($trajet['depart']) ?> ➜ <?= htmlspecialchars($trajet['arrivee']) ?><br>
                    Date : <?= $trajet['date_depart'] ?> — Prix : <?= $trajet['prix'] ?> crédits<br>
                    <?php if (!$trajet['annule']) : ?>
                        <form method="POST">
                            <input type="hidden" name="trip_id" value="<?= $trajet['id'] ?>">
                            <input type="hidden" name="est_chauffeur" value="1">
                            <button type="submit" name="annuler_trajet">❌ Annuler le trajet</button>
                        </form>
                    <?php else : ?>
                        <em>Trajet annulé</em>
                    <?php endif; ?>
                </li><br>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>👤 En tant que passager</h2>
    <?php if (empty($trajets_passager)) : ?>
        <p>Aucun trajet.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($trajets_passager as $trajet) : ?>
                <li>
                    <strong><?= htmlspecialchars($trajet['depart']) ?> ➜ <?= htmlspecialchars($trajet['arrivee']) ?></strong><br>
                    Date : <?= $trajet['date_depart'] ?> — Prix : <?= $trajet['prix'] ?> crédits<br>
                    <?php if (!$trajet['annule']) : ?>
                        <form method="POST">
                            <input type="hidden" name="trip_id" value="<?= $trajet['id'] ?>">
                            <input type="hidden" name="est_chauffeur" value="0">
                            <button type="submit" name="annuler_trajet">❌ Annuler ma participation</button>
                        </form>
                    <?php else : ?>
                        <em>Trajet annulé</em>
                    <?php endif; ?>
                </li><br>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>