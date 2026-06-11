<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="dashboard-layout customer-account-layout">

            <!-- ACCOUNT NAV -->
            <aside class="dashboard-sidebar customer-account-nav">
                <nav class="dash-nav">
                    <a href="http://localhost/globetrek/index.php?url=customer/dashboard">
                        <i class="fas fa-gauge-high"></i>
                        Dashboard
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=customer/mybookings"
                       class="active">
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

            <!-- MAIN -->
            <div class="dashboard-main">

                <h2>
                    <i class="fas fa-calendar-check"
                       style="color:var(--blue);
                              margin-right:8px;"></i>
                    My Bookings
                </h2>

                <?php if (!empty($bookings)): ?>
                <div class="bookings-list">
                    <?php foreach ($bookings as $b): ?>
                    <div class="booking-card"
                         style="flex-direction:column;">

                        <!-- TOP ROW — IMAGE + MAIN DETAILS -->
                        <div style="display:flex;gap:0;">

                            <!-- IMAGE -->
                            <div class="booking-card-image">
                                <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($b['image']) ?>"
                                     alt="<?= htmlspecialchars($b['package_title']) ?>"
                                     onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'">
                            </div>

                            <!-- MAIN INFO -->
                            <div class="booking-card-content">

                                <div class="booking-card-header">
                                    <h3>
                                        <?= htmlspecialchars($b['package_title']) ?>
                                    </h3>
                                    <span class="status-badge status-<?= $b['status'] ?>">
                                        <?= ucfirst($b['status']) ?>
                                    </span>
                                </div>

                                <div class="booking-card-meta">
                                    <span>
                                        <i class="fas fa-hashtag"></i>
                                        #<?= str_pad($b['id'],6,'0',STR_PAD_LEFT) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= htmlspecialchars($b['destination']) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar"></i>
                                        <?= date('d M Y',
                                            strtotime($b['travel_date'])) ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        <?= $b['duration_days'] ?> Days
                                    </span>
                                    <span>
                                        <i class="fas fa-users"></i>
                                        <?= $b['num_persons'] ?> person(s)
                                    </span>
                                </div>

                                <div class="booking-card-footer">
                                    <div class="booking-price">
                                        <span>Total:</span>
                                        <strong>
                                            <?= formatLKR($b['total_price']) ?>
                                        </strong>
                                        <span class="status-badge
                                              status-<?= $b['payment_status'] ?>">
                                            <?= ucfirst($b['payment_status']) ?>
                                        </span>
                                    </div>
                                    <div class="booking-actions">
                                        <?php if ($b['payment_status'] === 'unpaid'): ?>
                                        <a href="http://localhost/globetrek/index.php?url=payment/pay/<?= $b['id'] ?>"
                                           class="btn-primary btn-sm">
                                            <i class="fas fa-credit-card"></i>
                                            Pay Now
                                        </a>
                                        <?php endif; ?>

                                        <?php if ($b['status'] === 'pending'): ?>
                                        <a href="http://localhost/globetrek/index.php?url=booking/cancel/<?= $b['id'] ?>"
                                           class="btn-sm btn-danger"
                                           onclick="return confirm('Cancel this booking?')">
                                            <i class="fas fa-times"></i>
                                            Cancel
                                        </a>
                                        <?php endif; ?>

                                        <?php if ($b['payment_status'] === 'paid'): ?>
                                        <span style="color:var(--success);
                                                     font-weight:700;
                                                     font-size:0.85rem;">
                                            <i class="fas fa-check-circle"></i>
                                            Paid
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- BOTTOM ROW — ACCOMMODATION & TRANSPORT -->
                        <div style="padding:1rem 1.2rem;
                                    border-top:1px solid #eee;
                                    background:#f9f9fc;">

                            <div style="display:grid;
                                        grid-template-columns:1fr 1fr;
                                        gap:1rem;">

                                <!-- ACCOMMODATION -->
                                <div style="background:white;
                                            padding:0.9rem 1rem;
                                            border-radius:8px;
                                            border:1px solid #eee;
                                            border-left:4px solid var(--blue);">
                                    <p style="font-weight:700;
                                               color:var(--navy);
                                               margin-bottom:0.5rem;
                                               font-size:0.9rem;">
                                        <i class="fas fa-hotel"
                                           style="color:var(--blue);
                                                  margin-right:6px;"></i>
                                        Accommodation
                                    </p>

                                    <?php if (!empty($b['hotel_name'])): ?>
                                    <p style="font-size:0.88rem;
                                               color:var(--dark);
                                               margin-bottom:0.3rem;">
                                        <strong>
                                            <?= htmlspecialchars($b['hotel_name']) ?>
                                        </strong>
                                    </p>
                                    <?php if (!empty($b['hotel_contact'])): ?>
                                    <p style="font-size:0.82rem;
                                               color:var(--grey);">
                                        <i class="fas fa-phone-alt"
                                           style="margin-right:4px;"></i>
                                        <a href="tel:<?= htmlspecialchars($b['hotel_contact']) ?>"
                                           style="color:var(--blue);">
                                            <?= htmlspecialchars($b['hotel_contact']) ?>
                                        </a>
                                    </p>
                                    <?php endif; ?>
                                    <span class="status-badge
                                          status-<?= $b['hotel_status'] ?>"
                                          style="margin-top:0.4rem;
                                                 display:inline-block;">
                                        <?= ucfirst($b['hotel_status']) ?>
                                    </span>

                                    <?php else: ?>
                                    <p style="font-size:0.85rem;
                                               color:var(--grey);
                                               font-style:italic;">
                                        <i class="fas fa-clock"
                                           style="margin-right:4px;"></i>
                                        Arranged by our team
                                    </p>
                                    <?php endif; ?>
                                </div>

                                <!-- TRANSPORT -->
                                <div style="background:white;
                                            padding:0.9rem 1rem;
                                            border-radius:8px;
                                            border:1px solid #eee;
                                            border-left:4px solid var(--gold);">
                                    <p style="font-weight:700;
                                               color:var(--navy);
                                               margin-bottom:0.5rem;
                                               font-size:0.9rem;">
                                        <i class="fas fa-bus"
                                           style="color:var(--gold);
                                                  margin-right:6px;"></i>
                                        Transport
                                    </p>

                                    <?php if (!empty($b['transport_type'])): ?>
                                    <p style="font-size:0.88rem;
                                               color:var(--dark);
                                               margin-bottom:0.3rem;">
                                        <strong>
                                            <?= htmlspecialchars($b['transport_type']) ?>
                                        </strong>
                                    </p>
                                    <?php if (!empty($b['transport_contact'])): ?>
                                    <p style="font-size:0.82rem;
                                               color:var(--grey);">
                                        <i class="fas fa-phone-alt"
                                           style="margin-right:4px;"></i>
                                        <a href="tel:<?= htmlspecialchars($b['transport_contact']) ?>"
                                           style="color:var(--blue);">
                                            <?= htmlspecialchars($b['transport_contact']) ?>
                                        </a>
                                    </p>
                                    <?php endif; ?>
                                    <span class="status-badge
                                          status-<?= $b['transport_status'] ?>"
                                          style="margin-top:0.4rem;
                                                 display:inline-block;">
                                        <?= ucfirst($b['transport_status']) ?>
                                    </span>

                                    <?php else: ?>
                                    <p style="font-size:0.85rem;
                                               color:var(--grey);
                                               font-style:italic;">
                                        <i class="fas fa-clock"
                                           style="margin-right:4px;"></i>
                                        Arranged by our team
                                    </p>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </div>

                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-suitcase"></i>
                    <p>Booking is empty!</p>
                    <a href="http://localhost/globetrek/index.php?url=package/index"
                       class="btn-primary">
                        <i class="fas fa-search"></i>
                        Browse Packages
                    </a>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
