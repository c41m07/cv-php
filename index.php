<?php require_once __DIR__ . '/config/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="<?= BASE_URL ?>/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV de Kévin</title>
    <meta name="description" content="CV de Kévin - développeur et technicien">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="bg-light text-light">
<nav class="navbar navbar-expand-lg bg-dark border-bottom fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary transition-hover" href="#">CV de Kévin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-light transition-hover" href="#Diplome">Diplômes</a></li>
                <li class="nav-item"><a class="nav-link text-light transition-hover" href="#Xp">Expérience</a></li>
                <li class="nav-item"><a class="nav-link text-light transition-hover" href="#Langues">Langues</a></li>
                <li class="nav-item"><a class="nav-link text-light transition-hover" href="#Permis">Permis</a></li>
                <li class="nav-item"><a class="nav-link text-light transition-hover" href="#Interets">Intérêts</a></li>
                <li class="nav-item"><a class="nav-link text-light transition-hover btn btn-outline-primary ms-2" href="admin/dashboard.php">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-5 pt-5">
    <!-- Section de présentation -->
    <section id="Presentation" class="mb-5 card shadow-sm p-4 bg-dark border col-12">
        <div class="row">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <div class="photo-container rounded-circle overflow-hidden mx-auto mb-3"
                     style="width: 200px; height: 200px; border: 3px solid var(--primary-color);">
                    <img src="public/img/profile.jpg" alt="Photo de profil" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-8">
                <h1 class="text-primary">Présentation</h1>
                <p class="text-light">
                    Titulaire d'un BAC PRO en maintenance avec plus de 8 ans d'expérience en construction et production,
                    je suis prêt à apporter mon savoir-faire à de nouveaux projets ambitieux.
                </p>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-6">
            <!-- Section Expérience professionnelle -->
            <section id="Xp" class="mb-5 card shadow-sm p-4 bg-dark border h-100">
                <h2 class="text-primary">Expérience professionnelle</h2>
                <?php
                $stmt = $pdo->query("SELECT * FROM experiences ORDER BY debut DESC");
                while ($row = $stmt->fetch()) {
                    echo "<div class='mb-4 border-bottom pb-3'>";
                    echo "<h3>" . htmlspecialchars($row['poste']) . "</h3>";
                    echo "<h4>" . htmlspecialchars($row['entreprise']) . "</h4>";

                    // Formatage des dates
                    $debut = new DateTime($row['debut']);
                    $fin = $row['fin'] ? new DateTime($row['fin']) : null;
                    $periode = $debut->format('M Y') . ' - ';
                    $periode .= $fin ? $fin->format('M Y') : 'Présent';

                    echo "<p class='text-muted'>" . $periode . "</p>";
                    echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
                    echo "</div>";
                }
                ?>
            </section>
        </div>

        <div class="col-md-6">
            <!-- Section Diplômes et formations -->
            <section id="Diplome" class="mb-5 card shadow-sm p-4 bg-dark border h-100">
                <h2 class="text-primary">Diplômes et formations</h2>
                <?php
                $stmt = $pdo->query("SELECT * FROM diplomes ORDER BY annee DESC");
                while ($row = $stmt->fetch()) {
                    echo "<div class='mb-4'>";
                    echo "<h3>" . htmlspecialchars($row['intitule']) . "</h3>";
                    echo "<h4>" . htmlspecialchars($row['etablissement']) . "</h4>";
                    echo "<p class='text-muted'>" . htmlspecialchars($row['annee']) . "</p>";
                    echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
                    echo "</div>";
                }
                ?>
            </section>
        </div>

        <div class="col-md-6">
            <!-- Section Langues -->
            <section id="Langues" class="mb-5 card shadow-sm p-4 bg-dark border h-100">
                <h2 class="text-primary">Langues</h2>
                <?php
                $stmt = $pdo->query("SELECT * FROM langues ORDER BY niveau DESC");
                while ($row = $stmt->fetch()) {
                    echo "<div class='mb-3'>";
                    echo "<h4>" . htmlspecialchars($row['langue']) . "</h4>";

                    echo "<p>" . nl2br(htmlspecialchars($row['niveau'])) . "</p>";
                    echo "</div>";

                }
                ?>
            </section>
        </div>

        <div class="col-md-6">
            <!-- Section Permis -->
            <section id="Permis" class="mb-5 card shadow-sm p-4 bg-dark border h-100">
                <h2 class="text-primary">Permis</h2>
                <?php
                $stmt = $pdo->query("SELECT * FROM permis");
                while ($row = $stmt->fetch()) {
                    echo "<div class='mb-3'>";
                    echo "<h4>" . htmlspecialchars($row['type']) . "</h4>";
                    echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
                    echo "</div>";
                }
                ?>
            </section>
        </div>

        <div class="col-md-6">
            <!-- Section Compétences -->
            <section id="Interets" class="mb-5 card shadow-sm p-4 bg-dark border h-100 text-center">
                <h2 class="text-primary">Centres d'intérêt</h2>
                <?php
                $stmt = $pdo->query("SELECT * FROM interets");
                echo "<div class='row justify-content-center'>";
                while ($row = $stmt->fetch()) {
                    echo "<div class='col-md-4 mb-3'>";
                    echo "<div class='card h-100 bg-dark transition-hover text-center'>";
                    echo "<div class='card-body d-flex flex-column align-items-center justify-content-center'>";
                    echo "<h4 class='text-center'><i class='" . htmlspecialchars($row['icone']) . " me-2'></i>" . htmlspecialchars($row['nom']) . "</h4>";
                    echo "<p class='text-center'>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
                    echo "</div></div></div>";
                }
                echo "</div>";
                ?>
            </section>
        </div>
        <div class="col-md-6">
            <!-- Section Loisirs -->
            <section id="language" class="mb-5 card shadow-sm p-4 bg-dark border h-100 text-center">
                <h2 class="text-primary">language</h2>
                <?php
                $stmt = $pdo->query("SELECT * FROM languages");
                echo "<div class='row justify-content-center'>";
                while ($row = $stmt->fetch()) {
                    echo "<div class='col-md-4 mb-3'>";
                    echo "<div class='card h-100 bg-dark transition-hover text-center'>";
                    echo "<div class='card-body d-flex flex-column align-items-center justify-content-center'>";
                    echo "<h4 class='text-center'><i class='" . htmlspecialchars($row['icone']) . " me-2'></i>" . htmlspecialchars($row['nom']) . "</h4>";
                    echo "<p class='text-center'>" . nl2br(htmlspecialchars($row['niveau'])) . "</p>";
                    echo "</div></div></div>";
                }
                echo "</div>";
                ?>
            </section>
        </div>
    </div>
</main>

<footer id="footer" class="py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="text-primary">Contact</h5>
                <p><i class="fas fa-envelope me-2"></i> test@exemple.com</p>
                <p><i class="fas fa-phone me-2"></i> +33 X XX XX XX XX</p>
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
        <p class="small text-muted mt-2">© <?= date('Y') ?> Kévin - Tous droits réservés</p>
    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
