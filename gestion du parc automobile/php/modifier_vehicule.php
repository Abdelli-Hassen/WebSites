<?php
$conn = new mysqli("localhost", "root", "", "parc_auto");

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM vehicules WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $vehicule = $result->fetch_assoc();
    } else {
        echo "Véhicule non trouvé.";
        exit;
    }
} else {
    echo "ID de véhicule manquant.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $immatriculation = $_POST['immatriculation'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $kilometrage = $_POST['kilometrage'];
    $date_derniere_revision = $_POST['date_derniere_revision'];
    $type = $_POST['type'];

    $update_sql = "UPDATE vehicules SET immatriculation = '$immatriculation', marque = '$marque', modele = '$modele',
     kilometrage = '$kilometrage', date_derniere_revision = '$date_derniere_revision', type = '$type' WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Véhicule mis à jour avec succès !');</script>";
        echo "<script>window.location.href='../navigation/Gestion du Parc.php';</script>";
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Véhicule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/modif_vehicule.css">
</head>
<body>
<div class="container">
    <h2>Modifier Véhicule</h2>
    <form action="modifier_vehicule.php?id=<?php echo $vehicule['id']; ?>" method="POST">
        <label for="immatriculation">Immatriculation :</label>
        <input type="text" name="immatriculation" value="<?php echo htmlspecialchars($vehicule['immatriculation']); ?>" required>

        <label for="marque">Marque :</label>
        <input type="text" name="marque" value="<?php echo htmlspecialchars($vehicule['marque']); ?>" required>

        <label for="modele">Modèle :</label>
        <input type="text" name="modele" value="<?php echo htmlspecialchars($vehicule['modele']); ?>" required>

        <label for="kilometrage">Kilométrage :</label>
        <input type="number" name="kilometrage" value="<?php echo htmlspecialchars($vehicule['kilometrage']); ?>" required>

        <label for="date_derniere_revision">Date Dernière Révision :</label>
        <input type="date" name="date_derniere_revision" value="<?php echo htmlspecialchars($vehicule['date_derniere_revision']); ?>" required>

        <label for="type">Type :</label>
        <select name="type">
            <option value="mission" <?php echo ($vehicule['type'] == 'mission') ? 'selected' : ''; ?>>Mission</option>
            <option value="responsable" <?php echo ($vehicule['type'] == 'responsable') ? 'selected' : ''; ?>>Responsable</option>
        </select>

        <input type="submit" value="Mettre à jour">
    </form>
</div>
</body>
</html>
