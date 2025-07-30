<?php
// message_form.php
?>
<form method="POST" class="mt-4">
    <input type="hidden" name="property_id" value="<?= $property_id ?>">
    <input type="hidden" name="reply_to" value="0">

    <div class="mb-3">
        <label class="form-label">Votre nom</label>
        <input type="text" name="name" class="form-control" required 
               value="<?= htmlspecialchars($_SESSION['uname'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Votre email</label>
        <input type="email" name="email" class="form-control" required 
               value="<?= htmlspecialchars($_SESSION['uemail'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Votre téléphone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Objet</label>
        <input type="text" name="title" class="form-control" required 
               value="<?= htmlspecialchars($property_title ?? 'Nouvelle conversation') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Votre message</label>
        <textarea name="message" class="form-control" rows="4" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Envoyer le message</button>
</form>