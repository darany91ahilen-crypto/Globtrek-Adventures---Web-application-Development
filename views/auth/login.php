<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section auth-section auth-login-section">
    <div class="container">
        <div class="auth-card">

            <h2>
                Login to Your Account
            </h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST"
                  action="http://localhost/globetrek/index.php?url=auth/login"
                  autocomplete="off">

                <!-- CSRF TOKEN -->
                <input type="hidden"
                       name="csrf_token"
                       value="<?= isset($_SESSION['csrf_token'])
                                   ? htmlspecialchars($_SESSION['csrf_token'])
                                   : '' ?>">

                <div class="form-group">
                    <label>
                        Email Address
                    </label>
                    <input type="text"
                           name="email"
                           id="loginEmail"
                           placeholder="Enter your email address"
                           autocomplete="off"
                           spellcheck="false"
                           required>
                </div>

                <div class="form-group">
                    <label>
                        Password
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password"
                               name="password"
                               id="loginPassword"
                               placeholder="Enter your password"
                               autocomplete="new-password"
                               required>
                        <button type="button"
                                class="password-toggle"
                                onclick="togglePassword('loginPassword', this)"
                                tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <a href="http://localhost/globetrek/index.php?url=auth/forgot"
                   class="forgot-link">
                    <i class="fas fa-unlock-keyhole"></i>
                    Forgot your password?
                </a>

                <button type="submit" class="btn-primary btn-full">
                    Login
                </button>

            </form>

            <p class="auth-link">
                Don't have an account?
                <a href="http://localhost/globetrek/index.php?url=auth/register">
                    Register here
                </a>
            </p>

        </div>
    </div>
</section>

<script>
window.onload = function() {
    document.getElementById('loginEmail').value    = '';
    document.getElementById('loginPassword').value = '';
}

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
