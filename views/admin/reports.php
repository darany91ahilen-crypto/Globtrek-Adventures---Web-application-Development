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
                    <a href="<?= BASE_URL ?>/?url=admin/staff">
                        <i class="fas fa-user-tie"></i> Manage Staff
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/reports" class="active">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                    <a href="<?= BASE_URL ?>/?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>
            <div class="dashboard-main">
            
                <h3>Monthly Sales</h3>
                <table class="data-table">
                    <thead><tr><th>Month</th><th>Bookings</th><th>Revenue</th></tr></thead>
                    <tbody>
                        <?php foreach ($salesByMonth as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['month']) ?></td>
                            <td><?= $row['total_bookings'] ?></td>
                            <td><?= formatLKR($row['total_revenue']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


                <h3 style="margin-top:2rem;">Customer Activities</h3>
                <table class="data-table">
                    <thead><tr><th>Customer</th><th>Email</th><th>Total Bookings</th><th>Cash_Paid</th></tr></thead>
                    <tbody>
                        <?php foreach ($customerReport as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= $row['total_bookings'] ?></td>
                            <td><?= number_format($row['total_spent'] ?? 0, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
