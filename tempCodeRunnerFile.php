<?php foreach ($conversations as $conv): ?>
    <a href="?pid=<?= htmlspecialchars($conv['id'] ?? '') ?>" class="text-decoration-none text-dark">
        <div class="conversation-item <?= ($conv['id'] == $conversation_id) ? 'active' : '' ?>">
            <div class="conversation-title"><?= htmlspecialchars($conv['title'] ?? 'Sans titre') ?></div>
            <div class="d-flex justify-content-between">
                <div class="conversation-contact">
                    <?= htmlspecialchars($conv['contact_name'] ?? 'Contact inconnu') ?>
                </div>
                <div class="conversation-date">
                    <?= !empty($conv['last_message']) ? date('d/m H:i', strtotime($conv['last_message'])) : 'Aucun message' ?>
                </div>
            </div>
        </div>
    </a>
<?php endforeach; ?>