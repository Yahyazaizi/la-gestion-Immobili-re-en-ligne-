<?php
include("config.php");

// Vérifier si l'ID du message est passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Requête pour supprimer le message
    $delete_query = "DELETE FROM messages WHERE id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Rediriger vers la page de messages avec un message de succès
        header("Location: request.php?msg=Message supprimé avec succès");
    } else {
        // Gérer l'erreur si la suppression échoue
        echo "<p>Error deleting message.</p>";
    }
    $stmt->close();
} else {
    // Si l'ID n'est pas passé, afficher une erreur
    echo "<p>ID du message non fourni.</p>";
}
?>
