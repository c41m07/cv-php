<?php
session_start();
// Inclusion de l'autoloader Composer
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Définition des constantes
define('ROOT_PATH', dirname(__DIR__));
define('BASE_URL', 'http://localhost/CV-php');

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost:3307;dbname=portefolio', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo 'Connexion réussie à la base de données !';
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit();
}
?>
