<?php
session_start();
include("config.php");

$current_user_id = $_SESSION['uid'] ?? 0;
$conversation_id = isset($_GET['pid']) ? (int)$_GET['pid'] : 0;

if ($conversation_id > 0) {
    $query = mysqli_query($con, "
        SELECT m.*, 
               u1.uname AS sender_name,
               u1.uemail AS sender_email,
               u2.uname AS receiver_name,
               m.created_at,
               m.reply_to
        FROM messages m
        LEFT JOIN user u1 ON m.sender_id = u1.uid
        LEFT JOIN user u2 ON m.receiver_id = u2.uid
        WHERE m.conversation_id = $conversation_id
        ORDER BY m.created_at ASC
    ");

    if (!$query) {
        echo "<div class='alert alert-danger'>Erreur de requête: " . mysqli_error($con) . "</div>";
        return;
    }

    $displayed_title = false;

    while ($msg = mysqli_fetch_assoc($query)) {
        $is_sender = ($msg['sender_id'] == $current_user_id);
        $sender_name = $is_sender ? 'Vous' : htmlspecialchars($msg['sender_name'] ?? 'Inconnu');
        $bg_class = $is_sender ? 'sent' : 'received';

        if (!$displayed_title) {
            echo "<h3>Conversation avec " . htmlspecialchars($msg['receiver_name'] ?? 'Inconnu') . "</h3>";
            $displayed_title = true;
        }

        echo "<div class='message-container'>";
        echo "<div class='message-bubble $bg_class'>";
        echo "<div class='message-header'>";
        echo "<strong>$sender_name</strong> - <span class='message-time'>" . date('d/m/Y H:i', strtotime($msg['created_at'])) . "</span>";
        echo "</div>";

        if (!empty($msg['reply_to']) && $msg['reply_to'] > 0) {
            $reply_query = mysqli_query($con, "SELECT m.message, u.uname 
                                             FROM messages m 
                                             JOIN user u ON m.sender_id = u.uid 
                                             WHERE m.id = {$msg['reply_to']}");
            if ($reply_query && mysqli_num_rows($reply_query) > 0) {
                $reply_data = mysqli_fetch_assoc($reply_query);
                echo "<div class='reply-indicator'>";
                echo "En réponse à <a href='#msg-{$msg['reply_to']}'>" . htmlspecialchars($reply_data['uname'] ?? 'Inconnu') . "</a>";
                echo "</div>";
                echo "<blockquote>" . nl2br(htmlspecialchars($reply_data['message'] ?? '')) . "</blockquote>";
            }
        }

        echo "<p>" . nl2br(htmlspecialchars($msg['message'] ?? '')) . "</p>";
        echo "</div>";

        if (!$is_sender) {
            echo "<div class='message-footer'>";
            echo "<button class='btn btn-sm btn-outline-success mt-2 reply-button' onclick=\"redirectToReplyForm({$msg['id']})\">Répondre</button>";
            echo "</div>";
        }

        echo "</div>";
    }
}
?>

<script>
function redirectToReplyForm(replyToId) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('reply_to', replyToId);
    window.location.search = urlParams.toString();

    // Scroll to the form after redirection
    setTimeout(() => {
        const form = document.querySelector('form');
        if (form) {
            form.scrollIntoView({ behavior: 'smooth' });
        }
    }, 500);
}
</script>
