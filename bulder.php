<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Propriétés</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php

// Connexion à la base de données
session_start();
include("config.php");

$error = "";


// Fonction pour vérifier si l'utilisateur est un "builder"
function is_builder($uid) {
    $pdo = db_connect();

    $stmt = $pdo->prepare("SELECT utype FROM user WHERE uid = :uid");
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si l'utilisateur est un builder
    return $user && $user['utype'] === 'builder';
}

// Fonction pour ajouter une propriété
function add_property($uid, $property_data) {
    if (!is_builder($uid)) {
        return "L'utilisateur n'est pas un builder.";
    }

    $pdo = db_connect();

    // Vérification des champs obligatoires
    $required_fields = ['title', 'pcontent', 'type', 'bhk', 'stype', 'bedroom', 'bathroom', 'balcony', 'kitchen', 'hall', 'floor', 'size', 'price', 'location', 'city', 'state', 'feature', 'pimage', 'status'];
    foreach ($required_fields as $field) {
        if (empty($property_data[$field])) {
            return "Le champ $field est requis.";
        }
    }

    // Préparation de la requête SQL d'insertion
    $sql = "INSERT INTO property 
            (title, pcontent, type, bhk, stype, bedroom, bathroom, balcony, kitchen, hall, floor, size, price, location, city, state, feature, pimage, pimage1, pimage2, pimage3, pimage4, uid, status, mapimage, topmapimage, groundmapimage, totalfloor, isFeatured)
            VALUES 
            (:title, :pcontent, :type, :bhk, :stype, :bedroom, :bathroom, :balcony, :kitchen, :hall, :floor, :size, :price, :location, :city, :state, :feature, :pimage, :pimage1, :pimage2, :pimage3, :pimage4, :uid, :status, :mapimage, :topmapimage, :groundmapimage, :totalfloor, :isFeatured)";

    $stmt = $pdo->prepare($sql);

    // Ajout des données dans la base
    try {
        $stmt->execute([
            ':title' => $property_data['title'],
            ':pcontent' => $property_data['pcontent'],
            ':type' => $property_data['type'],
            ':bhk' => $property_data['bhk'],
            ':stype' => $property_data['stype'],
            ':bedroom' => $property_data['bedroom'],
            ':bathroom' => $property_data['bathroom'],
            ':balcony' => $property_data['balcony'],
            ':kitchen' => $property_data['kitchen'],
            ':hall' => $property_data['hall'],
            ':floor' => $property_data['floor'],
            ':size' => $property_data['size'],
            ':price' => $property_data['price'],
            ':location' => $property_data['location'],
            ':city' => $property_data['city'],
            ':state' => $property_data['state'],
            ':feature' => $property_data['feature'],
            ':pimage' => $property_data['pimage'],
            ':pimage1' => $property_data['pimage1'],
            ':pimage2' => $property_data['pimage2'],
            ':pimage3' => $property_data['pimage3'],
            ':pimage4' => $property_data['pimage4'],
            ':uid' => $uid,
            ':status' => $property_data['status'],
            ':mapimage' => $property_data['mapimage'] ?? null,
            ':topmapimage' => $property_data['topmapimage'] ?? null,
            ':groundmapimage' => $property_data['groundmapimage'] ?? null,
            ':totalfloor' => $property_data['totalfloor'] ?? '',
            ':isFeatured' => $property_data['isFeatured'] ?? 0,
        ]);
        return "Propriété ajoutée avec succès.";
    } catch (PDOException $e) {
        return "Erreur lors de l'ajout de la propriété : " . $e->getMessage();
    }
}

// Fonction pour lister les propriétés ajoutées par un builder
function list_properties_by_builder($uid) {
    if (!is_builder($uid)) {
        return "L'utilisateur n'est pas un builder.";
    }

    $pdo = db_connect();

    $stmt = $pdo->prepare("SELECT * FROM property WHERE uid = :uid");
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($properties)) {
        return "Aucune propriété trouvée pour cet utilisateur.";
    }

    // Retourner les propriétés sous forme d'un tableau ou en HTML
    return $properties;
}

// Exemple d'utilisation
$uid = 1;  // ID de l'utilisateur (builder)
$property_data = [
    'title' => 'Belle maison familiale',
    'pcontent' => 'Grande maison avec jardin...',
    'type' => 'Maison',
    'bhk' => '3 BHK',
    'stype' => 'Vente',
    'bedroom' => 3,
    'bathroom' => 2,
    'balcony' => 1,
    'kitchen' => 1,
    'hall' => 1,
    'floor' => '1er étage',
    'size' => 1200,
    'price' => 250000,
    'location' => 'Quartier résidentiel',
    'city' => 'Paris',
    'state' => 'Île-de-France',
    'feature' => 'Piscine, Jardin, Garage',
    'pimage' => 'image1.jpg',
    'pimage1' => 'image2.jpg',
    'pimage2' => 'image3.jpg',
    'pimage3' => 'image4.jpg',
    'pimage4' => 'image5.jpg',
    'status' => 'Disponible',
    'mapimage' => 'map1.jpg',
    'topmapimage' => 'map2.jpg',
    'groundmapimage' => 'map3.jpg',
    'totalfloor' => '3',
    'isFeatured' => 1,
];

// Ajouter une propriété
echo add_property($uid, $property_data);

// Lister les propriétés du builder
$properties = list_properties_by_builder($uid);
echo '<pre>';
print_r($properties);
echo '</pre>';

?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Propriétés</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Mon Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar et Contenu Principal -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-light sidebar py-5">
                <div class="d-flex flex-column">
                    <a href="#" class="btn btn-dark mb-3" onclick="showSection('add-property')">Ajouter Propriété</a>
                    <a href="#" class="btn btn-dark mb-3" onclick="showSection('list-property')">Lister Propriétés</a>
                    <a href="#" class="btn btn-dark mb-3" onclick="showSection('update-property')">Modifier Propriété</a>
                    <a href="#" class="btn btn-dark mb-3" onclick="showSection('delete-property')">Supprimer Propriété</a>
                </div>
            </div>

            <!-- Contenu Principal -->
            <div class="col-md-9 py-5">
                <!-- Section: Ajouter Propriété -->
                <div id="add-property" class="section">
                    <h2>Ajouter une Nouvelle Propriété</h2>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Titre de la propriété</label>
                                <input type="text" class="form-control" id="title" placeholder="Ex. Belle maison familiale">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Prix</label>
                                <input type="number" class="form-control" id="price" placeholder="250000">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="location" class="form-label">Localisation</label>
                                <input type="text" class="form-control" id="location" placeholder="Ex. Paris">
                            </div>
                            <div class="col-md-6">
                                <label for="bhk" class="form-label">BHK</label>
                                <input type="text" class="form-control" id="bhk" placeholder="Ex. 3 BHK">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" placeholder="Description de la propriété"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image principale</label>
                            <input type="file" class="form-control" id="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>

                <!-- Section: Lister Propriétés -->
                <div id="list-property" class="section d-none">
                    <h2>Liste des Propriétés</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Prix</th>
                                <th>Localisation</th>
                                <th>BHK</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="property-list">
                            <!-- Les propriétés seront affichées ici -->
                        </tbody>
                    </table>
                </div>

                <!-- Section: Modifier Propriété -->
                <div id="update-property" class="section d-none">
                    <h2>Modifier une Propriété</h2>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="update-id" class="form-label">ID de la propriété</label>
                                <input type="text" class="form-control" id="update-id" placeholder="Entrez l'ID">
                            </div>
                            <div class="col-md-6">
                                <label for="update-title" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="update-title" placeholder="Nouveau titre">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="update-description" class="form-label">Description</label>
                            <textarea class="form-control" id="update-description" rows="3" placeholder="Nouvelle description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>
                </div>

                <!-- Section: Supprimer Propriété -->
                <div id="delete-property" class="section d-none">
                    <h2>Supprimer une Propriété</h2>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="delete-id" class="form-label">ID de la propriété</label>
                                <input type="text" class="form-control" id="delete-id" placeholder="Entrez l'ID">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour afficher les différentes sections -->
    <script>
        function showSection(sectionId) {
            // Cacher toutes les sections
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.add('d-none');
            });

            // Afficher la section sélectionnée
            document.getElementById(sectionId).classList.remove('d-none');
        }
    </script>
</body>
</html>
