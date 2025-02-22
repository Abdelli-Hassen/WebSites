<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>Connexion</title>
</head>
<body>
    <div class="container my-5">
            <h1>Connexion</h1>
            <form method="POST">
                    <input type="text" class="form-control mb-3" name="nom_utilisateur" placeholder="Nom d'utilisateur ou Email" required>
                    <input type="password" class="form-control mb-3" name="mot_de_passe" placeholder="Mot de passe" required>
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nom_utilisateur = $_POST['nom_utilisateur'];
                    $mot_de_passe = $_POST['mot_de_passe'];

                    $conn = new mysqli("localhost", "root", "", "parc_auto");

                    if ($conn->connect_error) {
                            die("Échec de la connexion: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM utilisateurs WHERE (nom_utilisateur='$nom_utilisateur' OR email='$nom_utilisateur') AND mot_de_passe='$mot_de_passe'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                            echo '<div class="alert alert-success">Connexion réussie!</div>';
                    } else {
                            echo '<div class="alert alert-danger">Identifiant ou mot de passe incorrect!</div>';
                    }

                    $conn->close();
            }
            ?>
    </div>
</body>
</html>
