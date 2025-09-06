<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

$email = $_SESSION['email'];
$stmt = $pdo->prepare("SELECT id, credit FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
$user_id = $user['id'];
$user_credit = $user['credit'];

$stmt = $pdo->prepare("SELECT id, modele, plaque FROM cars WHERE user_id = ?");
$stmt->execute([$user_id]);
$voitures = $stmt->fetchAll();

$message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($user_credit < 2) {
        $message = "❌ Vous devez avoir au moins 2 crédits pour proposer un trajet.";
    } else {
        $depart = $_POST['depart'];
        $arrivee = $_POST['arrivee'];
        $date_depart = $_POST['date_depart'];
        $date_arrivee = $_POST['date_arrivee'];
        $prix = $_POST['prix'];
        $places = $_POST['place'];
        $voiture_id = $_POST['voiture'];

        $stmt = $pdo->prepare("INSERT INTO trajets (chauffeur_id, voiture_id, depart, arrivee, prix, date_depart, places_disponibles, statut) VALUES (?, ?, ?, ?, ?, ?, ?, 'en_attente')");
        $stmt->execute([$user_id, $voiture_id, $depart, $arrivee, $prix, $date_depart, $places]);

        $pdo->prepare("UPDATE users SET credit = credit - 2 WHERE id = ?")->execute([$user_id]);

        $message = "✅ Trajet ajouté avec succès ! 2 crédits ont été déduits. En attente de validation par un employé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un trajet</title>
</head>
<body>
<h1>Proposer un nouveau trajet</h1>

<?php if ($message): ?>
    <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<form method="post">
    <label>Adresse de départ :</label><br>
    <input type="text" name="depart" required><br><br>

    <label>Adresse d’arrivée :</label><br>
    <input type="text" name="arrivee" required><br><br>

    <label>Date et heure du départ :</label><br>
    <input type="datetime-local" name="date_depart" required><br><br>

    <label>Date et heure d’arrivée :</label><br>
    <input type="datetime-local" name="date_arrivee"><br><br>

    <label>Nombre de places disponibles :</label><br>
    <input type="number" name="place" required><br><br>

    <label>Prix total demandé (crédit) :</label><br>
    <input type="number" name="prix" step="0.1" required><br><br>

    <label>Choisir un véhicule :</label><br>
    <select name="voiture" required>
        <?php foreach ($voitures as $voiture): ?>
            <option value="<?= $voiture['id'] ?>">
                <?= htmlspecialchars($voiture['modele']) ?> - <?= htmlspecialchars($voiture['plaque']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p><a href="ajout_cars.php">Ajouter une nouvelle voiture</a></p><br><br>

    <button type="submit">Valider le trajet</button>
    <a href="users.php"><button type="button">Retour</button></a>
</form>
</body>
</html>
