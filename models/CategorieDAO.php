<?php
require_once 'Database.php';
require_once 'Categorie.php';

/**
 * CLASSE CATEGORIEDAO (Couche Persistance)
 * * Centralise et isole toutes les requêtes SQL appliquées à la table 'Categorie'.
 */
class CategorieDAO {
    private $pdo;

    public function __construct() {
        // EXCELLENCE : Utilisation de la même instance de connexion partagée
        $this->pdo = Database::getInstance()->getPdo();
    }

    /**
     * Récupère l'ensemble des catégories présentes en base de données.
     * Indispensable pour générer dynamiquement le menu de navigation de l'interface utilisateur.
     * * @return array Tableau d'objets métier de type 'Categorie'
     */
    public function getCategories() {
        $categories = [];
        $sql = "SELECT * FROM Categorie";
        $resultat = $this->pdo->query($sql);

        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Categorie($ligne['id'], $ligne['libelle']);
        }
        return $categories;
    }
}
?>