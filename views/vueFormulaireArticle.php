<?php
$estEdition = isset($article) && $article !== null;
$actionUrl = $estEdition ? 'index.php?action=modifier&id=' . $article->getId() : 'index.php?action=ajouter';
$valeurTitre = $estEdition ? $article->getTitre() : ($_POST['titre'] ?? '');
$valeurContenu = $estEdition ? $article->getContenu() : ($_POST['contenu'] ?? '');
$categorieSelectionnee = $estEdition ? $article->getCategorie() : ($_POST['categorie'] ?? null);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $estEdition ? 'Modifier un article' : 'Nouvel article'; ?> - Polytech Actu</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php require 'views/partials/menu.php'; ?>

<div class="main-container">
    <h2 class="page-title"><?php echo htmlspecialchars($titrePage); ?></h2>

    <?php if (!empty($messageErreur)): ?>
        <div class="alerte-erreur"><?php echo htmlspecialchars($messageErreur); ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($actionUrl); ?>" class="form-article">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($valeurTitre); ?>" required>

        <label for="categorie">Catégorie</label>
        <select id="categorie" name="categorie" required>
            <option value="">-- Choisir une catégorie --</option>
            <?php foreach ($listeCategories as $cat): ?>
                <option value="<?php echo $cat->getId(); ?>" <?php echo ($categorieSelectionnee == $cat->getId()) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat->getLibelle()); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="contenu">Contenu</label>
        <textarea id="contenu" name="contenu" rows="10" required><?php echo htmlspecialchars($valeurContenu); ?></textarea>

        <button type="submit" class="btn-submit"><?php echo $estEdition ? 'Enregistrer les modifications' : "Publier l'article"; ?></button>
    </form>
</div>

</body>
</html>
