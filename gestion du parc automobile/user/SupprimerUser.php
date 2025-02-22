<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/suppUser.css">
    <title>Supprimer Utilisateur</title>
</head>
<body>
    <div class="container my-5">
            <h1>Supprimer un Utilisateur</h1>
            <form method="post" action="">
                    <input type="text" class="form-control mb-3" name="identifiant" placeholder="Nom d'utilisateur ou Email" required>
                    <button type="submit" class="btn btn-danger btn-block">Supprimer Utilisateur</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $identifiant = $_POST['identifiant'];
                    $conn = new mysqli("localhost", "root", "", "parc_auto");

                    if ($conn->connect_error) {
                            die("Échec de la connexion: " . $conn->connect_error);
                    }

                    $sql = "SELECT id FROM utilisateurs WHERE nom_utilisateur='$identifiant' OR email='$identifiant'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $id_utilisateur = $row['id'];

                            $sql = "DELETE FROM utilisateurs WHERE id='$id_utilisateur'";
                            if ($conn->query($sql) === TRUE) {
                                    echo '<div class="alert alert-success">Utilisateur supprimé avec succès!</div>';
                            } else {
                                    echo '<div class="alert alert-danger">Erreur: ' . $conn->error . '</div>';
                            }
                    } else {
                            echo '<div class="alert alert-danger">Utilisateur non trouvé!</div>';
                    }

                    $conn->close();
            }
            ?>
    </div>
</body>
</html>
