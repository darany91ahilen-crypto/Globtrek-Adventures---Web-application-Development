<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="about-layout">

            <span class="badge">
                <i class="fas fa-map-marker-alt"></i>
                <?= htmlspecialchars($guide['destination']) ?>
            </span>

            <h1 style="color:var(--navy);margin:0.8rem 0;
                        font-size:2rem;">
                <?= htmlspecialchars($guide['title']) ?>
            </h1>

            <?php if (!empty($guide['best_time'])): ?>
            <p style="color:var(--grey);margin-bottom:1.5rem;">
                <i class="fas fa-sun"
                   style="color:var(--gold);margin-right:8px;"></i>
                <strong>Best Time to Visit:</strong>
                <?= htmlspecialchars($guide['best_time']) ?>
            </p>
            <?php endif; ?>

            <hr style="border-color:#eee;margin:1.5rem 0;">

            <div class="about-text">
                <h3>
                    <i class="fas fa-info-circle"
                       style="color:var(--blue);margin-right:8px;"></i>
                    About This Destination
                </h3>
                <p><?= nl2br(htmlspecialchars($guide['content'])) ?></p>

                <?php if (!empty($guide['tips'])): ?>
                <h3>
                    <i class="fas fa-lightbulb"
                       style="color:var(--gold);margin-right:8px;"></i>
                    Travel Tips
                </h3>
                <p><?= nl2br(htmlspecialchars($guide['tips'])) ?></p>
                <?php endif; ?>
            </div>

            <div style="margin-top:2rem;">
                <a href="http://localhost/globetrek/index.php?url=home/guides"
                   class="btn-outline-main">
                    <i class="fas fa-arrow-left"></i>
                    Back to Guides
                </a>
                <a href="http://localhost/globetrek/index.php?url=package/index"
                   class="btn-primary"
                   style="margin-left:1rem;">
                    <i class="fas fa-suitcase"></i>
                    View Packages
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>