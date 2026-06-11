<?php require_once 'views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="dashboard-layout">
            <aside class="dashboard-sidebar">
                <nav class="dash-nav">
                    <a href="<?= BASE_URL ?>/?url=staff/dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/bookings">
                        <i class="fas fa-calendar-check"></i> Manage Bookings
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/packages">
                        <i class="fas fa-suitcase"></i> Manage Packages
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/accommodations">
                        <i class="fas fa-hotel"></i> Accommodations
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/coordination">
                        <i class="fas fa-bus"></i> Hotel & Transport
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/queries" class="active">
                        <i class="fas fa-comments"></i> Customer Queries
                    </a>
                    <a href="<?= BASE_URL ?>/?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>
            <div class="dashboard-main">
                <h2>Customer Queries</h2>
                <?php foreach ($queries as $q): ?>
                <div class="query-card">
                    <div class="query-header">
                        <strong><?= htmlspecialchars($q['name']) ?></strong>
                        <span><?= htmlspecialchars($q['email']) ?></span>
                        <span class="status-badge status-<?= $q['status'] ?>"><?= ucfirst($q['status']) ?></span>
                        <small><?= date('d M Y H:i', strtotime($q['created_at'])) ?></small>
                    </div>
                    <p><strong>Subject:</strong> <?= htmlspecialchars($q['subject']) ?></p>
                    <p><?= nl2br(htmlspecialchars($q['message'])) ?></p>
                    <?php if (!empty($q['reply'])): ?>
                        <div class="reply-box">
                            <strong>Reply:</strong> <?= nl2br(htmlspecialchars($q['reply'])) ?>
                        </div>
                    <?php elseif ($q['status'] === 'open'): ?>
                        <form method="POST">
                            <input type="hidden" name="query_id" value="<?= $q['id'] ?>">
                            <div class="form-group">
                                <textarea name="reply" rows="3" required placeholder="Type your reply..."></textarea>
                            </div>
                            <button type="submit" class="btn-sm btn-primary">Send Reply</button>
                        </form>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
