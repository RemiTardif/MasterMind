<?php
abstract class Jeu {

    // Propriétés de base
    protected $codeSecret;
    protected $codeJoueur;
    protected $taillePlateau;
    protected $nbEssaisMax;
    protected $essais;

    // Constructeur
    public function __construct($taillePlateau, $nbEssaisMax) {
        $this->taillePlateau = $taillePlateau;
        $this->nbEssaisMax = $nbEssaisMax;
        $this->essais = [];
    }

    // Méthode pour définir le code du joueur
    public function setCodeJoueur($code) {
        $this->codeJoueur = $code;
    }

    // Méthode pour récupérer le code du joueur
    public function getCodeJoueur() {
        return $this->codeJoueur;
    }

    // Méthode pour récupérer la taille du plateau
    public function getTaillePlateau() {
        return $this->taillePlateau;
    }

    // Méthode pour récupérer le nombre maximum d'essais
    public function getNbEssaisMax() {
        return $this->nbEssaisMax;
    }

    // Méthode pour ajouter un essai
    public function ajouterEssai($codeJoueur, $resultat) {
        $this->essais[] = ['codeJoueur' => $codeJoueur, 'resultat' => $resultat];
    }

    // Méthode pour obtenir les essais
    public function getEssais() {
        return $this->essais;
    }
}
?>
