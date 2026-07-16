<?php
// VERSION SIMPLE - Pas de classe, pas de couche : juste une connexion PDO
// réutilisée par un simple include dans chaque page.
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=mglsi_news;charset=utf8',
        'mglsi_user',
        'passer'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>