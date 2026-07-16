<?php
/**
 * CLASSE DATABASE - DESIGN PATTERN SINGLETON (Couche Persistance)
 * * Assure qu'une seule et unique connexion à la base de données mglsi_news 
 * est ouverte durant toute l'exécution du script, économisant ainsi les ressources du serveur.
 */
class Database {
    // Variable statique privée qui va contenir l'unique instance de notre classe Database
    private static $instance = null;
    
    // Variable contenant l'objet PDO actif
    private $pdo;

    /**
     * LE CONSTRUCTEUR EST PRIVÉ : Interdiction absolue de faire un "new Database()" à l'extérieur.
     * Seule la classe elle-même peut s'instancier.
     */
    private function __construct() {
        try {
            // Configuration de PDO avec les paramètres définis par le script SQL
            $this->pdo = new PDO(
                'mysql:host=localhost;dbname=mglsi_news;charset=utf8', 
                'mglsi_user', 
                'passer'
            );
            // Mode d'erreur configuré sur EXCEPTION pour capturer et tracer immédiatement le moindre bug SQL
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Sécurité : En cas d'échec de connexion, interruption propre du script avec message explicite
            die("Erreur critique d'accès à l'infrastructure de données : " . $e->getMessage());
        }
    }

    /**
     * POINT D'ACCÈS UNIQUE ET GLOBAL : Méthode statique permettant de récupérer l'instance unique.
     * Si elle n'existe pas encore, elle la crée. Si elle existe déjà, elle la retourne simplement.
     * * @return Database L'instance unique globale
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Accesseur (Getter) permettant de récupérer l'objet de connexion PDO actif.
     * * @return PDO L'objet de connexion de l'API PHP
     */
    public function getPdo() {
        return $this->pdo;
    }

    /**
     * MÉTHODES DE SÉCURITÉ : On interdit le clonage et la désérialisation de l'objet
     * pour empêcher le contournement du pattern Singleton par des scripts malveillants.
     */
    private function __clone() {}
    public function __wakeup() {
        throw new Exception("Opération interdite : Impossible de désérialiser un Singleton.");
    }
}
?>