<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Explore the Pearl Paradise with us!</h1>

    </div>
    </section>

<!-- FEATURED PACKAGES -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Packages here!</h2>
        <div class="card-grid">
            <?php if (!empty($featured)): ?>
                <?php foreach ($featured as $pkg): ?>
                <div class="card">

                    <?php if ($pkg['price'] <= 250): ?>
                        <span class="card-tag hot">Hot</span>
                    <?php endif; ?>

                    <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($pkg['image']) ?>"
                         alt="<?= htmlspecialchars($pkg['title']) ?>"
                         onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'">

                    <div class="card-body">
                        <span class="badge">
                            <?= htmlspecialchars($pkg['destination']) ?>
                        </span>
                        <h3><?= htmlspecialchars($pkg['title']) ?></h3>
                        <p>
                            <?= substr(htmlspecialchars($pkg['description']), 0, 100) ?>...
                        </p>

                               
                        <div class="card-meta">
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            <?= $pkg['duration_days'] ?> Days /
                            <?= $pkg['duration_days'] - 1 ?> Nights
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
                <p class="no-data">No packages available at the moment.</p>
            <?php endif; ?>
        </div>

        <div style="text-align:center; margin-top:2rem;">
            <a href="http://localhost/globetrek/index.php?url=package/index"
               class="btn-primary">
                View All Packages
            </a>
        </div>
    </div>
</section>
                    <!--  DESTINATIONS -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Top Destinations</h2>
        <div class="destinations-grid">
            <?php if (!empty($destinations)): ?>
                <?php foreach ($destinations as $dest): ?>
                <div class="dest-card">
                    <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($dest['image'] ?? 'default.jpg') ?>"
                         alt="<?= htmlspecialchars($dest['name']) ?>"
                         onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'">
                    <div class="dest-overlay">
                        <h4><?= htmlspecialchars($dest['name']) ?></h4>
                        <p><?= htmlspecialchars($dest['country'] ?? 'Sri Lanka') ?></p>
                        <a href="http://localhost/globetrek/index.php?url=package/index&destination=<?= urlencode($dest['name']) ?>"
                           class="dest-btn">
                            <i class="fas fa-arrow-right"></i> Explore
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
