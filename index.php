<?php
require_once 'classes/MasterMind.php';
session_start();

// Rediriger vers la sélection de difficulté si elle n'est pas encore définie
if (!isset($_SESSION['difficulte'])) {
    header("Location: home.php");
}

// Créer un objet MasterMind et générer le code secret
$mastermind = new MasterMind();

//Définition des variables 
$codeSecret = $mastermind->getCodeSecret();
$essais = isset($_SESSION['essais']) ? $_SESSION['essais'] : [];
$nbEssais = isset($_SESSION['nbEssais']) ? $_SESSION['nbEssais'] : 0;
$difficulte = isset($_SESSION['difficulte']) ? $_SESSION['difficulte'] : null;
$nbEssaisMax = $mastermind->getNbEssaisMax();

$codeJoueur = [];
$victoire = false;
$perdu = false;
$HideForm = false;

//BOUTON VALIDER
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['codeJoueur'])) {

    //Récupérer la combinaison du joueur
    $codeJoueur = array_map('intval', $_POST['codeJoueur']);
    $mastermind->setCodeJoueur($codeJoueur);
    //Appel de la méthode pour vérifier les deux codes
    $resultat = $mastermind->verifierCombinaison();
    // Ajouter l'essai au tableau des essais
    $mastermind->ajouterEssai($codeJoueur, $resultat);
    $essais[] = ['codeJoueur' => $codeJoueur, 'resultat' => $resultat];
    $_SESSION['essais'] = $essais;
    // $_SESSION['essais'] = $mastermind->getEssais();
    // Incrémenter le nombre d'essais
    $nbEssais++;
    $_SESSION['nbEssais'] = $nbEssais;
    // Vérifier si le joueur a gagné
    if ($resultat['pionsBlancs'] == $mastermind->getTaillePlateau()) {
        $victoire = true;
    }
    // Vérifier si le joueur a atteint le nombre maximum d'essais
    if ($nbEssais >= $nbEssaisMax) {
        $perdu = true;
    }
}

//BOUTON REJOUER
if (isset($_POST['reset'])) {
    //Arreter la session pour réinitialiser le code secret
    session_unset();
    session_destroy();
    //Redémarrer la session
    session_start();
    //Créer un nouvel objet MasterMind
    $mastermind = new MasterMind();
    //Rediriger vers la même page
    header("Location: home.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <title>MasterMind</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link  href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
        <h1 class="alert alert-primary">MasterMind</h1>
        <div class="alert alert-secondary">
            <h3>Difficulté : <?php echo $difficulte; ?></h3>
            <h5>Vous avez <?php echo $nbEssaisMax; ?> essais ou moins pour gagner la partie</h5>
            <p>Rappelez vous ! un pion <span class="rouge">rouge</span> par chiffre juste mais mal placé, et un pion <span class="blanc">blanc</span> par chiffre bien placé.</p>
        </div>

        <!-- Nombre d'essais du joueur -->
        <div>  
            <h5>Essais : <?php echo $nbEssais;?></h5>
        </div>
        <!-- Grille de jeu -->
        <div class="grille">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Proposition</th>
                        <th scope="col"><span class="pion rouge">&bull;</span></th>
                        <th scope="col"><span class="pion blanc">&bull;</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($essais as $i => $essai) {
                        echo "<tr>";
                        echo "<td>" . implode('', $essai['codeJoueur']) . "</td>";
                        echo "<td>" . $essai['resultat']['pionsRouges'] . "</td>";
                        echo "<td>" . $essai['resultat']['pionsBlancs'] . "</td>";
                        echo "</tr>";
                    } 
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Affichage du message de victoire ou de défaite -->
        <?php 
        if ($victoire):
            $HideForm = true;
            echo '<div class="alert alert-success mt-3">
                    <h3>Bravo ! vous êtes un génie du MasterMind !</h3>
                </div>';
        elseif ($perdu): 
            $HideForm = true;
            echo '<div class="alert alert-danger">
                    <h3>Dommage ! Vous avez perdu après ' . $nbEssaisMax . ' essais. Le code secret était : ' . implode('', $codeSecret) . '</h3>
                </div>';
        endif;
        ?>
        
        <!-- Formulaire Combinaison Utilisateur -->
        <form method="POST" <?php if ($HideForm===true){?>style="display:none"<?php } ?>>
            <h5>Entrez votre combinaison (4 chiffres entre 1 et 6) :</h5>  
            <input type="number" name="codeJoueur[]" min="1" max="6" required>
            <input type="number" name="codeJoueur[]" min="1" max="6" required>
            <input type="number" name="codeJoueur[]" min="1" max="6" required>
            <input type="number" name="codeJoueur[]" min="1" max="6" required>
            <br><br>
                <button type="submit" class="btn btn-primary"  <?php if ($victoire){ ?> disabled <?php   } ?>>Valider</button>
            </form>

            <!-- Bouton Rejouer -->
            <form method="POST">
                <br>
                <h5>Recommencer la partie : </h5>
                <button type="submit" name="reset" value="1" class="btn btn-success">Rejouer</button>
                <br>
            </form>            
        </main>
    </body>
</html>
