<?php
session_start();
require_once '../BACK/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employe') {
    header('Location: ../connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trajet_id = $_POST['trajet_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$trajet_id || !in_array($action, ['valider', 'refuser'])) {
        die("Requête invalide.");
    }

    $nouveau_statut = $action === 'valider' ? 'valide' : 'refuse';

    $stmt = $pdo->prepare("UPDATE trajets SET statut = ? WHERE id = ?");
    $stmt->execute([$nouveau_statut, $trajet_id]);

    header("Location: validation_trajet.php?message=Trajet $nouveau_statut avec succès.");
    exit();
}
