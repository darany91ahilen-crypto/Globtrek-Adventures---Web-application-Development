<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="package-detail">

            <img class="detail-hero"
                 src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($package['image']) ?>"
                 alt="<?= htmlspecialchars($package['title']) ?>"
                 onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'">

            <div class="detail-layout">

                <!-- LEFT CONTENT -->
                <div class="detail-content">

                    <span class="badge">
                        <?= htmlspecialchars($package['destination']) ?>
                    </span>

                    <h1><?= htmlspecialchars($package['title']) ?></h1>

                    
                   <!-- RATING ROW -->
                    <div class="rating-row">
                        <span>
                            <i class="fas fa-clock" style="color:var(--blue);"></i>
                            <?= $package['duration_days'] ?> Days
                        </span>
                        <span>
                            <i class="fas fa-users" style="color:var(--blue);"></i>
                            Max <?= $package['max_persons'] ?> persons
                        </span>
                    </div>

                    <p class="description">
                        <?= nl2br(htmlspecialchars($package['description'])) ?>
                    </p>

                    <!-- WHATS INCLUDED -->
                    <h3>
                        <img src="https://img.icons8.com/ios-filled/22/1B3A6B/ok.png"
                             alt="included" class="heading-icon">
                        What's Included
                    </h3>

                    <ul class="includes-list">
                        <?php foreach (explode(',', $package['includes']) as $item): ?>
                        <li>
                            <img src="https://img.icons8.com/ios-filled/18/388E3C/ok.png"
                                 alt="check" class="check-icon">
                            <?= htmlspecialchars(trim($item)) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- ITINERARY -->
                    <h3>
                        <img src="https://img.icons8.com/ios-filled/22/1B3A6B/map.png"
                             alt="itinerary" class="heading-icon">
                        Itinerary
                    </h3>

                    <div class="itinerary">
                        <?php
                        $days = explode("\n", $package['itinerary']);
                        foreach ($days as $i => $day):
                            if (trim($day)):
                        ?>
                        <div class="itinerary-day">
                            <span class="day-num">
                                <img src="https://img.icons8.com/ios-filled/14/ffffff/calendar.png"
                                     alt="day" class="day-icon">
                                Day <?= $i + 1 ?>
                            </span>
                            <p><?= htmlspecialchars(trim($day)) ?></p>
                        </div>
                        <?php endif; endforeach; ?>
                    </div>
                </div>

                            <!--accommodation-->
                                <?php if (!empty($accommodations)): ?>
                <h3>
                    <i class="fas fa-hotel"
                    style="color:var(--blue);margin-right:8px;"></i>
                    Included Accommodations
                </h3>
                <div class="amenities-grid" style="margin-bottom:1.5rem;">
                    <?php foreach ($accommodations as $acc): ?>
                    <div class="amenity-item">
                        <i class="fas fa-bed"></i>
                        <div>
                            <strong>
                                <?= htmlspecialchars($acc['name']) ?>
                            </strong>
                            <br>
                            <small style="color:var(--grey);">
                                <?= htmlspecialchars($acc['location']) ?>
                                — <?= $acc['nights'] ?> nights
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- RIGHT BOOKING WIDGET -->
                <div class="booking-widget">

                    <div class="price-display">
                        <?= formatLKR($package['price']) ?>
                        <span>/person</span>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="http://localhost/globetrek/index.php?url=booking/create/<?= $package['id'] ?>"
                           class="btn-primary btn-full">
                            <img src="https://img.icons8.com/ios-filled/18/ffffff/booking.png"
                                 alt="book" class="btn-icon">
                            Book Now
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
                            <img src="https://img.icons8.com/ios-filled/16/388E3C/ok.png"
                                 alt="check" class="check-icon">
                            Cancel before (24hrs)
                        </li>
                        <li>
                            <img src="https://img.icons8.com/ios-filled/16/388E3C/ok.png"
                                 alt="check" class="check-icon">
                            Secure payment
                        </li>
                    </ul>

                </div>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>