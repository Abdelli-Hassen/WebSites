<?php
$conn = new mysqli("localhost", "root", "", "parc_auto");

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vehicule = $_POST['vehicule'];
  $date = $_POST['date'];
  $litres = $_POST['litres'];
  $prix_par_litre = $_POST['prix-par-litre'];
  $kilometrage = $_POST['kilometrage'];

  $sql = "INSERT INTO carburant (id_vehicule, date_remplissage, litres, prix_par_litre, kilometrage) 
      VALUES ('$vehicule', '$date', '$litres', '$prix_par_litre', '$kilometrage')";
  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Remplissage ajouté avec succès.');</script>";
  } else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
  }
}

$sql_vehicules = "SELECT * FROM vehicules";
$result_vehicules = $conn->query($sql_vehicules);

$sql_history = "SELECT * FROM carburant";
$result_history = $conn->query($sql_history);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Carburant</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/gdc.css">
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4 text-center">Gestion du Carburant</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="fuel-card">
                    <h2 class="mb-4">Ajouter un remplissage</h2>
                    <form method="POST">
                        <div class="form-group">
                            <select class="form-control" name="vehicule" required>
                                <option value="">Sélectionnez un véhicule</option>
                                <?php while ($vehicule = $result_vehicules->fetch_assoc()) { ?>
                                <option value="<?php echo $vehicule['id']; ?>">
                                    <?php echo $vehicule['marque'] . ' ' . $vehicule['modele']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="litres"
                                placeholder="Entrez le nombre de litres" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="prix-par-litre"
                                placeholder="Entrez le prix par litre" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="kilometrage"
                                placeholder="Entrez le kilométrage" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter le remplissage</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="fuel-card">
                    <h2 class="mb-4">Historique des remplissages</h2>
                    <a  href="carb_hist.php"><button class="btn-details">Rapport détaillée</button></a>
                    <?php if ($result_history->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Véhicule</th>
                                <th>Date</th>
                                <th>Litres</th>
                                <th>Prix par litre</th>
                                <th>Kilométrage</th>
                            </tr>
                        </thead>
                        <tbody class="table-responsive">
                            <?php while ($row = $result_history->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id_vehicule']; ?></td>
                                <td><?php echo $row['date_remplissage']; ?></td>
                                <td><?php echo $row['litres']; ?></td>
                                <td><?php echo $row['prix_par_litre']; ?> TND</td>
                                <td><?php echo $row['kilometrage']; ?> km</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p>Aucun remplissage trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>