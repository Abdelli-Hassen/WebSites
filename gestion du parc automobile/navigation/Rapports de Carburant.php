<?php
$conn = new mysqli('localhost', 'root', '', 'parc_auto');

$rapports = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicule = $_POST['vehicule'];
    $date_debut = $_POST['date-debut'];
    $date_fin = $_POST['date-fin'];

    if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql = "SELECT c.date_remplissage AS date, v.immatriculation AS vehicule, c.litres, c.prix_par_litre, c.kilometrage 
                    FROM carburant c
                    JOIN vehicules v ON c.id_vehicule = v.id
                    WHERE c.id_vehicule = '$vehicule' AND c.date_remplissage BETWEEN '$date_debut' AND '$date_fin'";
    
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
            $rapports[] = $row;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports de Carburant</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/rdc.css">
</head>

<body>
    <div class="container my-5">
        <div class="form-section">
            <h1>Rapports de Carburant</h1>

            <form method="POST" action="Rapports de Carburant.php" >
                <div class="form-group">
                    <label for="vehicule">Véhicule</label>
                    <select class="form-control" id="vehicule" name="vehicule" required>
                        <option value="">Sélectionnez un véhicule</option>
                        <?php
                                            $conn = new mysqli('localhost', 'root', '', 'parc_auto');
                                            $result = $conn->query("SELECT id, immatriculation FROM vehicules");

                                            while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['immatriculation'] . "</option>";
                                                }

                                            $conn->close();
                                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date-debut">Date de début</label>
                    <input type="date" class="form-control" id="date-debut" name="date-debut" required>
                </div>
                <div class="form-group">
                    <label for="date-fin">Date de fin</label>
                    <input type="date" class="form-control" id="date-fin" name="date-fin" required>
                </div>
                <button type="submit" class="btn btn-primary">Générer le rapport</button>
            </form>
        </div>

        <div class="results-section">
            <div id="resultats-rapport">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <?php if (count($rapports) === 0): ?>
                <p class="no-report">Aucun rapport trouvé pour cette période.</p>
                <?php else: ?>
                <div class="table-container">
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Véhicule</th>
                                <th>Litres</th>
                                <th>Prix par litre</th>
                                <th>Kilométrage</th>
                            </tr>
                        </thead>
                        <tbody class="table-responsive">
                            <?php foreach ($rapports as $rapport): ?>
                            <tr>
                                <td><?php echo $rapport['date']; ?></td>
                                <td><?php echo $rapport['vehicule']; ?></td>
                                <td><?php echo $rapport['litres']; ?></td>
                                <td><?php echo $rapport['prix_par_litre']; ?> €</td>
                                <td><?php echo $rapport['kilometrage']; ?> km</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>