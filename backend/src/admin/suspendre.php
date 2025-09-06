<?php
require_once '../BACK/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($userId && $action) {
        $newStatus = ($action === 'Suspendre') ? 'suspendu' : 'actif';

        $stmt = $pdo->prepare("UPDATE users SET statut = ? WHERE id = ?");
        $stmt->execute([$newStatus, $userId]);

        header('Location: gestion_compte.php'); 
        exit();
    }
}

http_response_code(400);
echo "Requête invalide.";
