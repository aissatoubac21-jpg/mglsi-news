<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($article->getTitre()); ?> - Polytech Actu</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php require 'views/partials/menu.php'; ?>

<div class="main-container">
    <div class="article-wrapper">
        <h2 class="article-title"><?php echo htmlspecialchars($article->getTitre()); ?></h2>
        <span class="date-badge">Publié officiellement le : <?php echo $article->getDateCreation(); ?></span>

        <div class="article-body">
            <?php echo nl2br(htmlspecialchars($article->getContenu())); ?>
        </div>

        <div class="article-actions">
            <a class="btn-edit" href="index.php?action=editer&id=<?php echo $article->getId(); ?>">Modifier</a>
            <form method="post" action="index.php?action=supprimer&id=<?php echo $article->getId(); ?>"
                  onsubmit="return confirm('Supprimer définitivement cet article ?');" style="margin:0;">
                <button type="submit" class="btn-delete">Supprimer</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
