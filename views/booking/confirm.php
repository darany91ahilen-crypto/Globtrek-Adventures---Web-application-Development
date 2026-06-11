<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="confirm-card">

            <div class="confirm-header">
                <div style="width:70px;height:70px;
                            background:rgba(255,255,255,0.2);
                            border-radius:50%;
                            display:flex;align-items:center;
                            justify-content:center;
                            margin-bottom:1rem;">
                    <i class="fas fa-check"
                       style="font-size:2rem;color:white;"></i>
                </div>
                <h2 style="color:white;margin:0;font-size:1.6rem;">
                    Booking Confirmed!
                </h2>
                <p style="color:rgba(255,255,255,0.85);
                           margin:5px 0 0;font-size:1rem;">
                    Reference:
                    <strong>
                        #<?= str_pad($booking['id'], 6, '0', STR_PAD_LEFT) ?>
                    </strong>
                </p>
            </div>

            <div class="confirm-details">

                    <h1>Short note about your package</h1> 
                

                <div class="detail-row">
                    <span>
                        <i class="fas fa-suitcase"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Package
                    </span>
                    <strong>
                        <?= htmlspecialchars($booking['package_title']) ?>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>
                        <i class="fas fa-map-marker-alt"
                           style="color:var(--danger);
                                  margin-top:8px;"></i>
                        Destination
                    </span>
                    <span>
                        <?= htmlspecialchars($booking['destination']) ?>
                    </span>
                </div>

                <div class="detail-row">
                    <span>
                        <i class="fas fa-calendar"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Travel Date
                    </span>
                    <span>
                        <?= date('d M Y',
                            strtotime($booking['travel_date'])) ?>
                    </span>
                </div>

                <div class="detail-row">
                    <span>
                        <i class="fas fa-clock"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Duration
                    </span>
                    <span>
                        <?= $booking['duration_days'] ?> Days
                    </span>
                </div>

                <div class="detail-row">
                    <span>
                        <i class="fas fa-users"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Persons
                    </span>
                    <span>
                        <?= $booking['num_persons'] ?> person(s)
                    </span>
                </div>

                <?php if (!empty($booking['special_requests'])): ?>
                <div class="detail-row">
                    <span>
                        <i class="fas fa-sticky-note"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Special Requests
                    </span>
                    <span>
                        <?= htmlspecialchars(
                            $booking['special_requests']) ?>
                    </span>
                </div>
                <?php endif; ?>

                <div class="detail-row">
                    <span>
                        <i class="fas fa-info-circle"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Booking Status
                    </span>
                    <span class="status-badge
                          status-<?= $booking['status'] ?>">
                        <?= ucfirst($booking['status']) ?>
                    </span>
                </div>

                <div class="detail-row">
                    <span>
                        <i class="fas fa-credit-card"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Payment Status
                    </span>
                    <span class="status-badge
                          status-<?= $booking['payment_status'] ?>">
                        <?= ucfirst($booking['payment_status']) ?>
                    </span>
                </div>

                <div class="detail-row total-row"
                     style="border-top:2px solid #eee;
                            margin-top:0.5rem;
                            padding-top:1rem;">
                    <span style="font-size:1.1rem;font-weight:700;
                                  color:var(--navy);">
                        <i class="fas fa-rupee-sign"
                           style="color:var(--blue);
                                  margin-right:8px;"></i>
                        Total Amount
                    </span>
                    <strong style="font-size:1.4rem;color:var(--navy);">
                        <?= formatLKR($booking['total_price']) ?>
                    </strong>
                </div>

            </div>

            <div class="confirm-actions">

                <?php if ($booking['payment_status'] === 'unpaid'): ?>
                <a href="http://localhost/globetrek/index.php?url=payment/pay/<?= $booking['id'] ?>"
                   class="btn-primary"
                   style="flex:1;text-align:center;
                          display:flex;align-items:center;
                          justify-content:center;gap:8px;">
                    <i class="fas fa-credit-card"></i>
                    Pay Now
                </a>
                <?php endif; ?>

                <a href="http://localhost/globetrek/index.php?url=customer/mybookings"
                   class="btn-outline-main"
                   style="flex:1;text-align:center;
                          display:flex;align-items:center;
                          justify-content:center;gap:8px;">
                    <i class="fas fa-list"></i>
                    Back
                </a>

            </div>

        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>