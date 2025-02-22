<?php
$conn = new mysqli("localhost", "root", "", "parc_auto");

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM vehicules WHERE id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Véhicule supprimé avec succès !');</script>";
        echo "<script>window.location.href='../navigation/Gestion du Parc.php';</script>";
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }
}

$conn->close();
?>
