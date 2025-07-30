<?php
session_start();
include("config.php");

$current_user_id = $_SESSION['uid'] ?? 0;

if ($current_user_id > 0) {
    $conv_query = mysqli_query($con, "
        SELECT c.id, c.property_title, c.last_message, c.unread_count
        FROM conversations c
        LEFT JOIN property p ON c.property_id = p.pid
        WHERE c.user_id = $current_user_id OR p.uid = $current_user_id
        ORDER BY c.last_message DESC
    ");

    if ($conv_query && mysqli_num_rows($conv_query) > 0) {
        while ($conv = mysqli_fetch_assoc($conv_query)) {
            echo "<a href='?pid=" . htmlspecialchars($conv['id'] ?? '') . "' class='text-decoration-none text-dark'>";
            echo "<div class='conversation-item'>";
            echo "<div class='conversation-title'>" . htmlspecialchars($conv['property_title'] ?? 'Sans titre') . "</div>";
            echo "<div class='d-flex justify-content-between'>";
            echo "<div class='conversation-contact'>" . htmlspecialchars($conv['property_title'] ?? 'Contact inconnu') . "</div>";
            echo "<div class='conversation-date'>" . (!empty($conv['last_message']) ? date('d/m H:i', strtotime($conv['last_message'])) : 'Aucun message') . "</div>";
            echo "</div></div></a>";
        }
    } else {
        echo "<div class='p-3 text-center'>Aucune conversation trouvée</div>";
    }
}
?>
