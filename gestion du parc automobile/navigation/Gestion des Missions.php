<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Missions</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/gdm.css">
</head>

<body>
  <?php
  $conn = new mysqli("localhost", "root", "", "parc_auto");

  if ($conn->connect_error) {
      die("La connexion a échoué : " . $conn->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id_vehicule = $_POST['vehicule'];
      $id_conducteur = $_POST['conducteur'];
      $destination = $_POST['destination'];
      $date_debut = $_POST['date_debut'];
      $date_fin = $_POST['date_fin'];
      $objectif = $_POST['objectif'];
      $km_estimes = $_POST['km_estimes'];

      $sql = "INSERT INTO missions (id_vehicule, id_conducteur, destination, date_debut, date_fin, objectif, km_estimes) 
              VALUES ('$id_vehicule', '$id_conducteur', '$destination', '$date_debut', '$date_fin', '$objectif', '$km_estimes')";

      if ($conn->query($sql) === TRUE) {
          echo "<script>alert('Nouvelle mission créée avec succès.');</script>";
      } else {
          echo "Erreur: " . $sql . "<br>" . $conn->error;
      }
  }

  if (isset($_GET['cancel_id'])) {
      $cancel_id = $_GET['cancel_id'];
      $update_sql = "UPDATE missions SET statut = 'annulé' WHERE id='$cancel_id'";
      $conn->query($update_sql);
      echo "<script>alert('Mission annulée avec succès.');</script>";
  }

  $sqlVehicules = "SELECT * FROM vehicules";
  $resultVehicules = $conn->query($sqlVehicules);

  $sqlConducteurs = "SELECT * FROM conducteurs";
  $resultConducteurs = $conn->query($sqlConducteurs);

  $sqlMissionsEnCours = "SELECT * FROM missions WHERE date_fin >= CURDATE() AND statut != 'annulé'";
  $resultMissionsEnCours = $conn->query($sqlMissionsEnCours);

  $sqlMissionsPassees = "SELECT * FROM missions WHERE date_fin < CURDATE()";
  $resultMissionsPassees = $conn->query($sqlMissionsPassees);

  $sqlMissionsAnnulees = "SELECT * FROM missions WHERE statut = 'annulé'";
  $resultMissionsAnnulees = $conn->query($sqlMissionsAnnulees);
  ?>
  
  <div class="container my-5">
      <h1>Gestion des Missions</h1>
      <div class="row">
          <div class="col-md-4">
              <h2>Créer une nouvelle mission</h2>
              <form method="POST">
                  <select class="form-control mb-3" name="vehicule" required>
                      <option value="">Sélectionnez un véhicule</option>
                      <?php while ($row = $resultVehicules->fetch_assoc()): ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['marque']; ?></option>
                      <?php endwhile; ?>
                  </select>
                  <select class="form-control mb-3" name="conducteur" required>
                      <option value="">Sélectionnez un conducteur</option>
                      <?php while ($row = $resultConducteurs->fetch_assoc()): ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
                      <?php endwhile; ?>
                  </select>
                  <input type="text" class="form-control mb-3" name="destination" placeholder="Entrez la destination" required>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <input type="date" class="form-control mb-3" name="date_debut" required>
                      </div>
                      <div class="form-group col-md-6">
                          <input type="date" class="form-control mb-3" name="date_fin" required>
                      </div>
                  </div>
                  <textarea class="form-control mb-3" name="objectif" rows="3" placeholder="Objectif de la mission" required></textarea>
                  <input type="number" class="form-control mb-3" name="km_estimes" placeholder="Kilométrage prévu" required>
                  <button type="submit" class="btn btn-primary">Créer la mission</button>
              </form>
          </div>

          <div class="col-md-8 mission-container">
              <h2>Missions en cours, passées et annulées</h2>
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>Missions en cours</th>
                          <th>Missions passées</th>
                          <th>Missions annulées</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>
                              <div class="scrollable-table">
                                  <?php if ($resultMissionsEnCours->num_rows > 0): ?>
                                  <?php while ($row = $resultMissionsEnCours->fetch_assoc()): ?>
                                  <div class="mission">
                                      <p><strong>Véhicule:</strong> <?php echo $row['id_vehicule']; ?></p>
                                      <p><strong>Conducteur:</strong> <?php echo $row['id_conducteur']; ?></p>
                                      <p><strong>Destination:</strong> <?php echo $row['destination']; ?></p>
                                      <p><strong>Date:</strong> <?php echo $row['date_debut']; ?> - <?php echo $row['date_fin']; ?></p>
                                      <button class="btn btn-info btn-sm" onclick="toggleDetails(<?php echo $row['id']; ?>)">Voir Détails</button>
                                      <a href="?cancel_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Annuler</a>
                                      <div class="details" id="details-<?php echo $row['id']; ?>" style="display:none;">
                                          <p><strong>Objectif:</strong> <?php echo $row['objectif']; ?></p>
                                          <p><strong>Kilométrage prévu:</strong> <?php echo $row['km_estimes']; ?> km</p>
                                      </div>
                                  </div>
                                  <?php endwhile; ?>
                                  <?php else: ?>
                                  <p>Aucune mission en cours.</p>
                                  <?php endif; ?>
                              </div>
                          </td>
                          <td>
                              <div class="scrollable-table">
                                  <?php if ($resultMissionsPassees->num_rows > 0): ?>
                                  <?php while ($row = $resultMissionsPassees->fetch_assoc()): ?>
                                  <div class="mission">
                                      <p><strong>Véhicule:</strong> <?php echo $row['id_vehicule']; ?></p>
                                      <p><strong>Conducteur:</strong> <?php echo $row['id_conducteur']; ?></p>
                                      <p><strong>Destination:</strong> <?php echo $row['destination']; ?></p>
                                      <p><strong>Date:</strong> <?php echo $row['date_debut']; ?> - <?php echo $row['date_fin']; ?></p>
                                      <button class="btn btn-info btn-sm" onclick="toggleDetails(<?php echo $row['id']; ?>)">Voir Détails</button>
                                      <div class="details" id="details-<?php echo $row['id']; ?>" style="display:none;">
                                          <p><strong>Objectif:</strong> <?php echo $row['objectif']; ?></p>
                                          <p><strong>Kilométrage prévu:</strong> <?php echo $row['km_estimes']; ?> km</p>
                                      </div>
                                  </div>
                                  <?php endwhile; ?>
                                  <?php else: ?>
                                  <p>Aucune mission passée.</p>
                                  <?php endif; ?>
                              </div>
                          </td>
                          <td>
                              <div class="scrollable-table">
                                  <?php if ($resultMissionsAnnulees->num_rows > 0): ?>
                                  <?php while ($row = $resultMissionsAnnulees->fetch_assoc()): ?>
                                  <div class="mission">
                                      <p><strong>Véhicule:</strong> <?php echo $row['id_vehicule']; ?></p>
                                      <p><strong>Conducteur:</strong> <?php echo $row['id_conducteur']; ?></p>
                                      <p><strong>Destination:</strong> <?php echo $row['destination']; ?></p>
                                      <p><strong>Date:</strong> <?php echo $row['date_debut']; ?> - <?php echo $row['date_fin']; ?></p>
                                      <button class="btn btn-info btn-sm" onclick="toggleDetails(<?php echo $row['id']; ?>)">Voir Détails</button>
                                      <div class="details" id="details-<?php echo $row['id']; ?>" style="display:none;">
                                          <p><strong>Objectif:</strong> <?php echo $row['objectif']; ?></p>
                                          <p><strong>Kilométrage prévu:</strong> <?php echo $row['km_estimes']; ?> km</p>
                                      </div>
                                  </div>
                                  <?php endwhile; ?>
                                  <?php else: ?>
                                  <p>Aucune mission annulée.</p>
                                  <?php endif; ?>
                              </div>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>

  <script>
  function toggleDetails(id) {
      const details = document.getElementById('details-' + id);
      details.style.display = details.style.display === 'none' || details.style.display === '' ? 'block' : 'none';
  }
  </script>
</body>
</html>