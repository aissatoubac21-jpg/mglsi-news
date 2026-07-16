<?php
// On charge les modèles nécessaires (les chemins tiennent compte du dossier models/)
require_once 'models/ArticleDAO.php';
require_once 'models/CategorieDAO.php';

class NewsController {
    private $articleDAO;
    private $categorieDAO;

    public function __construct() {
        $this->articleDAO = new ArticleDAO();
        $this->categorieDAO = new CategorieDAO();
    }

    // Action 1 : Afficher l'accueil
    public function afficherAccueil() {
        $listeCategories = $this->categorieDAO->getCategories();
        $listeArticles = $this->articleDAO->getArticles();
        $titrePage = "Fil d'actualité général";
        
        // On charge la vue depuis le dossier views/
        require 'views/vueAccueil.php';
    }

    // Action 2 : Afficher par catégorie
    public function afficherParCategorie($idCat) {
        $listeCategories = $this->categorieDAO->getCategories();
        $listeArticles = $this->articleDAO->getArticlesByCategorie($idCat);
        $titrePage = "Sélection par thématique";
        
        require 'views/vueAccueil.php';
    }

    // Action 3 : Lire un article complet
    public function afficherArticle($idArticle) {
        $listeCategories = $this->categorieDAO->getCategories(); // Pour garder le menu actif
        $article = $this->articleDAO->getArticleById($idArticle);
        
        if ($article !== null) {
            require 'views/vueArticle.php';
        } else {
            $messageErreur = "L'article demandé n'existe pas.";
            require 'views/vueErreur.php';
        }
    }

    // Action 4 : Afficher le formulaire de création
    public function afficherFormulaireAjout() {
        $listeCategories = $this->categorieDAO->getCategories();
        $titrePage = "Rédiger un nouvel article";
        $article = null; // mode création : formulaire vide

        require 'views/vueFormulaireArticle.php';
    }

    // Action 5 : Traiter la soumission de création
    public function ajouterArticle() {
        $erreur = $this->validerSaisie($_POST);

        if ($erreur !== null) {
            $listeCategories = $this->categorieDAO->getCategories();
            $titrePage = "Rédiger un nouvel article";
            $article = null;
            $messageErreur = $erreur;
            require 'views/vueFormulaireArticle.php';
            return;
        }

        $this->articleDAO->ajouter($_POST['titre'], $_POST['contenu'], (int)$_POST['categorie']);
        header('Location: index.php');
        exit;
    }

    // Action 6 : Afficher le formulaire d'édition pré-rempli
    public function afficherFormulaireEdition($idArticle) {
        // On récupère listeCategories AVANT le contrôle d'existence, pour que le
        // menu de navigation reste disponible même sur la vue d'erreur.
        $listeCategories = $this->categorieDAO->getCategories();
        $article = $this->articleDAO->getArticleById($idArticle);

        if ($article === null) {
            $messageErreur = "L'article demandé n'existe pas.";
            require 'views/vueErreur.php';
            return;
        }

        $titrePage = "Modifier l'article";
        require 'views/vueFormulaireArticle.php';
    }

    // Action 7 : Traiter la soumission de modification
    public function modifierArticle($idArticle) {
        $erreur = $this->validerSaisie($_POST);

        if ($erreur !== null) {
            $article = $this->articleDAO->getArticleById($idArticle);
            $listeCategories = $this->categorieDAO->getCategories();
            $titrePage = "Modifier l'article";
            $messageErreur = $erreur;
            require 'views/vueFormulaireArticle.php';
            return;
        }

        $this->articleDAO->modifier($idArticle, $_POST['titre'], $_POST['contenu'], (int)$_POST['categorie']);
        header('Location: index.php?action=article&id=' . $idArticle);
        exit;
    }

    // Action 8 : Supprimer un article
    public function supprimerArticle($idArticle) {
        $this->articleDAO->supprimer($idArticle);
        header('Location: index.php');
        exit;
    }

    // Validation minimale des champs du formulaire (couche Contrôle)
    private function validerSaisie($donnees) {
        $titre = trim($donnees['titre'] ?? '');
        $contenu = trim($donnees['contenu'] ?? '');
        $categorie = $donnees['categorie'] ?? '';

        if ($titre === '' || $contenu === '' || $categorie === '' || !is_numeric($categorie)) {
            return "Merci de remplir tous les champs (titre, contenu et catégorie).";
        }
        return null;
    }
}
?>