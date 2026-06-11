<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="page-banner">
    <div class="banner-overlay">
        <div class="banner-content">
            <h1>Contact Us</h1>
            <nav class="breadcrumb">
                <a href="http://localhost/globetrek/index.php">
                    Home
                </a>
                <span>&rsaquo;</span>
                <span>Contact</span>
            </nav>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-layout contact-layout-form-only">
            <div class="contact-form">
                <h3>Send Us a Message</h3>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text"
                               name="name"
                               placeholder="Enter your full name"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email"
                               name="email"
                               placeholder="Enter your email address"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text"
                               name="subject"
                               placeholder="What is your query about?"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message"
                                  rows="5"
                                  placeholder="Write your message here..."
                                  required></textarea>
                    </div>

                    <button type="submit" class="btn-primary btn-full">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
