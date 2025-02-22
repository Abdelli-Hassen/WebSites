<?php
$conn = new mysqli("localhost", "root", "", "parc_auto");

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $immatriculation = $_POST['immatriculation'];
    $date_entretien = $_POST['date_entretien'];
    $kilometrage = $_POST['kilometrage'];
    $type_entretien = $_POST['type_entretien'];

    $sql = "INSERT INTO entretiens (immatriculation, date_entretien, kilometrage, type_entretien)
            VALUES ('$immatriculation', '$date_entretien', '$kilometrage', '$type_entretien')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Entretien planifié avec succès');</script>";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planifier un Entretien</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/plan_entretien.css">
</head>
<body>
    <div class="container">
        <h2>Planifier un Entretien</h2>
        <form method="POST" action="plan_entretien.php">
            <div class="form-group">
                <label>Immatriculation</label>
                <input type="text" name="immatriculation" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Date de l'entretien</label>
                <input type="date" name="date_entretien" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kilométrage</label>
                <input type="number" name="kilometrage" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Type d'entretien</label>
                <select name="type_entretien" class="form-control" required>
                    <option value="vidange">Vidange</option>
                    <option value="pneus">Pneus</option>
                    <option value="révision">Révision</option>
                </select>
            </div>

            <button type="submit" class="btn">Planifier l'entretien</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
