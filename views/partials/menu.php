<?php
// Partiel de vue réutilisé par toutes les pages (Accueil, Article, Formulaire, Erreur).
// Détermine quel onglet du menu doit être surligné en fonction du contexte.
$categorieActiveId = null;
if (isset($idCategorie)) {
    $categorieActiveId = $idCategorie;
} elseif (isset($article) && $article !== null) {
    $categorieActiveId = $article->getCategorie();
}
$accueilActif = !isset($_GET['action']) || $_GET['action'] === 'accueil';
?>
<header>
    Actualités Polytechniciennes
</header>

<nav>
    <a href="index.php?action=accueil" class="accueil <?php echo $accueilActif ? 'active' : ''; ?>">Accueil</a>
    <?php foreach ($listeCategories as $cat): ?>
        <a href="index.php?action=categorie&id=<?php echo $cat->getId(); ?>" class="categorie <?php echo ($categorieActiveId == $cat->getId()) ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($cat->getLibelle()); ?>
        </a>
    <?php endforeach; ?>
</nav>
