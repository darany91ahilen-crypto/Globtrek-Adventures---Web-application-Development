
<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="package-detail">

            <img class="detail-hero"
                 src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($accommodation['image']) ?>"
                 alt="<?= htmlspecialchars($accommodation['name']) ?>"
                 onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'">

            <div class="detail-layout">
                <div class="detail-content">

                    <span class="badge">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($accommodation['location']) ?>
                    </span>
                    <span class="acc-type-badge acc-<?= $accommodation['type'] ?>"
                          style="margin-left:8px;">
                        <?= ucfirst($accommodation['type']) ?>
                    </span>

                    <h1><?= htmlspecialchars($accommodation['name']) ?></h1>

                    <div class="rating-row">
                        <span>
                            <i class="fas fa-users"></i>
                            Max <?= $accommodation['max_guests'] ?> guests
                        </span>
                    </div>

                    <p class="description">
                        <?= nl2br(htmlspecialchars($accommodation['description'])) ?>
                    </p>

                    <h3>
                        <i class="fas fa-concierge-bell"></i>
                        Amenities
                    </h3>
                    <div class="amenities-grid">
                        <?php
                        $amenities = explode(',', $accommodation['amenities']);
                        foreach ($amenities as $amenity):
                        ?>
                        <div class="amenity-item">
                            <i class="fas fa-check-circle"></i>
                            <?= htmlspecialchars(trim($amenity)) ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($accommodation['contact_phone'])): ?>
                    <h3>
                        <i class="fas fa-phone-alt"></i>
                        Contact
                    </h3>
                    <p>
                        <i class="fas fa-phone-alt" style="color:var(--blue);"></i>
                        <a href="tel:<?= htmlspecialchars($accommodation['contact_phone']) ?>">
                            <?= htmlspecialchars($accommodation['contact_phone']) ?>
                        </a>
                    </p>
                    <?php endif; ?>

                    <div style="margin-top:2rem;">
                        <a href="http://localhost/globetrek/index.php?url=home/accommodation"
                           class="btn-outline-main">
                            <i class="fas fa-arrow-left"></i>
                            Back to Accommodations
                        </a>
                        <a href="http://localhost/globetrek/index.php?url=package/index"
                           class="btn-primary"
                           style="margin-left:1rem;">
                            <i class="fas fa-suitcase"></i>
                            View Tour Packages
                        </a>
                    </div>
                </div>

                <!-- BOOKING WIDGET -->
                <div class="booking-widget">
                    <h3>
                        <i class="fas fa-bed"></i>
                        Price Per Night
                    </h3>
                    <div class="price-display">
                        <?= number_format($accommodation['price_per_night'], 2) ?>
                        <span>/night</span>
                    </div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="http://localhost/globetrek/index.php?url=package/index"
                           class="btn-primary btn-full">
                            <i class="fas fa-suitcase"></i>
                            Book a Package
                        </a>
                    <?php else: ?>
                        <a href="http://localhost/globetrek/index.php?url=auth/login"
                           class="btn-primary btn-full">
                            <i class="fas fa-sign-in-alt"></i>
                            Login to Book
                        </a>
                    <?php endif; ?>
                    <ul class="widget-includes">
                        <li>
                            <i class="fas fa-check"></i>
                            Breakfast included
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Free cancellation
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Secure booking
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>