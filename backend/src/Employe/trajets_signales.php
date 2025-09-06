<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employe') {
    header('Location: ../connexion.php'); 
    exit();
}

require_once '../BACK/db.php';

$stmt = $pdo->query("SELECT s.id, s.message, s.date_signalement, s.trajet_id, u.pseudo AS utilisateur
                     FROM signalements s
                     JOIN users u ON s.user_id = u.id
                     ORDER BY s.date_signalement DESC");
$signalements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><title>Signalements des trajets</title></head>
<body>
<h1>Signalements des trajets</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID Signalement</th>
            <th>Utilisateur</th>
            <th>Message</th>
            <th>Date</th>
            <th>ID Trajet</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($signalements as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['id']) ?></td>
                <td><?= htmlspecialchars($s['utilisateur']) ?></td>
                <td><?= htmlspecialchars($s['message']) ?></td>
                <td><?= htmlspecialchars($s['date_signalement']) ?></td>
                <td><?= htmlspecialchars($s['trajet_id']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
