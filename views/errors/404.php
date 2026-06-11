<?php 
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}
require_once BASE_PATH . '/views/layouts/header.php';
?>
<section class="section">
    <div class="container">
        <div class="error-page">
            <div class="error-code">404</div>
            <h2>Page Not Found</h2>
            <p>Sorry, the page you are looking for does not exist.</p>
            <a href="http://localhost/globetrek/index.php"
               class="btn-primary">
                <i class="fas fa-home"></i>
                Go Back Home
            </a>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>