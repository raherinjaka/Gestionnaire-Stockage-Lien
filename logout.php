<?php
session_start(); // Accéder à la session actuelle
session_unset(); // Vider toutes les variables de session
session_destroy(); // Détruire la session sur le serveur

// Rediriger l'utilisateur vers la page de connexion immédiatement
header('Location: login.php'); 
exit();
?>