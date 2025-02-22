<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports de Consommation de Carburant</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .report-table {
        margin-top: 20px;
    }

    .report-table th,
    .report-table td {
        text-align: center;
    }

    .btn-primary {
      display: block;
      transition: background-color 0.3s ease;
    }
    h1,
    h2 {
        color: #007bff;
        font-weight: bold;
        text-align: center;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: center;
    }

    .form-control,
    .btn-primary {
        text-align: center;
        margin-top: 20px;
        width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

    .table-responsive {
        max-height: 280px;
        overflow-y: auto;
    }

    tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Rapports de Consommation de Carburant</h1>
        <form id="report-form" method="post" action="carb_hist.php">
            <div class="form-group">
                <select class="form-control" id="vehicle" name="vehicle" required>
                    <option value="">Sélectionnez un véhicule</option>
                    <?php
        $conn = new mysqli("localhost", "root", "", "parc_auto");
          if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
          }

          $sql = "SELECT id, immatriculation, marque, modele FROM vehicules";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['immatriculation']} - {$row['marque']} {$row['modele']}</option>";
            }
          }
          $conn->close();
        ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" id="driver" name="driver" required>
                    <option value="">Sélectionnez un conducteur</option>
                    <?php
          $conn = new mysqli("localhost", "root", "", "parc_auto");
          if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
          }

          $sql = "SELECT id, nom, numero_licence, telephone FROM conducteurs";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['nom']} - {$row['numero_licence']}</option>";
            }
          }
          $conn->close();
        ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" id="mission" name="mission" required>
                    <option value="">Sélectionnez une mission</option>
                    <?php
$conn = new mysqli("localhost", "root", "", "parc_auto");
          if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
          }

          $sql = "SELECT m.id, v.immatriculation, c.nom, m.destination, m.date_debut, m.date_fin, m.km_estimes
                  FROM missions m
                  JOIN vehicules v ON m.id_vehicule = v.id
                  JOIN conducteurs c ON m.id_conducteur = c.id";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['immatriculation']} - {$row['nom']} - {$row['destination']}</option>";
            }
          }
          $conn->close();
        ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Générer le Rapport</button>
        </form>

        <div class="report-table">
            <h2>Rapport de Consommation de Carburant</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Litres</th>
                        <th>Prix par Litre</th>
                        <th>Kilométrage</th>
                    </tr>
                </thead>
                <tbody class="table-responsive">
                    <?php
          if (isset($_POST['vehicle'])) {
            $vehicleId = $_POST['vehicle'];
            $conn = new mysqli("localhost", "root", "", "parc_auto");  
            if ($conn->connect_error) {
              die("La connexion a échoué : " . $conn->connect_error);
            }

            $sql = "SELECT * FROM carburant WHERE id_vehicule = ? ORDER BY date_remplissage DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $vehicleId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['date_remplissage'] . "</td>";
                echo "<td>" . $row['litres'] . "</td>";
                echo "<td>" . $row['prix_par_litre'] . "</td>";
                echo "<td>" . $row['kilometrage'] . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='4'>Aucune donnée de consommation de carburant disponible.</td></tr>";
            }
            $conn->close();
          } else {
            echo "<tr><td colspan='4'>Veuillez sélectionner un véhicule pour voir le rapport de consommation de carburant.</td></tr>";
          }
        ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>