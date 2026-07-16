<?php
// 1. On charge la classe Contrôleur
require_once 'controllers/NewsController.php';

// 2. On instancie le contrôleur
$controller = new NewsController();

// 3. On analyse l'action demandée dans l'URL
$action = isset($_GET['action']) ? $_GET['action'] : 'accueil';

// 4. Routage ultra propre
switch ($action) {
    case 'accueil':
        $controller->afficherAccueil();
        break;

    case 'categorie':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $controller->afficherParCategorie((int)$_GET['id']);
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    case 'article':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $controller->afficherArticle((int)$_GET['id']);
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    case 'nouveau':
        $controller->afficherFormulaireAjout();
        break;

    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->ajouterArticle();
        } else {
            header('Location: index.php?action=nouveau');
            exit;
        }
        break;

    case 'editer':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $controller->afficherFormulaireEdition((int)$_GET['id']);
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    case 'modifier':
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->modifierArticle((int)$_GET['id']);
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    case 'supprimer':
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->supprimerArticle((int)$_GET['id']);
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    default:
        $controller->afficherAccueil();
        break;
}
?>