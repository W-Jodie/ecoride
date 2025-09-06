<?php
require_once '../BACK/db.php';

$avis_id = $_POST['avis_id'];
$action = $_POST['action'];

if ($action === 'valider') {
    $pdo->prepare("UPDATE avis SET valide = 1 WHERE id = ?")->execute([$avis_id]);
} elseif ($action === 'refuser') {
    $pdo->prepare("UPDATE avis SET valide = 2 WHERE id = ?")->execute([$avis_id]);
}

header("Location: moderation_avis.php");
exit();
