<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="auth-card">

            <h2>
                <i class="fas fa-lock"
                   style="color:var(--blue);margin-right:8px;">
                </i>
                Set New Password
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
                    <?= htmlspecialchars($success) ?>
                    <br><br>
                    <a href="http://localhost/globetrek/index.php?url=auth/login"
                       class="btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        Login Now
                    </a>
                </div>
            <?php else: ?>

            <form method="POST"
                  autocomplete="off">

                <div class="form-group">
                    <label>
                        <i class="fas fa-lock"
                           style="color:var(--blue);margin-right:5px;">
                        </i>
                        New Password
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password"
                               name="password"
                               id="newPassword"
                               placeholder="Enter new password"
                               autocomplete="new-password"
                               required>
                        <button type="button"
                                class="password-toggle"
                                onclick="togglePassword('newPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-rules">
                        <p><i class="fas fa-check-circle"></i> Minimum 8 characters</p>
                        <p><i class="fas fa-check-circle"></i> At least one uppercase letter</p>
                        <p><i class="fas fa-check-circle"></i> At least one number</p>
                        <p><i class="fas fa-check-circle"></i> At least one special character</p>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-lock"
                           style="color:var(--blue);margin-right:5px;">
                        </i>
                        Confirm New Password
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password"
                               name="confirm_password"
                               id="confirmPassword"
                               placeholder="Confirm new password"
                               autocomplete="new-password"
                               required>
                        <button type="button"
                                class="password-toggle"
                                onclick="togglePassword('confirmPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary btn-full">
                    <i class="fas fa-save"></i>
                    Reset Password
                </button>

            </form>

            <?php endif; ?>

        </div>
    </div>
</section>

<script>
function togglePassword(fieldId, btn) {
    var field = document.getElementById(fieldId);
    var icon  = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        btn.style.color = '#1B3A6B';
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        btn.style.color = '#999999';
    }
}
</script>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>