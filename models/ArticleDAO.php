<?php
require_once 'Database.php';
require_once 'Article.php';

/**
 * CLASSE ARTICLEDAO (Couche Persistance)
 * * Centralise et isole toutes les requêtes SQL appliquées à la table 'Article'.
 */
class ArticleDAO {
    // Contient la référence de connexion partagée
    private $pdo;

    public function __construct() {
        // EXCELLENCE : Récupération de l'unique instance de connexion via le Singleton
        $this->pdo = Database::getInstance()->getPdo();
    }

    /**
     * Récupère l'intégralité des articles.
     * Requête simple car elle ne comporte aucune variable provenant de l'utilisateur extérieur.
     * * @return array Tableau d'objets métier de type 'Article'
     */
    public function getArticles() {
        $articles = [];
        $sql = "SELECT * FROM Article ORDER BY dateCreation DESC";
        $resultat = $this->pdo->query($sql);

        // Mapping Objet-Relationnel : conversion de chaque ligne SQL en objet exploitable par PHP
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = new Article(
                $ligne['id'],
                $ligne['titre'],
                $ligne['contenu'],
                $ligne['dateCreation'],
                $ligne['categorie']
            );
        }
        return $articles;
    }

    /**
     * Récupère les articles appartenant à une catégorie spécifique.
     * EXCELLENCE SÉCURITÉ : Requête préparée obligatoire pour immuniser l'application contre les injections SQL.
     * * @param int $categorieId Identifiant numérique de la catégorie cible
     * @return array Tableau d'objets 'Article'
     */
    public function getArticlesByCategorie($categorieId) {
        $articles = [];
        // Utilisation du marqueur anonyme '?' pour préparer l'emplacement du paramètre
        $sql = "SELECT * FROM Article WHERE categorie = ? ORDER BY dateCreation DESC";
        
        $stmt = $this->pdo->prepare($sql); // Précompilation de la structure de la requête par MySQL
        $stmt->execute([$categorieId]);    // Injection de la valeur après nettoyage automatique par PDO

        while ($ligne = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = new Article(
                $ligne['id'],
                $ligne['titre'],
                $ligne['contenu'],
                $ligne['dateCreation'],
                $ligne['categorie']
            );
        }
        return $articles;
    }

    /**
     * Récupère un seul article précis via son identifiant unique.
     * * @param int $id Identifiant de l'article à lire
     * @return Article|null Renvoie l'objet trouvé ou NULL si l'identifiant n'existe pas en BBD
     */
    public function getArticleById($id) {
        $sql = "SELECT * FROM Article WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        
        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($ligne) {
            return new Article(
                $ligne['id'],
                $ligne['titre'],
                $ligne['contenu'],
                $ligne['dateCreation'],
                $ligne['categorie']
            );
        }
        return null;
    }

    /**
     * Insère un nouvel article en base de données.
     * EXCELLENCE SÉCURITÉ : Requête préparée pour éviter toute injection SQL.
     * * @param string $titre Titre de l'article
     * @param string $contenu Corps de l'article
     * @param int $categorie Identifiant de la catégorie associée
     * @return bool Succès ou échec de l'insertion
     */
    public function ajouter($titre, $contenu, $categorie) {
        $sql = "INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $contenu, $categorie]);
    }

    /**
     * Met à jour un article existant et rafraîchit sa date de modification.
     * * @param int $id Identifiant de l'article à modifier
     * @param string $titre Nouveau titre
     * @param string $contenu Nouveau contenu
     * @param int $categorie Nouvelle catégorie
     * @return bool Succès ou échec de la mise à jour
     */
    public function modifier($id, $titre, $contenu, $categorie) {
        $sql = "UPDATE Article SET titre = ?, contenu = ?, categorie = ?, dateModification = NOW() WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $contenu, $categorie, $id]);
    }

    /**
     * Supprime définitivement un article de la base de données.
     * * @param int $id Identifiant de l'article à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function supprimer($id) {
        $sql = "DELETE FROM Article WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>