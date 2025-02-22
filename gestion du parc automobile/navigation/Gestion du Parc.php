<!DOCTYPE html>
<html>
<head>
<title>Parc Auto - Gestion du Parc</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/gdp.css">
</head>
<body>

<main>
  <section class="hero">
    <h2>Gestion du Parc Automobile</h2>
    <p>Suivez et gérez efficacement votre flotte de véhicules.</p>
  </section>

  <section class="vehicle-actions">
    <h2>Actions sur les Véhicules</h2>
    <div class="actions">
      <button class="btn" onclick="showAddVehicleModal()">Ajouter un Véhicule</button>
      <a href="../php/plan_entretien.php" class="btn">Planifier un Entretien</a>
      <a href="../php/gen_rapport.php" class="btn">Générer un Rapport</a>
    </div>
  </section>
  
  <section class="vehicle-list" id="vehicleList">
    <h2>Liste des Véhicules</h2>
    <table>
      <thead>
        <tr>
          <th>Immatriculation</th>
          <th>Marque</th>
          <th>Modèle</th>
          <th>Kilométrage</th>
          <th>Dernière Révision</th>
          <th>Type</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-content">
        <?php
        $conn = new mysqli("localhost", "root", "", "parc_auto");

        if ($conn->connect_error) {
          die("La connexion a échoué : " . $conn->connect_error);
        }

        $sql = "SELECT * FROM vehicules";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>" . htmlspecialchars($row["immatriculation"]) . "</td>
              <td>" . htmlspecialchars($row["marque"]) . "</td>
              <td>" . htmlspecialchars($row["modele"]) . "</td>
              <td>" . htmlspecialchars($row["kilometrage"]) . "</td>
              <td>" . htmlspecialchars($row["date_derniere_revision"]) . "</td>
              <td>" . htmlspecialchars($row["type"]) . "</td>
              <td>
                <a href='../php/modifier_vehicule.php?id=" . $row["id"] . "' id='btn_act' class='btn'>Modifier</a>
                <a href='../php/delete_vehicule.php?delete_id=" . $row["id"] . "' id='btn_act' class='btn' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')\">Supprimer</a>
              </td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='7'>Aucun véhicule trouvé.</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </section>
</main>

<div class="add-vehicle-container" id="addVehicleModal">
  <h2 class="add-vehicle-header">Ajouter un Véhicule</h2>
  <form method="POST" action="../php/ajout_vehicule.php">
    <span class="modal-close" onclick="closeAddVehicleModal()">&times;</span>
    <div>
      <label for="immatriculation" class="add-vehicle-label">Immatriculation</label>
      <input type="text" id="immatriculation" name="immatriculation" class="add-vehicle-input" required>
    </div>
    <div>
      <label for="marque" class="add-vehicle-label">Marque</label>
      <input type="text" id="marque" name="marque" class="add-vehicle-input" required>
    </div>
    <div>
      <label for="modele" class="add-vehicle-label">Modèle</label>
      <input type="text" id="modele" name="modele" class="add-vehicle-input" required>
    </div>
    <div>
      <label for="kilometrage" class="add-vehicle-label">Kilométrage</label>
      <input type="number" id="kilometrage" name="kilometrage" class="add-vehicle-input" required>
    </div>
    <div>
      <label for="date_derniere_revision" class="add-vehicle-label">Date Dernière Révision</label>
      <input type="date" id="date_derniere_revision" name="date_derniere_revision" class="add-vehicle-input" required>
    </div>
    <div>
      <label for="type" class="add-vehicle-label">Type</label>
      <select id="type" name="type" class="add-vehicle-select" required>
        <option value="mission">Mission</option>
        <option value="responsable">Responsable</option>
      </select>
    </div>
    <input type="submit" value="Ajouter" class="add-vehicle-submit">
  </form>
</div>

<div class="modal-overlay" id="modalOverlay" style="display: none;"></div>

<script>
  function showAddVehicleModal() {
    document.getElementById("addVehicleModal").style.display = "block";
    document.getElementById("modalOverlay").style.display = "block";
  }

  function closeAddVehicleModal() {
    document.getElementById("addVehicleModal").style.display = "none";
    document.getElementById("modalOverlay").style.display = "none";
  }
</script>
</body>
</html>
