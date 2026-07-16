<?php
require 'config.php';

// Récupération des catégories
$categories = $pdo->query("SELECT * FROM Categorie")->fetchAll(PDO::FETCH_ASSOC);

// Récupération de l'ID (gestion sécurisée comme vous l'avez fait)
$idCategorie = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;

if ($idCategorie) {
    $stmt = $pdo->prepare("SELECT * FROM Article WHERE categorie = ? ORDER BY dateCreation DESC");
    $stmt->execute([$idCategorie]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $articles = $pdo->query("SELECT * FROM Article ORDER BY dateCreation DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Polytech Actu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    Actualités Polytechniciennes
</header>

<nav>
    <a href="index.php" class="accueil <?php echo ($idCategorie === null) ? 'active' : ''; ?>">Accueil</a>
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?id=<?php echo $cat['id']; ?>" class="categorie <?php echo ($idCategorie === (int)$cat['id']) ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($cat['libelle']); ?>
        </a>
    <?php endforeach; ?>
</nav>

<div class="main-container">
    <h2 class="page-title">Les dernières actualités</h2>

    <a class="btn-new" href="ajouter.php">+ Rédiger un nouvel article</a>

    <?php if (empty($articles)): ?>
        <p style="text-align: center; color: #666;">Aucun article disponible.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <a href="article.php?id=<?php echo $article['id']; ?>" class="card-link">
                <div class="card-article">
                    <h3><?php echo htmlspecialchars($article['titre']); ?></h3>
                    <p><?php echo htmlspecialchars($article['contenu']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>