<?php

require_once __DIR__ . '/../../../config/config.php';
//tableau associatif pour les sections ( nom de ta table sql,label2 de la section, les champs à remplir dans le formulaire)
require_once __DIR__ . '/../../../config/sections.php';

//récupération paramètres section
$section = $_GET['section'] ?? null;

//récupération de l'id de l'objet à modifier
$id = $_GET['id'] ?? null;

//configuration de la section et des erreur
$config = $sections[$section];
$error = [];

//préremplissage du form avec les données de l'objet à modifier
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM {$config['table']} WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
}

//si formulaire soumis en post update des valeur diférente avec celle de la base de données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($config['fields'] as $field => $label2) {
        if (isset($_POST[$field])) {
            $data[$field] = $_POST[$field];
        } else {
            $error[] = "Le champ $label2 est requis.";
        }
    }
    //si pas d'erreur
    if (empty($error)) {
        // Insertion dans la base de données
        try {
            // formatage des donnnée dans un tableau info
            $infos = [];
            foreach ($data as $field => $value) {
                $infos[] = "$field = :$field";
            }
            //on transforme le tableau en une chaîne de caractères
            $update = implode(', ', $infos);


            //prepare la requête d'insertion
            $stmt = $pdo->prepare("UPDATE {$config['table']} SET $update WHERE id = :id");
            
            //pour chaque champ de données, on lie la valeur à la requête préparée
            foreach ($data as $field => $value) {
                $stmt->bindValue(":$field", $value);
            }
            //execute puis redirection vers le tableau de bord a la section ou on était
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            header('Location: ' . BASE_URL . '/admin/dashboard.php?section=' . htmlspecialchars($section));
            exit();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="<?= BASE_URL ?>/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Dynamique</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0"><i class="fas fa-plus-circle me-2"></i><?= htmlspecialchars($config['label2']) ?></h1>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($error)) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($error as $e) : ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <?php foreach ($config['fields'] as $field => $label2) : ?>
                            <?php if ($field === 'debut' || $field === 'fin') : ?>
                                <div class="mb-3">
                                    <label for="<?= $field ?>" class="form-label"><?= $label2 ?></label>
                                    <input type="date" class="form-control" id="<?= $field ?>" name="<?= $field ?>"
                                           value="<?= htmlspecialchars($data[$field] ?? '') ?>" required>
                                </div>
                            <?php elseif ($field === 'annee') : ?>
                                <div class="mb-3">
                                    <label for="<?= $field ?>" class="form-label"><?= $label2 ?></label>
                                    <input type="number" class="form-control" id="<?= $field ?>" name="<?= $field ?>"
                                           value="<?= htmlspecialchars($data[$field] ?? '') ?>" required>
                                </div>
                            <?php elseif ($field === 'niveau') : ?>
                                <div class="mb-3">
                                    <label for="<?= $field ?>" class="form-label"><?= $label2 ?></label>
                                    <select class="form-control" id="<?= $field ?>" name="<?= $field ?>" required>
                                        <option value="Débutant">Débutant</option>
                                        <option value="Intermédiaire">Intermédiaire</option>
                                        <option value="Avancé">Avancé</option>
                                        <?php if ($section === 'langues') : ?>
                                            <option value="Langue maternelle">Maternelle</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            <?php elseif ($field === 'description') : ?>
                                <div class="mb-3">
                                    <label for="<?= $field ?>" class="form-label2"><?= $label2 ?></label>
                                    <textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>" rows="5"
                                              required><?= htmlspecialchars($data[$field] ?? '') ?></textarea>
                                </div>
                            <?php else : ?>
                                <div class="mb-3">
                                    <label for="<?= $field ?>" class="form-label2"><?= $label2 ?></label>
                                    <input type="text" class="form-control" id="<?= $field ?>" name="<?= $field ?>"
                                           value="<?= htmlspecialchars($data[$field] ?? '') ?>" required>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Envoyer
                            </button>
                            <button type="reset" class="btn btn-info">
                                <i class="fas fa-eraser me-2"></i>Reset
                            </button>
                            <a href="admin/dashboard.php?section=<?= htmlspecialchars($section) ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>