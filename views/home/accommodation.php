<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<!-- PAGE BANNER -->
<section class="page-banner">
    <div class="banner-overlay">
        <div class="banner-content">
            <h1>Accommodation Options</h1>
            <nav class="breadcrumb">
                <a href="http://localhost/globetrek/index.php">Home</a>
                <span>&rsaquo;</span>
                <span>Accommodations</span>
            </nav>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="packages-layout no-filters">

            <!-- ACCOMMODATIONS GRID -->
            <div class="packages-main">
                <p class="results-count">
                    <i class="fas fa-hotel"></i>
                    <?= count($accommodations) ?> accommodation(s) found
                </p>

                <div class="card-grid">
                    <?php if (!empty($accommodations)): ?>
                        <?php foreach ($accommodations as $acc): ?>
                        <div class="card">
                            <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($acc['image']) ?>"
                                 alt="<?= htmlspecialchars($acc['name']) ?>"
                                 onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'">
                            <div class="card-body">
                                <span class="badge">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($acc['location']) ?>
                                </span>
                                <span class="acc-type-badge acc-<?= $acc['type'] ?>">
                                    <?= ucfirst($acc['type']) ?>
                                </span>
                                <h3><?= htmlspecialchars($acc['name']) ?></h3>
                                <p><?= substr(htmlspecialchars($acc['description']), 0, 90) ?>...</p>
                                <div class="card-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-users"></i>
                                        Max <?= $acc['max_guests'] ?> guests
                                    </span>
                                </div>
                                <div class="acc-amenities">
                                    <?php
                                    $amenities = explode(',', $acc['amenities']);
                                    foreach (array_slice($amenities, 0, 3) as $amenity):
                                    ?>
                                    <span class="amenity-tag">
                                        <?= htmlspecialchars(trim($amenity)) ?>
                                    </span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="card-footer">
                                    <span class="price">
                                        <?= formatLKR($acc['price_per_night']) ?>
                                        <small>/night</small>
                                    </span>
                                    <a href="http://localhost/globetrek/index.php?url=home/accommodationDetail/<?= $acc['id'] ?>"
                                       class="btn-view">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-data">
                            <i class="fas fa-search"></i>
                            No accommodations are available at the moment.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
