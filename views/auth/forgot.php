
<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="auth-card">

            <h2>
                <i class="fas fa-key"
                   style="color:var(--blue);margin-right:8px;">
                </i>
                Reset Your Password
            </h2>

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
                </div>
            <?php else: ?>

            <p style="color:var(--grey);margin-bottom:1.5rem;font-size:0.95rem;">
                Enter your registered email address and we will
                send you a password reset OTP.
            </p>

            <form method="POST"
                  action="http://localhost/globetrek/index.php?url=auth/forgot"
                  autocomplete="off">

                <div class="form-group">
                    <label>
                        <i class="fas fa-envelope"
                           style="color:var(--blue);margin-right:5px;">
                        </i>
                        Email Address
                    </label>
                    <input type="email"
                           name="email"
                           placeholder="Enter your registered email"
                           required>
                </div>

                <button type="submit" class="btn-primary btn-full">
                    <i class="fas fa-paper-plane"></i>
                    Send Reset OTP
                </button>

            </form>

            <?php endif; ?>

            <p class="auth-link">
                Remember your password?
                <a href="http://localhost/globetrek/index.php?url=auth/login">
                    Login here
                </a>
            </p>

        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
