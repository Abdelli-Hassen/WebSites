<?php
$conn = new mysqli("localhost", "root", "", "parc_auto");
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
$delete_id = $_GET['delete_id'];
$conn->query("DELETE FROM missions WHERE id_vehicule = $delete_id");
$conn->query("DELETE FROM carburant WHERE id_vehicule = $delete_id");
if ($conn->query("DELETE FROM vehicules WHERE id = $delete_id")) {
        echo "<script>alert('Véhicule supprimé avec succès !');</script>";
        echo "<script>window.location.href='../navigation/Gestion du Parc.php';</script>";
} else {
    echo "Erreur lors de la suppression du véhicule : " . $conn->error;
}
$conn->close();
?>