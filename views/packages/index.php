<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>
<section class="page-banner">
    <div class="banner-overlay">
        <div class="banner-content">
            <h1>Tour Packages</h1>
            <nav class="breadcrumb">
                <a href="http://localhost/globetrek/index.php">
                    <i class="fas fa-home"></i> Home
                </a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>Packages</span>
            </nav>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <h2 class="section-title">All Tour Packages</h2>

        <div class="packages-layout no-filters">

            <!-- PACKAGES GRID -->
            <div class="packages-main">

                <p class="results-count">
                <i class="fas fa-suitcase"></i>
                <?= count($packages) ?> package(s) found
                </p>

                <div class="card-grid">
                    <?php if (!empty($packages)): ?>
                        <?php foreach ($packages as $pkg): ?>
                        <div class="card">

                            <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($pkg['image']) ?>"
                                 alt="<?= htmlspecialchars($pkg['title']) ?>"
                                 onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'">

                            <div class="card-body">

                                <span class="badge">
                                    <?= htmlspecialchars($pkg['destination']) ?>
                                </span>

                                <h3><?= htmlspecialchars($pkg['title']) ?></h3>

                                <p>
                                    <?= substr(htmlspecialchars($pkg['description']), 0, 90) ?>...
                                </p>

                           
                                <div class="card-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        <?= $pkg['duration_days'] ?> Days
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-users"></i>
                                        Max <?= $pkg['max_persons'] ?> persons
                                    </span>
                                </div>

                                <div class="card-footer">
                                    <span class="price">
                                        <?= formatLKR($pkg['price']) ?>/person
                                    </span>
                                    <a href="http://localhost/globetrek/index.php?url=package/detail/<?= $pkg['id'] ?>"
                                       class="btn-view">
                                        View Details
                                    </a>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-data">
                            No packages are available at the moment.
                        </p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
