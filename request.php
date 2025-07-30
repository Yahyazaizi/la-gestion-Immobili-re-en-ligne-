<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
if(!isset($_SESSION['uemail']))
{
	header("location:login.php");
}

// Au début du fichier pour capturer les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialisation des variables
$error = $msg = '';
$current_user_id = $_SESSION['uid'] ?? 0;
$conversation_id = isset($_GET['pid']) ? (int)$_GET['pid'] : null;
$reply_to = isset($_GET['reply_to']) ? (int)$_GET['reply_to'] : 0;

// Debug information
error_log("User ID: " . $current_user_id);
error_log("Conversation ID from URL: " . $conversation_id);

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $property_id = isset($_POST['property_id']) ? (int)$_POST['property_id'] : 0;
    $reply_to = isset($_POST['reply_to']) ? (int)$_POST['reply_to'] : 0;
    $conversation_id = isset($_POST['conversation_id']) ? (int)$_POST['conversation_id'] : null;

    error_log("FORM DATA: name=$name, email=$email, property_id=$property_id, conversation_id=$conversation_id");

    if (!empty($name) && !empty($email) && !empty($message)) {
        mysqli_begin_transaction($con);
        try {
            $sender_id = $current_user_id;
            $receiver_id = 0;

            // Vérifier si pid dans l'URL est bien une conversation existante
            if ($conversation_id) {
                $check_conv = $con->prepare("SELECT id FROM conversations WHERE id = ?");
                $check_conv->bind_param("i", $conversation_id);
                $check_conv->execute();
                $check_result = $check_conv->get_result();

                if ($check_result->num_rows == 0) {
                    // Si pid n'est pas une conversation, c'est peut-être une propriété
                    error_log("pid=$conversation_id n'est pas une conversation existante, traitement comme ID de propriété");
                    $property_id = $conversation_id;
                    $conversation_id = null;
                }
                $check_conv->close();
            }

            // Déterminer le destinataire
            if ($reply_to > 0) {
                $reply_stmt = $con->prepare("SELECT sender_id FROM messages WHERE id = ?");
                $reply_stmt->bind_param("i", $reply_to);
                $reply_stmt->execute();
                $reply_result = $reply_stmt->get_result();

                if ($reply_result && $reply_data = $reply_result->fetch_assoc()) {
                    $receiver_id = $reply_data['sender_id'];
                    error_log("Réponse au message ID=$reply_to, receiver=$receiver_id");
                }
                $reply_stmt->close();
            } elseif ($conversation_id) {
                $conv_stmt = $con->prepare("SELECT user_id, property_id FROM conversations WHERE id = ?");
                $conv_stmt->bind_param("i", $conversation_id);
                $conv_stmt->execute();
                $conv_result = $conv_stmt->get_result();

                if ($conv_result && $conv_data = $conv_result->fetch_assoc()) {
                    $conversation_user_id = $conv_data['user_id'];
                    $property_id = $conv_data['property_id']; // Récupérer le property_id de la conversation

                    // Si l'expéditeur est l'utilisateur de la conversation, trouver le propriétaire
                    if ($sender_id == $conversation_user_id) {
                        $prop_stmt = $con->prepare("SELECT uid FROM property WHERE pid = ?");
                        $prop_stmt->bind_param("i", $property_id);
                        $prop_stmt->execute();
                        $prop_result = $prop_stmt->get_result();
                        if ($prop_result && $prop_data = $prop_result->fetch_assoc()) {
                            $receiver_id = $prop_data['uid'];
                            error_log("Message dans conversation existante: receiver est propriétaire=$receiver_id");
                        }
                        $prop_stmt->close();
                    } else {
                        // Sinon, le destinataire est l'utilisateur de la conversation
                        $receiver_id = $conversation_user_id;
                        error_log("Message dans conversation existante: receiver est utilisateur=$receiver_id");
                    }
                }
                $conv_stmt->close();
            } else {
                // Création d'une nouvelle conversation
                error_log("Tentative de création d'une nouvelle conversation, property_id=$property_id");

                if (empty($property_id)) {
                    throw new Exception("ID de propriété manquant pour la nouvelle conversation");
                }

                // Récupérer les infos de la propriété
                $prop_stmt = $con->prepare("SELECT uid, title FROM property WHERE pid = ?");
                $prop_stmt->bind_param("i", $property_id);
                $prop_stmt->execute();
                $prop_result = $prop_stmt->get_result();

                if ($prop_result && $prop_data = $prop_result->fetch_assoc()) {
                    $receiver_id = $prop_data['uid'];
                    $property_title = $prop_data['title'];
                    error_log("Propriété trouvée: title=$property_title, receiver=$receiver_id");

                    // Vérifier si une conversation existe déjà
                    $check_existing = $con->prepare("SELECT id FROM conversations WHERE property_id = ? AND user_id = ?");
                    $check_existing->bind_param("ii", $property_id, $current_user_id);
                    $check_existing->execute();
                    $existing_result = $check_existing->get_result();

                    if ($existing_result->num_rows > 0) {
                        $existing_data = $existing_result->fetch_assoc();
                        $conversation_id = $existing_data['id'];
                        error_log("Conversation existante trouvée: id=$conversation_id");
                    } else {
                        // Générer un hash unique pour la conversation
                        $conversation_hash = md5($property_id . "_" . $current_user_id . "_" . time());

                        // Créer la nouvelle conversation
                        $conv_stmt = $con->prepare("
                            INSERT INTO conversations 
                            (conversation_hash, property_id, user_id, contact_name, property_title, last_message, unread_count, created_at, updated_at) 
                            VALUES (?, ?, ?, ?, ?, NOW(), 1, NOW(), NOW())
                        ");

                        $conv_stmt->bind_param(
                            "siiss",
                            $conversation_hash,
                            $property_id,
                            $current_user_id,
                            $name,
                            $property_title
                        );

                        error_log("Tentative d'insertion de conversation: hash=$conversation_hash, property=$property_id, user=$current_user_id");

                        if (!$conv_stmt->execute()) {
                            throw new Exception("Erreur lors de la création de la conversation: " . $conv_stmt->error);
                        }

                        $conversation_id = $con->insert_id;
                        error_log("Nouvelle conversation créée: id=$conversation_id");
                        $conv_stmt->close();
                    }
                    $check_existing->close();
                } else {
                    throw new Exception("Propriété introuvable");
                }
                $prop_stmt->close();
            }

            // Vérifier que conversation_id est valide
            if (empty($conversation_id)) {
                throw new Exception("ID de conversation invalide");
            }

            // Insérer le message
            $msg_stmt = $con->prepare("
                INSERT INTO messages 
                (name, email, message, sender_id, receiver_id, reply_to, property_id, conversation_id, created_at, is_read) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 0)
            ");

            error_log("Tentative d'insertion de message: sender=$sender_id, receiver=$receiver_id, conversation=$conversation_id");

            $msg_stmt->bind_param(
                "sssiiiii",
                $name,
                $email,
                $message,
                $sender_id,
                $receiver_id,
                $reply_to,
                $property_id,
                $conversation_id
            );

            if (!$msg_stmt->execute()) {
                throw new Exception("Erreur lors de l'envoi du message: " . $msg_stmt->error);
            }

            $message_id = $con->insert_id;
            error_log("Message inséré avec succès: id=$message_id");
            $msg_stmt->close();

            // Mettre à jour le timestamp de la dernière modification de la conversation
            $update_stmt = $con->prepare("UPDATE conversations SET last_message = NOW(), updated_at = NOW(), unread_count = unread_count + 1 WHERE id = ?");
            $update_stmt->bind_param("i", $conversation_id);
            $update_stmt->execute();
            $update_stmt->close();

            // Commit la transaction
            mysqli_commit($con);
            $msg = "<div class='alert alert-success'>Message envoyé avec succès!</div>";

            // Rediriger vers la conversation
            header("Location: ?pid=".$conversation_id);
            exit;
        } catch (Exception $e) {
            mysqli_rollback($con);
            $error = "<div class='alert alert-danger'>Erreur: " . $e->getMessage() . "</div>";
            error_log("Message Insertion Error: " . $e->getMessage());
        }
    } else {
        $error = "<div class='alert alert-warning'>Veuillez remplir tous les champs obligatoires!</div>";
    }
}

// Handle conversation deletion
if (isset($_GET['delete_conversation']) && $conversation_id) {
    $delete_query = mysqli_query($con, "DELETE FROM conversations WHERE id = $conversation_id");
    if ($delete_query) {
        $msg = "<div class='alert alert-success'>Conversation supprimée avec succès!</div>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = "<div class='alert alert-danger'>Erreur lors de la suppression de la conversation: " . mysqli_error($con) . "</div>";
    }
}

// Fonction d'affichage des messages
function displayMessages($con, $conversation_id, $current_user_id) {
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

    if (mysqli_num_rows($query) > 0) {
        echo '<div class="message-thread" id="messageThread">';
        
        while ($msg = mysqli_fetch_assoc($query)) {
            $is_sender = ($msg['sender_id'] == $current_user_id);
            $sender_name = $is_sender ? 'Vous' : htmlspecialchars($msg['sender_name']);
            $bg_class = $is_sender ? 'sent' : 'received';

            // Display the referenced message if it's a reply
            if (!empty($msg['reply_to']) && $msg['reply_to'] > 0) {
                $reply_query = mysqli_query($con, "SELECT m.message, u.uname 
                                                 FROM messages m 
                                                 JOIN user u ON m.sender_id = u.uid 
                                                 WHERE m.id = {$msg['reply_to']}");
                if ($reply_query && mysqli_num_rows($reply_query) > 0) {
                    $reply_data = mysqli_fetch_assoc($reply_query);
                    echo "<div class='reply-indicator'>";
                    echo "En réponse à <a href='#msg-{$msg['reply_to']}'>{$reply_data['uname']}</a>";
                    echo "</div>";
                    echo "<blockquote>" . nl2br(htmlspecialchars($reply_data['message'])) . "</blockquote>";
                }
            }

            echo "<div class='message-container' id='msg-{$msg['id']}'>";
            echo "<div class='message-bubble $bg_class'>";
            echo "<div class='message-header'>";
            echo "<strong>$sender_name</strong> - <span class='message-time'>" . date('d/m/Y H:i', strtotime($msg['created_at'])) . "</span>";
            echo "</div>";
            echo "<p>" . nl2br(htmlspecialchars($msg['message'])) . "</p>";
            
            if (!$is_sender) {
                echo "<div class='message-footer'>";
                echo "<small>Email: " . htmlspecialchars($msg['sender_email']) . "</small><br>";
                // echo "<a href='?pid={$conversation_id}&reply_to={$msg['id']}' class='btn btn-sm btn-success mt-2' style='background: linear-gradient(90deg,#00c6ff,#0072ff); color: #fff; border: none; font-weight: bold;'>Travailler</a>";
                echo "</div>";
            }
            
            echo "</div></div>";
        }
        
        echo '</div>';
    } else {
        echo "<div class='alert alert-info'>Aucun message dans cette conversation</div>";
    }
}

// Récupération des conversations
$conversations = [];
if ($current_user_id > 0) {
    $conv_query = mysqli_query($con, "
        SELECT c.id, c.property_title, c.last_message, c.unread_count
        FROM conversations c
        LEFT JOIN property p ON c.property_id = p.pid
        WHERE c.user_id = $current_user_id OR p.uid = $current_user_id
        ORDER BY c.last_message DESC
    ");

    while ($conv = mysqli_fetch_assoc($conv_query)) {
        $conversations[] = $conv;
    }
}

// Récupération des infos propriété si conversation sélectionnée
$owner_email = $owner_name = '';
if ($conversation_id) {
    $prop_query = mysqli_query($con, "
        SELECT u.uemail, u.uname
        FROM property p
        JOIN user u ON p.uid = u.uid
        WHERE p.pid = $conversation_id
    ");
    if ($prop_query && mysqli_num_rows($prop_query) > 0) {
        $prop_data = mysqli_fetch_assoc($prop_query);
        $owner_email = $prop_data['uemail'];
        $owner_name = $prop_data['uname'];
    }
}

// Infos utilisateur connecté
$username = $user_email = '';
if ($current_user_id > 0) {
    $user_q = $con->prepare("SELECT uname, uemail FROM user WHERE uid = ?");
    $user_q->bind_param("i", $current_user_id);
    $user_q->execute();
    $user_result = $user_q->get_result();
    if ($user_result->num_rows > 0) {
        $user_data = $user_result->fetch_assoc();
        $username = $user_data['uname'] ?? ''; // Ensure $username is initialized
        $user_email = $user_data['uemail'] ?? '';
    }
}
// On récupère l'autre utilisateur (celui qui n'est pas $current_user_id)

function markAsRead($con, $message_id, $user_id) {
    $stmt = $con->prepare("INSERT INTO message_read_status (message_id, user_id) VALUES (?, ?) 
                          ON DUPLICATE KEY UPDATE read_at = CURRENT_TIMESTAMP");
    $stmt->bind_param("ii", $message_id, $user_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Meta Tags -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="images/favicon.ico">
    

	<!--	Fonts
	========================================================-->
	<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

	<!--	Css Link
	========================================================-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/layerslider.css">
	<link rel="stylesheet" type="text/css" href="css/color.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/styledarkmode.css">


    <style>

:root {
  --base-color: white;
  --base-variant: #e8e9ed;
  --text-color: #111528;
  --secondary-text: #232738;
  --primary-color: #3a435d;
  --accent-color: #0071ff;
}

.darkmode {
  --base-color: #070b1d;
  --base-variant: #101425;
  --text-color: #ffffff;
  --secondary-text: #a4a5b8;
  --primary-color: #3a435d;
  --accent-color:  #218838; ;
}.message .card {
  background-color: var(--secondary-variant);
  color: var(--text-color);
  border: 1px solid var(--border-color);
}

.message .card-header {
  background-color: var(--accent-color);
  color: #ffffff;
}

/* Liste de conversation */
.message .conversation-list {
  max-height: 400px;
  overflow-y: auto;
}

.message .conversation-item {
  padding: 10px;
  border-bottom: 1px solid var(--border-color);
  transition: background 0.2s;
}

.message .conversation-item:hover {
  background-color: #2a2a2a;
}

.message .conversation-item.active {
  background-color: var(--accent-color);
  color: #ffffff;
}

/* Thread de message */
.message .message-thread {
  background-color: var(--base-variant);
  border: 1px solid var(--border-color);
  padding: 15px;
  max-height: 400px;
  overflow-y: auto;
}

/* Formulaire */
.message input,
.message textarea {
  background-color:var(--base-variant);
  color: var(--text-color);
  border: 1px solid var(--border-color);
}

.message input:focus,
.message textarea:focus {
    background-color:var(--base-variant);
  color: var(--text-color);
  border: 1px solid var(--border-color);
  
  
}

/* Boutons */
.message .btn-primary {
  background-color: var(--accent-color);
  border-color: var(--accent-color);
}

.message .btn-outline-secondary {
  border-color: var(--border-color);
  color: var(--text-color);
}
input{
    border-color: solid black 2px;
}
.message .btn-outline-secondary:hover {
  background-color: #333333;
}

/* Texte muted */
.message .text-muted {
  color: #bbbbbb !important;
}
.message-thread{
    color: black;

}

        .message-bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 70%;
            margin-bottom: 10px;
            position: relative;
            word-wrap: break-word;
        }
        .sent {
            background-color: #DCF8C6;
            margin-left: auto;
            border-bottom-right-radius: 0;
        }
        .received {
            background-color: #ECECEC;
            margin-right: auto;
            border-bottom-left-radius: 0;
        }
        .message-container {
            margin-bottom: 15px;
        }
        .message-header {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .message-time {
            font-size: 0.75rem;
            color: #666;
        }
        .message-footer {
            margin-top: 5px;
            font-size: 0.8rem;
        }
        .conversation-list {
            max-height: 70vh;
            overflow-y: auto;
        }
        .conversation-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .conversation-item:hover {
            background-color: #f8f9fa;
        }
        .conversation-item.active {
            background-color: #e9f7fe;
        }
        .conversation-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        .conversation-contact {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .conversation-date {
            font-size: 0.75rem;
            color: #adb5bd;
        }
        .message-thread {
            max-height: 60vh;
            overflow-y: auto;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .message-container {
            margin-bottom: 15px;
        }
        .message-bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 70%;
            margin-bottom: 10px;
            position: relative;
            word-wrap: break-word;
        }
        .sent {
            background-color: #DCF8C6;
            margin-left: auto;
            border-bottom-right-radius: 0;
        }
        .received {
            background-color: #ECECEC;
            margin-right: auto;
            border-bottom-left-radius: 0;
        }
        .message-header {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .message-time {
            font-size: 0.75rem;
            color: #666;
        }
        .message-footer {
            margin-top: 5px;
            font-size: 0.8rem;
        }
        .conversation-list {
            max-height: 70vh;
            overflow-y: auto;
        }
        .conversation-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .conversation-item:hover {
            background-color: #f8f9fa;
        }
        .conversation-item.active {
            background-color: #e9f7fe;
        }
        .message-thread {
            max-height: 60vh;
            overflow-y: auto;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        blockquote {
            border-left: 3px solid #ccc;
            margin: 10px 0;
            padding-left: 15px;
            color: #666;
            font-style: italic;
            background-color: #f5f5f5;
            padding: 8px;
            border-radius: 4px;
        }
        .reply-indicator {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .reply-indicator a {
            color: inherit;
            text-decoration: underline;
        }
        label{color:yellowgreen

        }
    </style>
</head>

<?php include("include/header.php"); ?>
    
    <div class="container-fluid py-4 ">
        <div class="row">
            <div class="col-md-3  ">
                <div class="card">
                    <div class="card-header   " style="background-color: #28a745;">
                        <h5   >Conversations</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="conversation-list" >
                            <?php if (count($conversations) > 0): ?>
                                <?php foreach ($conversations as $conv): ?>
                                    <a href="?pid=<?= $conv['id'] ?>" class="text-decoration-none text-dark">
                                        <div class="conversation-item <?= ($conv['id'] == $conversation_id) ? 'active' : '' ?>">
                                            <div class="conversation-title"><?= htmlspecialchars($conv['property_title'] ?? '') ?></div>
                                            <div class="d-flex justify-content-between">
                                                <div class="conversation-contact">
                                                    <?= htmlspecialchars($conv['property_title'] ?? '') ?>
                                                </div>
                                                <div class="conversation-date">
                                                    <?= date('d/m H:i', strtotime($conv['last_message'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="p-3 text-center">Aucune conversation</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <?php if ($conversation_id): ?>
                    <div class="card">
                        <div class="card-header text-white d-flex justify-content-between align-items-center"  style="background-color: #28a745;">
                            <h5>Conversation</h5>
                            <div>
                                <a href="?pid=<?= $conversation_id ?>&delete_conversation=true" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette conversation?')">
                                    Supprimer
                                </a>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="message-thread" id="messageThread">
                                <?php displayMessages($con, $conversation_id, $current_user_id); ?>
                            </div>
                            
                            <?php
                            // Préparation du message de réponse
                            $quoted_message = '';
                            if ($reply_to > 0) {
                                $reply_query = mysqli_query($con, "SELECT message FROM messages WHERE id = $reply_to");
                                if ($reply_data = mysqli_fetch_assoc($reply_query)) {
                                    $quoted_message = " " . str_replace("\n", "\n> ", $reply_data['message']) . "\n\n";
                                }
                            }
                            ?>
                            
                            <!-- Form for sending messages -->
                            <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>" class="mt-3">
                                <input type="hidden" name="property_id" value="<?= $conversation_id ?>">
                                <input type="hidden" name="conversation_id" value="<?= $conversation_id ?>">
                                <input type="hidden" name="reply_to" value="<?= $reply_to ?>">
                                
                                <div class="row ">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Votre nom</label>
                                        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($username ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3 ">
                                        <label class="form-label">Votre email</label>
                                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user_email ?? '') ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Votre message</label>
                                    <textarea name="message" class="form-control border border-dark" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                                <?php if ($reply_to > 0): ?>
                                    <a href="?pid=<?= $conversation_id ?>" class="btn btn-outline-secondary">Annuler la réponse</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <h4 class="text-muted">Sélectionnez une conversation</h4>
                            <p class="text-muted">Choisissez une conversation dans la liste à gauche ou créez-en une nouvelle</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageThread = document.getElementById('messageThread');
            const form = document.querySelector('form');

            // Scroll to the bottom of the message thread
            if (messageThread) {
                messageThread.scrollTop = messageThread.scrollHeight;
            }

            // Handle form submission via AJAX
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.disabled = true; // Disable the button to prevent multiple submissions

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newThread = doc.getElementById('messageThread');
                        if (newThread && messageThread) {
                            messageThread.innerHTML = newThread.innerHTML;
                            messageThread.scrollTop = messageThread.scrollHeight;
                        }
                        form.reset(); // Reset the form fields
                    })
                    .catch(error => console.error('Erreur lors de l\'envoi du message:', error))
                    .finally(() => {
                        submitButton.disabled = false; // Re-enable the button
                    });
                });
            }

            // Refresh messages every 15 seconds
            setInterval(function() {
                if (window.location.search.includes('pid=')) {
                    fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newThread = doc.getElementById('messageThread');
                            if (newThread && messageThread) {
                                messageThread.innerHTML = newThread.innerHTML;
                                messageThread.scrollTop = messageThread.scrollHeight;
                            }
                        })
                        .catch(error => console.error('Erreur lors du rafraîchissement:', error));
                }
            }, 15000);
        });

        function createConversation(propertyId, contactName) {
            fetch('request.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                body: 'property_id=' + encodeURIComponent(propertyId) + '&name=' + encodeURIComponent(contactName) + '&email=test@example.com&message=Bonjour'
            })
            .then(response => response.text())
            .then(html => {
                // Recharge la page pour afficher la nouvelle conversation
                window.location.reload();
            })
            .catch(error => alert('Erreur lors de la création de la conversation'));
        }
    </script>

</body>
</html>

    <!-- Request Form end -->

  
    
    <!-- Footer start -->
    <?php include("include/footer.php");?>
    <!-- Footer end -->
    
    <!-- Scroll to top --> 
    <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
    <!-- End Scroll To top --> 
</div>

<!-- Js Link -->
<script src="js/jquery.min.js"></script> 
<!-- jQuery Layer Slider --> 
<script src="js/greensock.js"></script> 
<script src="js/layerslider.transitions.js"></script> 
<script src="js/layerslider.kreaturamedia.jquery.js"></script> 
<!-- jQuery Layer Slider --> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/tmpl.js"></script> 
<script src="js/jquery.dependClass-0.1.js"></script> 
<script src="js/draggable-0.1.js"></script> 
<script src="js/jquery.slider.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script>
<script type="text/javascript" src="dark.js" defer></script>


</body>
</html>