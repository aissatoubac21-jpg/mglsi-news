<?php
// Cette classe représente l'entité Article (Couche Domaine)
class Article {
    // Les attributs correspondent aux colonnes de la table SQL
    private $id;
    private $titre;
    private $contenu;
    private $dateCreation;
    private $categorie;

    // Le constructeur initialise l'objet avec les données
    public function __construct($id, $titre, $contenu, $dateCreation, $categorie) {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->dateCreation = $dateCreation;
        $this->categorie = $categorie;
    }

    // Les "Getters" permettent de récupérer les valeurs (Encapsulation)
    public function getId() { return $this->id; }
    public function getTitre() { return $this->titre; }
    public function getContenu() { return $this->contenu; }
    public function getDateCreation() { return $this->dateCreation; }
    public function getCategorie() { return $this->categorie; }
}
?>