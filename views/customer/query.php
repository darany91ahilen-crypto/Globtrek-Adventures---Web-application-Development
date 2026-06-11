<?php require_once 'views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="dashboard-layout customer-account-layout">
            <aside class="dashboard-sidebar customer-account-nav">
                <nav class="dash-nav">
                    <a href="<?= BASE_URL ?>/?url=customer/dashboard">
                        <i class="fas fa-gauge-high"></i> Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/?url=customer/mybookings">
                        <i class="fas fa-suitcase-rolling"></i> My Bookings
                    </a>
                    <a href="<?= BASE_URL ?>/?url=customer/query" class="active">
                        <i class="fas fa-message"></i> Submit Query
                    </a>
                    <a href="<?= BASE_URL ?>/?url=customer/profile">
                        <i class="fas fa-address-card"></i> Profile
                    </a>
                    <a href="<?= BASE_URL ?>/?url=auth/logout">
                        <i class="fas fa-arrow-right-from-bracket"></i> Logout
                    </a>
                </nav>
            </aside>
            <div class="dashboard-main">
                <h2>Your Thoughts...</h2>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" required placeholder="e.g. Accomadation inquiry">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="5" required placeholder="Write here..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
