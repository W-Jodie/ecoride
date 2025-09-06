<?php
require_once '../BACK/db.php';

$stmt = $pdo->query("SELECT DATE(depart) AS jour, COUNT(*) AS total FROM trajets GROUP BY DATE(depart) ORDER BY jour");
$covoiturage_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->query("SELECT DATE(date_participation) AS jour, SUM(credit_plateforme) AS total FROM participations WHERE statut = 'valide' GROUP BY DATE(date_participation) ORDER BY jour");
$credits_data = $stmt2->fetchAll(PDO::FETCH_ASSOC);

function roundToHalf($value) {
    return round($value * 2) / 2;
}

foreach ($credits_data as &$row) {
    $row['total'] = roundToHalf((float)$row['total']);
}
unset($row); 

$totalCredits = $pdo->query("SELECT SUM(credit_plateforme) FROM participations WHERE statut = 'valide'")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin - EcoRide</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>Espace Administrateur</h1>

<p><strong>Total des crédits gagnés :</strong> <?= number_format($totalCredits, 2) ?> crédits</p>

<h2>Nombre de covoiturages par jour</h2>
<canvas id="covoituragesChart" width="400" height="200"></canvas>

<h2>Crédits gagnés par jour</h2>
<canvas id="creditsChart" width="400" height="200"></canvas>

<script>
    // 1. Covoiturages par jour
    const covoiturageLabels = <?= json_encode(array_column($covoiturage_data, 'jour')) ?>;
    const covoiturageCounts = <?= json_encode(array_column($covoiturage_data, 'total')) ?>;

    const ctx1 = document.getElementById('covoituragesChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: covoiturageLabels,
            datasets: [{
                label: 'Covoiturages par jour',
                data: covoiturageCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
    });

    const creditsLabels = <?= json_encode(array_column($credits_data, 'jour')) ?>;
    const creditsTotals = <?= json_encode(array_map('floatval', array_column($credits_data, 'total'))) ?>;

    const ctx2 = document.getElementById('creditsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: creditsLabels,
            datasets: [{
                label: 'Crédits gagnés par jour',
                data: creditsTotals,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
    });
</script>

</body>
</html>
