<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/modUser.css">
<title>Modifier Utilisateur</title>
</head>
<body>
<div class="container my-5">
    <h1>Modifier un Utilisateur</h1>
    <form method="post" action="">
        <input type="text" class="form-control mb-3" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
        <input type="email" class="form-control mb-3" name="email" placeholder="Email" required>
        <input type="password" class="form-control mb-3" name="mot_de_passe" placeholder="Nouveau Mot de passe">
        <select class="form-control mb-3" name="role" required>
            <option value="">Sélectionnez un rôle</option>
            <option value="admin">Administrateur</option>
            <option value="user">Utilisateur</option>
        </select>
        <button type="submit" class="btn btn-primary btn-block">Modifier Utilisateur</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom_utilisateur = $_POST['nom_utilisateur'];
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $role = $_POST['role'];

        $conn = new mysqli("localhost", "root", "", "parc_auto");

        if ($conn->connect_error) {
            die("Échec de la connexion: " . $conn->connect_error);
        }

        $sql = "UPDATE utilisateurs SET nom_utilisateur='$nom_utilisateur', email='$email', role='$role' WHERE email='$email'";
        if ($mot_de_passe) {
            $sql = "UPDATE utilisateurs SET nom_utilisateur='$nom_utilisateur', email='$email', mot_de_passe='$mot_de_passe', role='$role' WHERE email='$email'";
        }

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success">Utilisateur modifié avec succès!</div>';
        } else {
            echo '<div class="alert alert-danger">Erreur: ' . $conn->error . '</div>';
        }

        $conn->close();
    }
    ?>
</div>
</body>
</html>
