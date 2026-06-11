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
                    <a href="<?= BASE_URL ?>/?url=customer/query">
                        <i class="fas fa-message"></i> Submit Query
                    </a>
                    <a href="<?= BASE_URL ?>/?url=customer/profile" class="active">
                        <i class="fas fa-address-card"></i> Profile
                    </a>
                    <a href="<?= BASE_URL ?>/?url=auth/logout">
                        <i class="fas fa-arrow-right-from-bracket"></i> Logout
                    </a>
                </nav>
            </aside>
            <div class="dashboard-main">
                <h2>My Profile</h2>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <form method="POST" class="profile-form">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" 
                               value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email (cannot be changed)</label>
                        <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" 
                               value="<?= htmlspecialchars($user['phone']) ?>">
                    </div>
                    <button type="submit" class="btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
