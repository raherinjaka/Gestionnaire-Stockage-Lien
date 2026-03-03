<<<<<<< HEAD
<?php
session_start(); 
session_unset(); 
session_destroy(); 

header('Location: login.php'); 
exit();
=======
<?php
session_start(); // Accéder à la session actuelle
session_unset(); // Vider toutes les variables de session
session_destroy(); // Détruire la session sur le serveur

// Rediriger l'utilisateur vers la page de connexion immédiatement
header('Location: login.php'); 
exit();
>>>>>>> d896d1d1d23b6c7584381f5a6f942cdd47bd767b
?>