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
?>