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
                    <a href="<?= BASE_URL ?>/?url=admin/users" class="active">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/staff">
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
                <h2>All Customers</h2>
                <table class="data-table">
                    <thead>
                        <tr><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Registered</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['full_name']) ?></td>
                            <td><?= htmlspecialchars($c['email']) ?></td>
                            <td><?= htmlspecialchars($c['phone']) ?></td>
                            <td><span class="status-badge status-<?= $c['status'] ?>"><?= ucfirst($c['status']) ?></span></td>
                            <td><?= date('d M Y', strtotime($c['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
