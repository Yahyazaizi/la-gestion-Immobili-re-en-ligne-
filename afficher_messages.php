<?php
include("config.php");
session_start();

// Récupérer l'ID de la conversation
$conversation_id = isset($_GET['conversation_id']) ? $_GET['conversation_id'] : null;

if (!$conversation_id) {
    die("Conversation non spécifiée.");
}

// Marquer tous les messages comme lus
$pdo->prepare("UPDATE messages SET is_read = 1 WHERE conversation_id = ? AND is_read = 0")
    ->execute([$conversation_id]);

// Récupérer tous les messages de la conversation
$stmt = $pdo->prepare("SELECT * FROM messages WHERE conversation_id = ? ORDER BY created_at ASC");
$stmt->execute([$conversation_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Conversation</title>
</head>
<body>

<h1>Conversation</h1>

<?php foreach ($messages as $msg): ?>
    <div style="border:1px solid #ccc; margin-bottom:10px; padding:10px;">
        <strong><?php echo htmlspecialchars($msg['name']); ?> :</strong><br>
        <?php echo nl2br(htmlspecialchars($msg['message'])); ?><br>
        <small>Envoyé le <?php echo $msg['created_at']; ?></small>
    </div>
<?php endforeach; ?>

<!-- Formulaire de réponse -->
<h2>Répondre</h2>
<form action="envoyer_message.php" method="POST">
    <input type="hidden" name="sender_id" value="1"> <!-- ID de l'utilisateur connecté -->
    <input type="hidden" name="receiver_id" value="2"> <!-- ID du destinataire -->
    <input type="hidden" name="property_id" value=""> <!-- Peut être vide -->
    <input type="hidden" name="conversation_id" value="<?php echo $conversation_id; ?>">
    <input type="hidden" name="reply_to" value=""> <!-- Peut être mis à l'ID du message parent -->

    <input type="text" name="name" placeholder="Votre nom" required><br>
    <input type="email" name="email" placeholder="Votre email" required><br>
    <textarea name="message" placeholder="Votre réponse..." required></textarea><br>
    <button type="submit">Envoyer la réponse</button>
</form>

</body>
</html>
