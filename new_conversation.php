<?php
session_start();
include("config.php");

$current_user_id = $_SESSION['uid'] ?? 0;
$error = $msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $property_id = isset($_POST['property_id']) ? (int)$_POST['property_id'] : 0;
    $message = trim($_POST['message'] ?? '');
    $name = trim($_POST['name'] ?? 'Sans nom'); // Ajout d'une valeur par défaut pour 'name'

    if ($property_id > 0 && !empty($message) && !empty($name)) {
        mysqli_begin_transaction($con);
        try {
            // Récupérer les informations de la propriété
            $property_query = mysqli_query($con, "SELECT uid, title FROM property WHERE pid = $property_id");
            if ($property_query && $property_data = mysqli_fetch_assoc($property_query)) {
                $receiver_id = $property_data['uid'];
                $property_title = $property_data['title'];

                // Créer une nouvelle conversation
                $conversation_hash = md5($property_id . $current_user_id . time());
                $insert_conv = mysqli_query($con, "
                    INSERT INTO conversations 
                    (conversation_hash, property_id, user_id, contact_name, property_title, name, last_message, unread_count, created_at, updated_at) 
                    VALUES (
                        '$conversation_hash',
                        $property_id,
                        $current_user_id,
                        '".mysqli_real_escape_string($con, $name)."',
                        '".mysqli_real_escape_string($con, $property_title)."',
                        '".mysqli_real_escape_string($con, $name)."',
                        NOW(),
                        0,
                        NOW(),
                        NOW()
                    )
                ");
                if (!$insert_conv) {
                    throw new Exception("Erreur lors de la création de la conversation: " . mysqli_error($con));
                }
                $conversation_id = mysqli_insert_id($con);

                // Insérer le premier message
                $stmt = $con->prepare("
                    INSERT INTO messages 
                    (conversation_id, sender_id, receiver_id, name, message, created_at, is_read) 
                    VALUES (?, ?, ?, ?, ?, NOW(), 0)
                ");
                $stmt->bind_param("iiiss", $conversation_id, $current_user_id, $receiver_id, $name, $message);
                if (!$stmt->execute()) {
                    throw new Exception("Erreur lors de l'envoi du message: " . $stmt->error);
                }

                // Valider la transaction
                mysqli_commit($con);
                $msg = "<div class='alert alert-success'>Conversation créée avec succès!</div>";
                header("Location: request.php?pid=$conversation_id");
                exit;
            } else {
                throw new Exception("Propriété introuvable.");
            }
        } catch (Exception $e) {
            mysqli_rollback($con);
            $error = "<div class='alert alert-danger'>Erreur: " . $e->getMessage() . "</div>";
        }
    } else {
        $error = "<div class='alert alert-warning'>Veuillez remplir tous les champs.</div>";
    }
}

// Récupérer la liste des propriétés
$properties = [];
$property_query = mysqli_query($con, "SELECT pid, title FROM property WHERE uid != $current_user_id");
while ($property = mysqli_fetch_assoc($property_query)) {
    $properties[] = $property;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Conversation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <h1 class="mb-4">Créer une Nouvelle Conversation</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($msg): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Votre nom</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="property_id" class="form-label">Sélectionnez une propriété</label>
                <select name="property_id" id="property_id" class="form-select" required>
                    <option value="">-- Choisir une propriété --</option>
                    <?php foreach ($properties as $property): ?>
                        <option value="<?= $property['pid'] ?>"><?= htmlspecialchars($property['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Votre message</label>
                <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Créer la conversation</button>
            <a href="request.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
