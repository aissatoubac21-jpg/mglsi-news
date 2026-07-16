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

$categories = $pdo->query("SELECT * FROM Categorie")->fetchAll(PDO::FETCH_ASSOC);
$erreur = null;

// Traitement de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $categorie = $_POST['categorie'] ?? '';

    if ($titre === '' || $contenu === '' || $categorie === '' || !is_numeric($categorie)) {
        $erreur = "Merci de remplir tous les champs (titre, contenu et catégorie).";
        // On garde les valeurs saisies affichées dans le formulaire malgré l'erreur
        $article['titre'] = $titre;
        $article['contenu'] = $contenu;
        $article['categorie'] = $categorie;
    } else {
        $stmt = $pdo->prepare("UPDATE Article SET titre = ?, contenu = ?, categorie = ?, dateModification = NOW() WHERE id = ?");
        $stmt->execute([$titre, $contenu, (int)$categorie, $id]);
        header('Location: article.php?id=' . $id);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article - Polytech Actu</title>
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
    <h2 class="page-title">Modifier l'article</h2>

    <?php if ($erreur): ?>
        <div class="alerte-erreur"><?php echo htmlspecialchars($erreur); ?></div>
    <?php endif; ?>

    <form method="post" action="modifier.php?id=<?php echo $id; ?>" class="form-article">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>

        <label for="categorie">Catégorie</label>
        <select id="categorie" name="categorie" required>
            <option value="">-- Choisir une catégorie --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo ($article['categorie'] == $cat['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['libelle']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="contenu">Contenu</label>
        <textarea id="contenu" name="contenu" rows="10" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>

        <button type="submit" class="btn-submit">Enregistrer les modifications</button>
    </form>
</div>

</body>
</html>
