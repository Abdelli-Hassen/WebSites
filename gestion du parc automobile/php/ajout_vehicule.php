<?php
  $conn = new mysqli("localhost", "root", "", "parc_auto");

  if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
  }

  $immatriculation = $_POST['immatriculation'];
  $marque = $_POST['marque'];
  $modele = $_POST['modele'];
  $kilometrage = $_POST['kilometrage'];
  $date_derniere_revision = $_POST['date_derniere_revision'];
  $type = $_POST['type'];

  $sql = "INSERT INTO vehicules (immatriculation, marque, modele, kilometrage, date_derniere_revision, type) 
          VALUES ('$immatriculation', '$marque', '$modele', $kilometrage, '$date_derniere_revision', '$type')";

  if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Véhicule ajouté avec succès!');</script>";
      echo "<script>window.location.href='../navigation/Gestion du Parc.php';</script>";
  } else {
      echo "Erreur : " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>
