<?php require_once 'views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="dashboard-layout">
            <aside class="dashboard-sidebar">
                <nav class="dash-nav">
                    <a href="<?= BASE_URL ?>/?url=admin/dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/bookings">
                        <i class="fas fa-calendar-check"></i> All Bookings
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/packages">
                        <i class="fas fa-suitcase"></i> Manage Packages
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/users">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/staff" class="active">
                        <i class="fas fa-user-tie"></i> Manage Staff
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/reports">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                    <a href="<?= BASE_URL ?>/?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>
            <div class="dashboard-main">
                <h2>Manage Staff Accounts</h2>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <details class="collapsible">
                    <summary class="btn-outline">+Add New Staff</summary>
                    <form method="POST" class="package-form">
                        <input type="hidden" name="action" value="create">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="tel" name="phone">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" required minlength="6">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">Create Staff Account</button>
                    </form>
                </details>

                <table class="data-table" style="margin-top:1.5rem;">
                    <thead>
                        <tr><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Joined</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($staffList as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['full_name']) ?></td>
                            <td><?= htmlspecialchars($s['email']) ?></td>
                            <td><?= htmlspecialchars($s['phone']) ?></td>
                            <td><span class="status-badge status-<?= $s['status'] ?>"><?= ucfirst($s['status']) ?></span></td>
                            <td><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="toggle">
                                    <input type="hidden" name="user_id" value="<?= $s['id'] ?>">
                                    <input type="hidden" name="status" 
                                           value="<?= $s['status'] === 'active' ? 'inactive' : 'active' ?>">
                                    <button type="submit" 
                                            class="btn-sm <?= $s['status'] === 'active' ? 'btn-danger' : 'btn-primary' ?>">
                                        <?= $s['status'] === 'active' ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
