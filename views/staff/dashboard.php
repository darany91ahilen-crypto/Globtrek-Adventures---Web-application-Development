
<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="dashboard-layout">

            <!-- SIDEBAR -->
            
            <aside class="dashboard-sidebar">
                <div class="user-info">
                    <div class="dash-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                    <small>Staff Member</small>
                </div>

                <nav class="dash-nav">
                    <a href="http://localhost/globetrek/index.php?url=staff/dashboard"
                       class="active">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/bookings">
                        <i class="fas fa-clock"></i>
                        Manage Bookings
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/packages">
                        <i class="fas fa-box"></i>
                        Manage Packages
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/accommodations">
                        <i class="fas fa-hotel"></i>
                        Accommodations
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/coordination">
                        <i class="fas fa-bus"></i>
                        Hotel & Transport
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/queries">
                        <i class="fas fa-comments"></i>
                        Queries Reply
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/guides">
                         <i class="fas fa-book"></i>
                          Travel Guides
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
                    Staff Dashboard
                </h2>

                <!-- STATS GRID -->
                <div class="stats-grid">

                    <div class="stat-card">
                        <i class="fas fa-calendar-check stat-fa-icon"
                           style="color:var(--blue);"></i>
                        <span class="stat-num"><?= $total_bookings ?></span>
                        <span>Total Bookings</span>
                    </div>

                    <div class="stat-card stat-warning">
                        <i class="fas fa-clock stat-fa-icon"
                           style="color:var(--warning);"></i>
                        <span class="stat-num"><?= $pending_bookings ?></span>
                        <span>Pending Bookings</span>
                    </div>

                    <div class="stat-card">
                        <i class="fas fa-suitcase stat-fa-icon"
                           style="color:var(--blue);"></i>
                        <span class="stat-num"><?= $total_packages ?></span>
                        <span>Active Packages</span>
                    </div>

                    <div class="stat-card stat-danger">
                        <i class="fas fa-comments stat-fa-icon"
                           style="color:var(--danger);"></i>
                        <span class="stat-num"><?= $open_queries ?></span>
                        <span>Queries</span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>

