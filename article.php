<?php
require 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Article WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header('Location: index.php');
    exit;
}

// Catégories pour le menu de navigation (même logique répétée que sur index.php,
// car ceci est la version SANS architecture : chaque page se débrouille seule)
$categories = $pdo->query("SELECT * FROM Categorie")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($article['titre']); ?> - Polytech Actu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    Actualités Polytechniciennes
</header>

<nav>
    <a href="index.php" class="accueil">Accueil</a>
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?id=<?php echo $cat['id']; ?>" class="categorie <?php echo ((int)$cat['id'] === (int)$article['categorie']) ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($cat['libelle']); ?>
        </a>
    <?php endforeach; ?>
</nav>

<div class="main-container">
    <div class="article-wrapper">
        <h2 class="article-title"><?php echo htmlspecialchars($article['titre']); ?></h2>
        <span class="date-badge">Publié le : <?php echo $article['dateCreation']; ?></span>
        <div class="article-body"><?php echo nl2br(htmlspecialchars($article['contenu'])); ?></div>

        <div class="article-actions">
            <a class="btn-edit" href="modifier.php?id=<?php echo $article['id']; ?>">Modifier</a>
            <form method="post" action="supprimer.php" onsubmit="return confirm('Supprimer définitivement cet article ?');" style="margin:0;">
                <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                <button type="submit" class="btn-delete">Supprimer</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
