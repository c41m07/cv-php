<?php

require_once __DIR__ . '/../config/config.php';

// Vérification de la connexion
if (!($_SESSION['connecte'] ?? false)) {
    header('Location: ' . BASE_URL . '/admin/src/Views/login.php');
    exit();
}

// Récupération des données des différentes sections du CV
$experiences = $pdo->query('SELECT * FROM experiences ORDER BY debut DESC')->fetchAll();
$diplomes = $pdo->query('SELECT * FROM diplomes ORDER BY annee DESC')->fetchAll();
$langues = $pdo->query('SELECT * FROM langues ORDER BY niveau DESC')->fetchAll();
$permis = $pdo->query('SELECT * FROM permis')->fetchAll();
$interets = $pdo->query('SELECT * FROM interets')->fetchAll();
$languages = $pdo->query('SELECT * FROM languages')->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="<?= BASE_URL ?>/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - CV de Kévin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <!-- Titre de la page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 text-primary"><i class="fas fa-cogs me-2"></i>Administration du CV</h1>
        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-outline-secondary transition-hover">
                <i class="fas fa-home me-2"></i>Voir le CV
            </a>
            <a href="admin/src/Controllers/logout.php" class="btn btn-outline-danger transition-hover">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
            </a>
        </div>
    </div>

    <!-- Navigation entre les sections -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body nav-section-container">
            <ul class="nav nav-pills justify-content-center flex-wrap gap-2">
                <li class="nav-item">
                    <a class="nav-link nav-pill-custom active" href="#experiences" data-bs-toggle="tab">
                        <i class="fas fa-briefcase me-1"></i> Expériences
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill-custom" href="#diplomes" data-bs-toggle="tab">
                        <i class="fas fa-graduation-cap me-1"></i> Diplômes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill-custom" href="#langues" data-bs-toggle="tab">
                        <i class="fas fa-language me-1"></i> Langues
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill-custom" href="#permis" data-bs-toggle="tab">
                        <i class="fas fa-id-card me-1"></i> Permis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill-custom" href="#interets" data-bs-toggle="tab">
                        <i class="fas fa-heart me-1"></i> Intérêts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill-custom" href="#languages" data-bs-toggle="tab">
                        <i class="fas fa-code me-1"></i> Langages
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <!--sections de base-->
    <div class="tab-content ">
        <!-- Section Expériences -->
        <div class="tab-pane fade show active" id="experiences">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Gestion des expériences professionnelles</h2>
                    <a href="admin/src/Views/ajouter.php?section=experiences" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Entreprise</th>
                                <th>Période</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($experiences)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">Aucune expérience disponible</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($experiences as $experience) : ?>
                                    <tr class="transition-hover">
                                        <td><?= $experience['id'] ?></td>
                                        <td><?= htmlspecialchars($experience['poste']) ?></td>
                                        <td><?= htmlspecialchars($experience['entreprise']) ?></td>
                                        <td>
                                            <?php
                                            $debut = new DateTime($experience['debut']);
                                            $fin = $experience['fin'] ? new DateTime($experience['fin']) : null;
                                            echo $debut->format('M Y') . ' - ' . ($fin ? $fin->format('M Y') : 'Présent');
                                            ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="admin/src/Views/modifier.php?section=experiences&id=<?= $experience['id'] ?>"
                                                   class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="admin/src/Controllers/suprimer.php?section=experiences&id=<?= $experience['id'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience ?');">Supprimer
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- section Diplome -->
        <div class="tab-pane fade" id="diplomes">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Gestion des diplômes</h2>
                    <a href="admin/src/Views/ajouter.php?section=diplomes" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Intitulé</th>
                                <th>Etablissement</th>
                                <th>Année</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($diplomes)) : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">Aucune expérience disponible</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($diplomes as $diplome) : ?>
                                    <tr class="transition-hover">
                                        <td><?= $diplome['id'] ?></td>
                                        <td><?= htmlspecialchars($diplome['intitule']) ?></td>
                                        <td><?= htmlspecialchars($diplome['etablissement']) ?></td>
                                        <td>

                                            <?= htmlspecialchars($diplome['annee']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($diplome['description']) ?></td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="admin/src/Views/modifier.php?section=diplomes&id=<?= $diplome['id'] ?>"
                                                   class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="admin/src/Controllers/suprimer.php?section=diplomes&id=<?= $diplome['id'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience ?');">Supprimer</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- section Langue -->
        <div class="tab-pane fade" id="langues">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Gestion des Langues</h2>
                    <a href="admin/src/Views/ajouter.php?section=langues" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Langue</th>
                                <th>Niveau</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($langues)) : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">Aucune expérience disponible</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($langues as $langue) : ?>
                                    <tr class="transition-hover">
                                        <td><?= $langue['id'] ?></td>
                                        <td><?= htmlspecialchars($langue['langue']) ?></td>
                                        <td><?= htmlspecialchars($langue['niveau']) ?></td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="admin/src/Views/modifier.php?section=langues&id=<?= $langue['id'] ?>"
                                                   class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="admin/src/Controllers/suprimer.php?section=langues&id=<?= $langue['id'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience ?');">Supprimer</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- section permis -->
        <div class="tab-pane fade" id="permis">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Gestion des Permis</h2>
                    <a href="admin/src/Views/ajouter.php?section=permis" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($permis)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">Aucune expérience disponible</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($permis as $permi) : ?>
                                    <tr class="transition-hover">
                                        <td><?= $permi['id'] ?></td>
                                        <td><?= htmlspecialchars($permi['type']) ?></td>
                                        <td><?= htmlspecialchars($permi['description']) ?></td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="admin/src/Views/modifier.php?section=permis&id=<?= $permi['id'] ?>"
                                                   class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="admin/src/Controllers/suprimer.php?section=permis&id=<?= $permi['id'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience ?');">Supprimer</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- section interets -->
        <div class="tab-pane fade" id="interets">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Gestion des interêts</h2>
                    <a href="admin/src/Views/ajouter.php?section=interets" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Icone</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($interets)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">Aucune expérience disponible</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($interets as $interet) : ?>
                                    <tr class="transition-hover">
                                        <td><?= $interet['id'] ?></td>
                                        <td><?= htmlspecialchars($interet['icone']) ?></td>
                                        <td><?= htmlspecialchars($interet['nom']) ?></td>
                                        <td><?= htmlspecialchars($interet['description']) ?></td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="admin/src/Views/modifier.php?section=interets&id=<?= $interet['id'] ?>"
                                                   class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="admin/src/Controllers/suprimer.php?section=interets&id=<?= $interet['id'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience ?');">Supprimer</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- section language -->
        <div class="tab-pane fade" id="languages">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Gestion des Languages</h2>
                    <a href="admin/src/Views/ajouter.php?section=languages" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Icone</th>
                                <th>Nom</th>
                                <th>Niveau</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($languages)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">Aucune expérience disponible</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($languages as $language) : ?>
                                    <tr class="transition-hover">
                                        <td><?= $language['id'] ?></td>
                                        <td><?= htmlspecialchars($language['icone']) ?></td>
                                        <td><?= htmlspecialchars($language['nom']) ?></td>
                                        <td><?= htmlspecialchars($language['niveau']) ?></td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="admin/src/Views/modifier.php?section=languages&id=<?= $language['id'] ?>"
                                                   class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="admin/src/Controllers/suprimer.php?section=languages&id=<?= $language['id'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience ?');">Supprimer</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
