<<<<<<< HEAD
<?php
$host = 'localhost';
$user = 'root';
$pass = '';

$dbname = 'gestion_liens'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : La base de données '$dbname' n'existe pas ou les identifiants sont incorrects.");
}
=======
<?php
$host = 'localhost';
$user = 'root';
$pass = '';

$dbname = 'gestion_liens'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : La base de données '$dbname' n'existe pas ou les identifiants sont incorrects.");
}
>>>>>>> d896d1d1d23b6c7584381f5a6f942cdd47bd767b
?>