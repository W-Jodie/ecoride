<?php
require_once '../BACK/db.php';

$stmt = $pdo->query("SELECT id, pseudo, email, role, statut FROM users ORDER BY role, pseudo");
$comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des comptes</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 40px auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
        }
        .suspendu {
            background-color: #f8d7da;
        }
        .actif {
            background-color: #d4edda;
        }
        .section-header {
            background-color: #ccc;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Gestion des comptes</h1>

<table>
    <tr>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Statut</th>
        <th>Action</th>
    </tr>

    <?php
    $roleCourant = null;
    foreach ($comptes as $compte):
        if ($compte['role'] !== $roleCourant):
            $roleCourant = $compte['role'];
            echo '<tr class="section-header"><td colspan="5">' . strtoupper($roleCourant) . 'S</td></tr>';
        endif;
    ?>
        <tr class="<?= $compte['statut'] ?>">
            <td><?= htmlspecialchars($compte['pseudo']) ?></td>
            <td><?= htmlspecialchars($compte['email']) ?></td>
            <td><?= htmlspecialchars($compte['role']) ?></td>
            <td><?= $compte['statut'] ?></td>
            <td>
                <form method="POST" action="suspendre.php">
                    <input type="hidden" name="user_id" value="<?= $compte['id'] ?>">
                    <input type="hidden" name="action" value="<?= $compte['statut'] === 'actif' ? 'Suspendre' : 'Reactiver' ?>">
                    <button type="submit">
                        <?= $compte['statut'] === 'actif' ? 'Suspendre' : 'Réactiver' ?>
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>