
<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="dashboard-layout">

            <!-- SIDEBAR -->
            <aside class="dashboard-sidebar">
                <div class="user-info">
                    <div class="dash-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                    <small>Administrator</small>
                </div>
                <nav class="dash-nav">
                    <a href="http://localhost/globetrek/index.php?url=admin/dashboard"
                       class="active">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=admin/bookings">
                        <i class="fas fa-calendar-check"></i>
                        All Bookings
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=admin/packages">
                        <i class="fas fa-suitcase"></i>
                        Manage Packages
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=admin/users">
                        <i class="fas fa-users"></i>
                        Manage Users
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=admin/staff">
                        <i class="fas fa-user-tie"></i>
                        Manage Staff
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=admin/reports">
                        <i class="fas fa-chart-bar"></i>
                        Reports
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </nav>
            </aside>

            <!-- MAIN CONTENT -->
            <div class="dashboard-main">

                <h2>
                    <i class="fas fa-tachometer-alt"
                       style="color:var(--blue);margin-right:8px;">
                    </i>
                    Admin Dashboard
                </h2>

                <!-- STATS GRID -->
                <div class="stats-grid">

                    <div class="stat-card">
                        <i class="fas fa-users stat-fa-icon"
                           style="color:var(--blue);"></i>
                        <span class="stat-num">
                            <?= $data['total_customers'] ?>
                        </span>
                        <span>Total Customers</span>
                    </div>

                    <div class="stat-card">
                        <i class="fas fa-user-tie stat-fa-icon"
                           style="color:var(--blue);"></i>
                        <span class="stat-num">
                            <?= $data['total_staff'] ?>
                        </span>
                        <span>Staff Members</span>
                    </div>

                    <div class="stat-card">
                        <i class="fas fa-calendar-check stat-fa-icon"
                           style="color:var(--blue);"></i>
                        <span class="stat-num">
                            <?= $data['total_bookings'] ?>
                        </span>
                        <span>Total Bookings</span>
                    </div>

                    <div class="stat-card stat-warning">
                        <i class="fas fa-clock stat-fa-icon"
                           style="color:var(--warning);"></i>
                        <span class="stat-num">
                            <?= $data['pending'] ?>
                        </span>
                        <span>Pending Bookings</span>
                    </div>

                    <div class="stat-card stat-success">
                        <i class="fas fa-rupee-sign stat-fa-icon"
                           style="color:var(--success);"></i>
                        <span class="stat-num">
                            <?= formatLKR($data['revenue']) ?>
                        </span>
                        <span>Total Revenue</span>
                    </div>

                    <div class="stat-card">
                        <i class="fas fa-hotel stat-fa-icon"
                           style="color:var(--blue);"></i>
                        <span class="stat-num">
                            <?= $data['accommodations'] ?>
                        </span>
                        <span>Accommodations</span>
                    </div>

                </div>

                <!-- RECENT BOOKINGS -->
                <h3 style="margin-top:2rem;margin-bottom:1rem;">
                    Recent Bookings
                </h3>

                <?php if (!empty($recentBookings)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> Ref</th>
                            <th><i class="fas fa-user"></i> Customer</th>
                            <th><i class="fas fa-suitcase"></i> Package</th>
                            <th><i class="fas fa-calendar"></i> Date</th>
                            <th><i class="fas fa-rupee-sign"></i> Amount</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentBookings as $b): ?>
                        <tr>
                            <td>
                                #<?= str_pad($b['id'], 6, '0', STR_PAD_LEFT) ?>
                            </td>
                            <td><?= htmlspecialchars($b['full_name']) ?></td>
                            <td><?= htmlspecialchars($b['package_title']) ?></td>
                            <td>
                                <?= date('d M Y',
                                    strtotime($b['travel_date'])) ?>
                            </td>
                            <td>
                                Rs.<?= number_format($b['total_price'], 0) ?>
                            </td>
                            <td>
                                <span class="status-badge
                                      status-<?= $b['status'] ?>">
                                    <?= ucfirst($b['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-check"></i>
                    <p>No bookings yet.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>