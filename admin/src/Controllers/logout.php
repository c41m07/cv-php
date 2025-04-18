<?php

require_once __DIR__ . '/../../../config/config.php';

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil
header('Location:' . BASE_URL . '/index.php');
exit();
