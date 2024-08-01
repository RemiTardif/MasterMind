<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['difficulte'])) {
    $_SESSION['difficulte'] = $_POST['difficulte'];
    
    if ($_SESSION['difficulte'] == 'facile') {
        $_SESSION['nbEssaisMax'] = 15;
    } elseif ($_SESSION['difficulte'] == 'moyen') {
        $_SESSION['nbEssaisMax'] = 10;
    } elseif ($_SESSION['difficulte'] == 'difficile') {
        $_SESSION['nbEssaisMax'] = 5;
    }
    
    header("Location: index.php");
}
?>

<!doctype html>
<html>
<head>
    <title>MasterMind - Choisir la difficulté</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link  href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
        <h1 class="alert alert-primary">MasterMind - Choisir la difficulté</h1>
        <div class="alert alert-info">
            <h4>Règles du jeu :</h4>
            <p>L’ordinateur choisi une combinaison à 4 chiffres entre 1 et 6.</p>
            <p>Le joueur propose une combinaison. L’ordinateur lui retourne un code sous forme de pions sans préciser quel chiffre correspond à quel pion : un pion rouge par chiffre juste mais mal placé, et un pion blanc par chiffre bien placé.</p>
            <p>Lorsque le code est composé de 4 pions blancs, le joueur a gagné et peut relancer une partie.</p>
            <p>Si vous n'arrivez pas à finir la partie avant le nombre limite d'essais ou moins, vous avez perdu.</p>

        <form method="POST">
            <div class="mb-3">
                <label  class="form-label">Sélectionnez la difficulté :</label>
                <select name="difficulte" class="form-select">
                    <option value="Facile">Facile</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Difficile">Difficile</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Commencer le jeu</button>
        </form>
    </main>
</body>
</html>
