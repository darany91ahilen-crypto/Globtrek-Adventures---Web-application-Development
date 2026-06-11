<?php require_once 'views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="dashboard-layout">
            <aside class="dashboard-sidebar">
                <nav class="dash-nav">
                    <a href="<?= BASE_URL ?>/?url=admin/dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/?url=admin/bookings" class="active">
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
                    <a href="<?= BASE_URL ?>/?url=admin/reports">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                    <a href="<?= BASE_URL ?>/?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>
            <div class="dashboard-main">
                <h2>All Bookings</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ref</th><th>Customer</th><th>Package</th>
                            <th>Travel Date</th><th>Persons</th>
                            <th>Total</th><th>Status</th><th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td>#<?= str_pad($b['id'], 6, '0', STR_PAD_LEFT) ?></td>
                            <td><?= htmlspecialchars($b['full_name']) ?></td>
                            <td><?= htmlspecialchars($b['package_title']) ?></td>
                            <td><?= date('d M Y', strtotime($b['travel_date'])) ?></td>
                            <td><?= $b['num_persons'] ?></td>
                            <td><?= number_format($b['total_price'], 2) ?></td>
                            <td><span class="status-badge status-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                            <td><span class="status-badge status-<?= $b['payment_status'] ?>"><?= ucfirst($b['payment_status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
