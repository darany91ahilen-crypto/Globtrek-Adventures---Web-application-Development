<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="dashboard-layout customer-account-layout">

            <!-- ACCOUNT NAV -->
            <aside class="dashboard-sidebar customer-account-nav">
                <div class="user-info">
                    <div class="dash-avatar">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                    <small><?= htmlspecialchars($_SESSION['user_email']) ?></small>
                </div>

                <nav class="dash-nav">
                    <a href="http://localhost/globetrek/index.php?url=customer/dashboard"
                       class="active">
                        <i class="fas fa-gauge-high"></i>
                        Dashboard
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=customer/mybookings">
                        <i class="fas fa-suitcase-rolling"></i>
                        My Bookings
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=customer/query">
                        <i class="fas fa-message"></i>
                        Submit Query
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=customer/profile">
                        <i class="fas fa-address-card"></i>
                        Profile
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=auth/logout">
                        <i class="fas fa-arrow-right-from-bracket"></i>
                        Logout
                    </a>
                </nav>
            </aside>

            <!-- MAIN CONTENT -->
            <div class="dashboard-main">

                <h2>
                    Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!
                </h2>

                <!-- STATS -->
                <div class="stats-grid customer-stats-grid">
                    <div class="stat-card customer-stat-card">
                        <i class="fas fa-suitcase stat-fa-icon"></i>
                        <div>
                            <span class="stat-num"><?= $total ?></span>
                            <span class="stat-label">Total Bookings</span>
                        </div>
                    </div>
                    <div class="stat-card stat-success customer-stat-card">
                        <i class="fas fa-plane-departure stat-fa-icon"></i>
                        <div>
                            <span class="stat-num"><?= count($upcoming) ?></span>
                            <span class="stat-label">Upcoming Trips</span>
                        </div>
                    </div>
                </div>

                <!-- QUICK ACTIONS -->
                <div class="quick-actions customer-quick-actions">
                    <a href="http://localhost/globetrek/index.php?url=package/index"
                       class="btn-primary">
                        <i class="fas fa-search"></i>
                        Browse Packages
                    </a>
                </div>

                <!-- RECENT BOOKINGS -->
                <h3 style="margin-bottom:1rem;">
                    <i class="fas fa-history" style="color:var(--blue);"></i>
                    Recent Bookings
                </h3>

                <?php if (!empty($bookings)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> Ref</th>
                            <th><i class="fas fa-suitcase"></i> Package</th>
                            <th><i class="fas fa-calendar"></i> Date</th>
                            <th><i class="fas fa-rupee"></i> Amount</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($bookings, 0, 5) as $b): ?>
                        <tr>
                            <td>#<?= str_pad($b['id'], 6, '0', STR_PAD_LEFT) ?></td>
                            <td><?= htmlspecialchars($b['package_title']) ?></td>
                            <td><?= date('d M Y', strtotime($b['travel_date'])) ?></td>
                            <td><?= formatLKR($b['total_price']) ?></td>
                            <td>
                                <span class="status-badge status-<?= $b['status'] ?>">
                                    <?= ucfirst($b['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-suitcase"></i>
                    <p>No bookings yet.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
