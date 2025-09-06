<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin - EcoRide</title>
</head>
<html>

<body> 

<h1>Espace Administrateur</h1>

<ul>
    <li><a href="ajout_employe.php">Ajouter un employé</a></li>
    <li><a href="graphiques.php">Graphiques</a></li>
    <li><a href="gestion_compte.php">Gestion des comptes</a></li>
    <li><a href="logout.php">Déconnexion</a></li>
</ul>
</body>
</html>