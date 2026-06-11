<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section auth-section auth-register-section">
    <div class="container">
        <div class="auth-card">

            <h2>
                Create Your Account
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
                    <a href="<?= BASE_URL ?>/index.php?url=auth/login"
                       class="btn-primary">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        Login Now
                    </a>
                </div>
            <?php else: ?>

            <form method="POST"
                  action="<?= BASE_URL ?>/index.php?url=auth/register"
                  autocomplete="off">

                <!-- ✅ CSRF Token Fix -->
                <input type="hidden"
                       name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

                <div class="form-group">
                    <label>
                        Full Name
                    </label>
                    <input type="text"
                           name="full_name"
                           placeholder="Enter your full name"
                           autocomplete="off"
                           required
                           value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>
                        Email Address
                    </label>
                    <input type="email"
                           name="email"
                           placeholder="Enter your email address"
                           autocomplete="off"
                           required
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>
                        Phone Number
                    </label>
                    <input type="tel"
                           name="phone"
                           placeholder="0771234567"
                           autocomplete="off"
                           pattern="[0-9]{10}"
                           maxlength="10"
                           minlength="10"
                           value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                    <small style="color:var(--grey);font-size:0.8rem;
                                  display:block;margin-top:3px;">
                        Must be 10 digits
                    </small>
                </div>

                <div class="form-group">
                    <label>
                        Password
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password"
                               name="password"
                               id="regPassword"
                               placeholder="Create a strong password"
                               autocomplete="new-password"
                               required
                               minlength="8"
                               oninput="checkPasswordStrength(this.value)">
                        <button type="button"
                                class="password-toggle"
                                onclick="togglePassword('regPassword', this)"
                                tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <div class="strength-bar-wrapper">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <small id="strengthText"
                           style="font-size:0.8rem;color:var(--grey);
                                  display:block;margin-bottom:8px;"></small>

                    <div class="password-rules">
                        <p id="rule-length">
                            <i class="fas fa-times-circle" style="color:#ccc;"></i>
                            Minimum 8 characters
                        </p>
                        <p id="rule-upper">
                            <i class="fas fa-times-circle" style="color:#ccc;"></i>
                            At least one uppercase letter
                        </p>
                        <p id="rule-number">
                            <i class="fas fa-times-circle" style="color:#ccc;"></i>
                            At least one number
                        </p>
                        <p id="rule-special">
                            <i class="fas fa-times-circle" style="color:#ccc;"></i>
                            At least one special character
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        Confirm Password
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password"
                               name="confirm_password"
                               id="regConfirm"
                               placeholder="Repeat your password"
                               autocomplete="new-password"
                               required>
                        <button type="button"
                                class="password-toggle"
                                onclick="togglePassword('regConfirm', this)"
                                tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <small id="matchText"
                           style="font-size:0.8rem;display:block;
                                  margin-top:4px;"></small>
                </div>

                <button type="submit" class="btn-primary btn-full">
                    Create Account
                </button>
                

            </form>

            <?php endif; ?>

            <p class="auth-link">
                Already have an account?
                <a href="<?= BASE_URL ?>/index.php?url=auth/login">
                    Login here
                </a>
            </p>

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

function checkPasswordStrength(password) {
    var bar       = document.getElementById('strengthBar');
    var text      = document.getElementById('strengthText');
    var ruleLen   = document.getElementById('rule-length');
    var ruleUpper = document.getElementById('rule-upper');
    var ruleNum   = document.getElementById('rule-number');
    var ruleSpec  = document.getElementById('rule-special');

    var hasLength  = password.length >= 8;
    var hasUpper   = /[A-Z]/.test(password);
    var hasNumber  = /[0-9]/.test(password);
    var hasSpecial = /[^A-Za-z0-9]/.test(password);

    updateRule(ruleLen,   hasLength);
    updateRule(ruleUpper, hasUpper);
    updateRule(ruleNum,   hasNumber);
    updateRule(ruleSpec,  hasSpecial);

    var strength = [hasLength, hasUpper, hasNumber, hasSpecial]
                   .filter(Boolean).length;

    var colors = ['#D32F2F','#F57C00','#FBC02D','#388E3C'];
    var labels = ['Weak','Fair','Good','Strong'];
    var widths = ['25%','50%','75%','100%'];

    if (password.length === 0) {
        bar.style.width  = '0%';
        text.textContent = '';
    } else {
        bar.style.width      = widths[strength-1] || '25%';
        bar.style.background = colors[strength-1] || '#D32F2F';
        text.textContent     = labels[strength-1] || 'Weak';
        text.style.color     = colors[strength-1] || '#D32F2F';
    }
    checkMatch(password, document.getElementById('regConfirm').value);
}

function updateRule(element, passed) {
    var icon = element.querySelector('i');
    if (passed) {
        icon.className      = 'fas fa-check-circle';
        icon.style.color    = '#388E3C';
        element.style.color = '#388E3C';
    } else {
        icon.className      = 'fas fa-times-circle';
        icon.style.color    = '#ccc';
        element.style.color = '#666';
    }
}

function checkMatch(password, confirm) {
    var matchText = document.getElementById('matchText');
    if (confirm.length === 0) {
        matchText.textContent = '';
        return;
    }
    if (password === confirm) {
        matchText.textContent = ' Passwords match';
        matchText.style.color = '#388E3C';
    } else {
        matchText.textContent = ' Passwords do not match';
        matchText.style.color = '#D32F2F';
    }
}

document.getElementById('regConfirm').addEventListener('input', function() {
    checkMatch(document.getElementById('regPassword').value, this.value);
});
</script>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>