<?php
session_start();
require_once '../BACK/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employe') {
    header('Location: ../connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participation_id = (int)$_POST['participation_id'];
    $action = $_POST['action'];

    if ($action === 'valider') {
        $stmt = $pdo->prepare("UPDATE participations SET statut = 'valide', credit_plateforme = 0.5 WHERE id = ?");
        $stmt->execute([$participation_id]);
    } elseif ($action === 'refuser') {
        $stmt = $pdo->prepare("UPDATE participations SET statut = 'refuse' WHERE id = ?");
        $stmt->execute([$participation_id]);
    }

    header('Location: validation_trajet.php');
    exit();
}
?>

