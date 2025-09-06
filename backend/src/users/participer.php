<?php
session_start();
require_once 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$trajet_id = $_POST['trajet_id'] ?? $_GET['trajet_id'] ?? null;

if (!$trajet_id) {
    die("Aucun trajet spécifié.");
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['pending_trajet'] = $trajet_id;
    header("Location: connexion.php");
    exit();
}

if ($_SESSION['role'] !== 'utilisateur') {
    die("Seuls les utilisateurs peuvent participer à un trajet.");
}

$user_id = $_SESSION['user_id'];
$trajet_id = (int)$trajet_id;

$stmt = $pdo->prepare("SELECT * FROM trajets WHERE id = ? AND depart > NOW()");
$stmt->execute([$trajet_id]);
$trajet = $stmt->fetch();

if (!$trajet) {
    die("Trajet non valide ou déjà passé.");
}

$stmt = $pdo->prepare("SELECT * FROM participations WHERE user_id = ? AND trajet_id = ?");
$stmt->execute([$user_id, $trajet_id]);

if ($stmt->fetch()) {
    header("Location: ../detail.php?id=$trajet_id&message=Vous participez déjà à ce trajet.");
    exit();
}
