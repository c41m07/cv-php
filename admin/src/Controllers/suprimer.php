<?php
require_once __DIR__ . '/../../../config/config.php';
//tableau associatif pour les sections
require_once __DIR__ . '/../../../config/sections.php';

//récupération paramètres section
$section = $_GET['section'] ?? null;

//récupération de l'id de l'objet à modifier
$id = $_GET['id'] ?? null;

//configuration de la section et des erreur
$config = $sections[$section];
$error = [];
//suprimer l'objet avec l'id
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM {$config['table']} WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    //redirection vers le tableau de bord a la section ou on était
    header('Location: ' . BASE_URL . '/admin/dashboard.php?section=' . htmlspecialchars($section));
    exit();
} else {
    echo "Erreur : ID non spécifié.";
    exit();
}
?>