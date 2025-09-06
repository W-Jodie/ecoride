<?php
session_start();
require_once '../BACK/db.php';

$avis = $pdo->query("
    SELECT a.id, a.commentaire, a.note, a.date_avis,
           u.pseudo AS auteur, c.pseudo AS chauffeur
    FROM avis a
    JOIN users u ON a.auteur_id = u.id
    JOIN users c ON a.chauffeur_id = c.id
    WHERE a.valide = 0
")->fetchAll();
?>

<h2>Avis en attente</h2>

<?php foreach ($avis as $a) : ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong>Auteur :</strong> <?= htmlspecialchars($a['auteur']) ?><br>
        <strong>Chauffeur :</strong> <?= htmlspecialchars($a['chauffeur']) ?><br>
        <strong>Note :</strong> <?= $a['note'] ?>/5<br>
        <strong>Commentaire :</strong><br>
        <em><?= nl2br(htmlspecialchars($a['commentaire'])) ?></em><br>
        <form method="post" action="traiter_avis.php">
            <input type="hidden" name="avis_id" value="<?= $a['id'] ?>">
            <button name="action" value="valider">Valider</button>
            <button name="action" value="refuser">Refuser</button>
        </form>
    </div>
<?php endforeach; ?>
