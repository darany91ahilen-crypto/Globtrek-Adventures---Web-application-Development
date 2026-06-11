<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="payment-layout">

            <!-- LEFT - PAYMENT FORM -->

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?= $success ?>
                        <br><br>
                        <a href="http://localhost/globetrek/index.php?url=customer/mybookings"
                           class="btn-primary">
                            <i class="fas fa-list"></i>
                            View My Bookings
                        </a>
                    </div>

                <?php else: ?>

                <!-- FORM STARTS HERE -->
                <form method="POST"
                      action="http://localhost/globetrek/index.php?url=payment/pay/<?= $booking['id'] ?>">

                    <!-- CARD TYPE - INSIDE FORM -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-credit-card"
                               style="color:var(--blue);
                                      margin-right:5px;"></i>
                            Visa Card 
                        </label>
                        <div class="card-type-selector">

                            <label class="card-type-option">
                                <input type="radio"
                                       name="card_type"
                                       value="visa"
                                       required>
                                <span class="card-type-btn visa-btn">
                                    <i class="fab fa-cc-visa"></i>
                                    VISA
                                </span>
                                    </label>
                        </div>
                    </div>

                    <!-- CARDHOLDER NAME -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-user"
                               style="color:var(--blue);
                                      margin-right:5px;"></i>
                            Cardholder Name
                        </label>
                        <input type="text"
                               name="card_name"
                               placeholder="Name on card"
                               required>
                    </div>

                    <!-- CARD NUMBER -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-credit-card"
                               style="color:var(--blue);
                                      margin-right:5px;"></i>
                            Card Number
                        </label>
                        <input type="text"
                               name="card_number"
                               placeholder="1234 5678 9012 3456"
                               maxlength="19"
                               required>
                    </div>

                    <!-- EXPIRY AND CVV -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-calendar-alt"
                                   style="color:var(--blue);
                                          margin-right:5px;"></i>
                                Expiry Date
                            </label>
                            <input type="text"
                                   name="expiry"
                                   placeholder="MM/YY"
                                   maxlength="5"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>
                                <i class="fas fa-lock"
                                   style="color:var(--blue);
                                          margin-right:5px;"></i>
                                CVV
                            </label>
                            <input type="password"
                                   name="cvv"
                                   maxlength="4"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary btn-full">
                        <i class="fas fa-lock"></i>
                        Pay <?= formatLKR($booking['total_price']) ?>
                    </button>

                </form>
                <!-- FORM ENDS HERE -->

                <?php endif; ?>

            </div>

            <!-- RIGHT - ORDER SUMMARY -->
            <div class="payment-summary">

                <h3>
                    <i class="fas fa-receipt"
                       style="color:var(--blue);
                              margin-right:8px;"></i>
                    Order Summary
                </h3>

                <p style="font-weight:700;color:var(--navy);
                           font-size:1rem;margin-bottom:1rem;">
                    <?= htmlspecialchars($booking['package_title']) ?>
                </p>

                <p>
                    <i class="fas fa-map-marker-alt"
                       style="color:var(--blue);
                              margin-right:8px;"></i>
                    <?= htmlspecialchars($booking['destination']) ?>
                </p>

                <p>
                    <i class="fas fa-calendar"
                       style="color:var(--blue);
                              margin-right:8px;"></i>
                    <?= date('d M Y',
                        strtotime($booking['travel_date'])) ?>
                </p>

                <p>
                    <i class="fas fa-users"
                       style="color:var(--blue);
                              margin-right:8px;"></i>
                    <?= $booking['num_persons'] ?> person(s)
                </p>

                <hr style="margin:1rem 0;border-color:#eee;">

                <div class="total-line">
                    <span style="font-weight:600;color:var(--grey);">
                        Total Amount
                    </span>
                    <strong style="color:var(--navy);font-size:1.3rem;">
                        <?= formatLKR($booking['total_price']) ?>
                    </strong>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>