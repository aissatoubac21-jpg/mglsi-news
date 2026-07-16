<?php
// Détermine quelle catégorie est active dans le menu (utilisé par le partiel menu.php)
$idCategorie = (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'categorie') ? (int)$_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Polytech Actu</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php require 'views/partials/menu.php'; ?>

<div class="main-container">
    <h2 class="page-title">Les dernières actualités</h2>

    <a class="btn-new" href="index.php?action=nouveau">+ Rédiger un nouvel article</a>

    <?php if (empty($listeArticles)): ?>
        <p class="no-data">Aucun article disponible.</p>
    <?php else: ?>
        <?php foreach ($listeArticles as $art): ?>
            <a href="index.php?action=article&id=<?php echo $art->getId(); ?>" class="card-link">
                <div class="card-article">
                    <h3><?php echo htmlspecialchars($art->getTitre()); ?></h3>
                    <p><?php echo htmlspecialchars($art->getContenu()); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
