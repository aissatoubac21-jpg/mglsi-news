<?php
require 'config.php';

$categories = $pdo->query("SELECT * FROM Categorie")->fetchAll(PDO::FETCH_ASSOC);
$erreur = null;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $categorie = $_POST['categorie'] ?? '';

    if ($titre === '' || $contenu === '' || $categorie === '' || !is_numeric($categorie)) {
        $erreur = "Merci de remplir tous les champs (titre, contenu et catégorie).";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)");
        $stmt->execute([$titre, $contenu, (int)$categorie]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rédiger un article - Polytech Actu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    Actualités Polytechniciennes
</header>

<nav>
    <a href="index.php" class="accueil">Accueil</a>
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?id=<?php echo $cat['id']; ?>" class="categorie"><?php echo htmlspecialchars($cat['libelle']); ?></a>
    <?php endforeach; ?>
</nav>

<div class="main-container">
    <h2 class="page-title">Rédiger un nouvel article</h2>

    <?php if ($erreur): ?>
        <div class="alerte-erreur"><?php echo htmlspecialchars($erreur); ?></div>
    <?php endif; ?>

    <form method="post" action="ajouter.php" class="form-article">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>" required>

        <label for="categorie">Catégorie</label>
        <select id="categorie" name="categorie" required>
            <option value="">-- Choisir une catégorie --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo ((isset($_POST['categorie']) && $_POST['categorie'] == $cat['id']) ? 'selected' : ''); ?>>
                    <?php echo htmlspecialchars($cat['libelle']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="contenu">Contenu</label>
        <textarea id="contenu" name="contenu" rows="10" required><?php echo htmlspecialchars($_POST['contenu'] ?? ''); ?></textarea>

        <button type="submit" class="btn-submit">Publier l'article</button>
    </form>
</div>

</body>
</html>
