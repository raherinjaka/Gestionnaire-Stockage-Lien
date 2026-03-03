<?php
session_start(); 
session_unset(); 
session_destroy(); 

header('Location: login.php'); 
exit();
<?php
session_start(); // Accéder à la session actuelle
session_unset(); // Vider toutes les variables de session
session_destroy(); // Détruire la session sur le serveur

header('Location: login.php'); 
exit();
?>