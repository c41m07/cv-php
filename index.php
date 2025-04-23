<?php
global $pdo;
require_once __DIR__ . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="<?= BASE_URL ?>/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV de Kévin</title>
    <meta name="description" content="CV de Kévin - développeur et technicien">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Votre feuille de styles -->
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="bg-light text-light">

<nav class="navbar navbar-expand-lg bg-dark border-bottom fixed-top shadow-sm no-print">
    <div class="container">
        <a class="navbar-brand text-primary transition-hover" href="#">
            <i class="fa-solid fa-book"></i> CV de Kévin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-light" href="#Diplome">Diplômes</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#Xp">Expérience</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#Langues">Langues</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#Permis">Permis</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#Interets">Intérêts</a></li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary ms-2" href="admin/dashboard.php">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <div class="row">
        <!-- COLONNE GAUCHE -->
        <div class="col-md-4">
            <!-- Présentation -->
            <section id="Presentation" class="mb-4">
                <div class="card shadow-sm p-4 bg-dark border">
                    <div class="text-center mb-3">
                        <img src="public/images/profil.jpg" alt="Photo de profil"
                             class="rounded-circle img-fluid profile-img">
                    </div>
                    <h2 class="text-primary">Présentation</h2>
                    <p class="text-light">Titulaire d'un BAC PRO en maintenance avec plus de 8 ans d'expérience en
                        construction et production, je suis prêt à apporter mon savoir-faire à de nouveaux projets
                        ambitieux.</p>
                </div>
            </section>

            <!-- Intérêts avec icônes -->
            <section id="Interets" class="mb-4">
                <div class="card shadow-sm p-4 bg-dark border">
                    <h2 class="text-primary">Centres d'intérêt</h2>
                    <ul class="list-unstyled text-light">
                        <?php
                        $stmt = $pdo->query("SELECT * FROM interets");
                        while ($row = $stmt->fetch()) {
                            echo sprintf(
                                '<li class="mb-2"><i class="%s me-2"></i> %s',
                                htmlspecialchars($row['icone']),
                                htmlspecialchars($row['nom']),
                            );
                            if (!empty($row['description'])) {
                                echo ' <br> – <br>' . htmlspecialchars($row['description']);
                            }
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </section>

            <!-- Langues parlées (barre et icônes) -->
            <section id="Langues" class="mb-4">
                <div class="card shadow-sm p-4 bg-dark border">
                    <h2 class="text-primary">Langues</h2>
                    <?php
                    $mapLangues = ['Maternelle' => 100, 'Avancé' => 75, 'Intermédiaire' => 50, 'Débutant' => 25];
                    $stmt = $pdo->query("SELECT * FROM langues ORDER BY FIELD(niveau,'Maternelle','Avancé','Intermédiaire','Débutant')");
                    while ($row = $stmt->fetch()) {
                        $pct = $mapLangues[$row['niveau']] ?? 0;
                        ?>
                        <div class="mb-3 d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="text-light mb-1"><?= htmlspecialchars($row['langue']) ?></h5>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width:<?= $pct ?>%;"
                                         aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"><?= $pct ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>

            <!-- Permis -->
            <section id="Permis" class="mb-4">
                <div class="card shadow-sm p-4 bg-dark border">
                    <h2 class="text-primary">Permis</h2>
                    <ul class="list-unstyled text-light">
                        <?php
                        $stmt = $pdo->query("SELECT * FROM permis");
                        while ($row = $stmt->fetch()) {
                            echo '<li>' . htmlspecialchars($row['type']) . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </section>
        </div>

        <!-- COLONNE DROITE -->
        <div class="col-md-8">
            <!-- Expérience -->
            <section id="Xp" class="mb-4">
                <div class="card shadow-sm p-4 bg-dark border">
                    <h2 class="text-primary">Expérience professionnelle</h2>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM experiences ORDER BY debut DESC");
                    while ($row = $stmt->fetch()) {
                        $d = new DateTime($row['debut']);
                        $f = $row['fin'] ? new DateTime($row['fin']) : null;
                        $periode = $d->format('M Y') . ' – ' . ($f ? $f->format('M Y') : 'Présent');
                        ?>
                        <div class="mb-4 border-bottom pb-3 text-light">
                            <h4><?= htmlspecialchars($row['poste']) ?></h4>
                            <h5 class="text-muted"> <?= htmlspecialchars($row['entreprise']) ?></h5>
                            <small class="text-secondary"><strong><?= $periode ?></strong></small>
                            <p class="mt-2"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                        </div>
                    <?php } ?>
                </div>
            </section>

            <!-- Diplômes -->
            <section id="Diplome" class="mb-4">
                <div class="card shadow-sm p-4 bg-dark border">
                    <h2 class="text-primary">Diplômes & formations</h2>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM diplomes ORDER BY annee DESC");
                    while ($row = $stmt->fetch()) {
                        ?>
                        <div class="mb-4 text-light">
                            <h4><?= htmlspecialchars($row['intitule']) ?></h4>
                            <small class="text-secondary">
                                <strong>
                                    <?= sprintf(
                                        '%s - %d',
                                        htmlspecialchars($row['etablissement']),
                                        htmlspecialchars($row['annee'])
                                    ) ?>
                                </strong>
                            </small>
                            <p class="mt-2"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                        </div>
                    <?php } ?>
                </div>
            </section>

            <!-- Langages -->
            <section id="language" class="mb-4">
                <div class="card shadow-sm p-4 bg-dark border">
                    <h2 class="text-primary">Langages</h2>
                    <?php
                    $mapCode = ['Avancé' => 100, 'Intermédiaire' => 66, 'Débutant' => 33];
                    $stmt = $pdo->query("SELECT * FROM languages ORDER BY FIELD(niveau,'Avancé','Intermédiaire','Débutant')");
                    while ($row = $stmt->fetch()) {
                        $pct = $mapCode[$row['niveau']] ?? 0;
                        ?>
                        <div class="mb-3 d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="text-light mb-1">
                                    <?=
                                    sprintf(
                                        '<i class="%s fa-lg text-light me-2"></i> %s',
                                        htmlspecialchars($row['icone']),
                                        htmlspecialchars($row['nom']),
                                    );
                                    ?>

                                </h5>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width:<?= $pct ?>%;"
                                         aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"><?= $pct ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</div>

<footer id="footer" class="py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="text-primary">Contact</h5>
                <p><i class="fas fa-envelope me-2"></i>test@exemple.com</p>
                <p><i class="fas fa-phone me-2"></i>+33 X XX XX XX XX</p>
            </div>
            <div class="col-md-6">
                <h5 class="text-primary">Suivez-moi</h5>
                <div class="footer-icons">
                    <a href="#" target="_blank"><i class="fab fa-linkedin fa-2x"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-github fa-2x"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 border-secondary">
        <p class="small text-muted mt-2">© <?= date('Y') ?> Kévin – Tous droits réservés</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
