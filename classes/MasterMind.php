<?php
class MasterMind {

    //Propriétés
    private $codeSecret;
    private $codeJoueur;
    private $taillePlateau = 4;

    //Constructeur
    public function __construct(){
        if (!isset($_SESSION['codeSecret'])) {
            $this->CreercodeSecret();
        } else {
            //Récupérer le code secret de la session
            $this->codeSecret = $_SESSION['codeSecret'];
        }

    }

    //Génerer la combinaison Ordi
    private function CreercodeSecret(){
        $this->codeSecret = [];
        $valeurs = range(1, 6);
        //Melange les valeurs du tableau
        shuffle($valeurs);
        //Recupere les 4 premiers chiffres
        $this->codeSecret = array_slice($valeurs, 0, $this->taillePlateau);
        $_SESSION['codeSecret'] = $this->codeSecret;
    }
    //get Combinaison Ordi
    public function getSecret()
    {
        return $this->codeSecret;
    }

    //la combinaison Joueur
    public function setCodeJoueur($code){
        $this->codeJoueur= $code;
    }

    //get Combinaison Joueur
    public function getCodeJoueur()
    {
        return $this->codeJoueur;
    }
    //Get taille du plateau
    public function getTaillePlateau() {
        return $this->taillePlateau;
    }

    //Fonction qui prend en compte la combinaison ordi et joueur et renvoi le résultat
     public function verifierCombinaison() {
        $pionsRouges = 0;
        $pionsBlancs = 0;
        //Tableau  des positions
        $codeSecretTab = array_fill(0, $this->taillePlateau, false);
        $codeJoueurTab = array_fill(0, $this->taillePlateau, false);
        //Vérifie les pions blancs 
        for ($i = 0; $i < $this->taillePlateau; $i++) {
            if ($this->codeJoueur[$i] === $this->codeSecret[$i]) {
                $pionsBlancs++;
                $codeSecretTab[$i] = true;
                $codeJoueurTab[$i] = true;
            }
        }
        //Vérifie les pions rouges
        for ($i = 0; $i < $this->taillePlateau; $i++) {
            if (!$codeJoueurTab[$i]) {
                for ($j = 0; $j < $this->taillePlateau; $j++) {
                    if (!$codeSecretTab[$j] && $this->codeJoueur[$i] === $this->codeSecret[$j]) {
                        $pionsRouges++;
                        $codeSecretTab[$j] = true;
                    }
                }
            }
        }
        //Retourne un tableau des résultats 
        return ['pionsRouges' => $pionsRouges, 'pionsBlancs' => $pionsBlancs];
    }

}