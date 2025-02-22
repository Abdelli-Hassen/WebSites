<?php
$conn = new mysqli("localhost", "root", "", "parc_auto");
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

$sql = "SELECT * FROM entretiens";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générer un Rapport</title>
    <link rel="stylesheet" href="../css/gen_rapport.css">
</head>

<body>
    <div class="container">
        <h2>Rapport d'Entretien des Véhicules</h2>

        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Immatriculation</th>
                    <th>Date de l'entretien</th>
                    <th>Kilométrage</th>
                    <th>Type d'entretien</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['immatriculation']; ?></td>
                    <td><?php echo $row['date_entretien']; ?></td>
                    <td><?php echo $row['kilometrage']; ?></td>
                    <td><?php echo $row['type_entretien']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Aucun entretien planifié.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>

</html>