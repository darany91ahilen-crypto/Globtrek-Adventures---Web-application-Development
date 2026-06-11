<?php require_once 'views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <h2>Book: <?= htmlspecialchars($package['title']) ?></h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="booking-form-layout">
            <form method="POST" class="booking-form">
                <div class="form-group">
                    <label>Travel Date</label>
                    <input type="date" name="travel_date" required 
                           min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                </div>
                <div class="form-group">
                    <label>Number of Persons</label>
                    <input type="number" name="num_persons" min="1" 
                           max="<?= $package['max_persons'] ?>" value="1" required>
                </div>
                <div class="form-group">
                    <label>Special Requests (Optional)</label>
                    <textarea name="special_requests" rows="4" 
                              placeholder="Any dietary requirements, accessibility needs..."></textarea>
                </div>
                <button type="submit" class="btn-primary btn-full">Confirm Booking</button>
            </form>
            <div class="booking-summary">
                <h3>Booking Summary</h3>
                <p><strong>Package:</strong> <?= htmlspecialchars($package['title']) ?></p>
                <p><strong>Destination:</strong> <?= htmlspecialchars($package['destination']) ?></p>
                <p><strong>Duration:</strong> <?= $package['duration_days'] ?> Days</p>
                <p><strong>Price per person:</strong> <?= formatLKR($package['price']) ?></p>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>