<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="page-intro">
    <div class="container page-intro-inner">
        <h1>Travel Guides</h1>
        <p>Expert tips for your Sri Lanka adventure</p>
        <nav class="breadcrumb">
            <a href="http://localhost/globetrek/index.php">
                <i class="fas fa-home"></i> Home
            </a>
            <span><i class="fas fa-chevron-right"></i></span>
            <span>Travel Guides</span>
        </nav>
    </div>
</section>

<section class="section">
    <div class="container">

        <h2 class="section-title">Destination Guides</h2>

        <?php if (!empty($guides)): ?>
        <div class="card-grid">
            <?php foreach ($guides as $guide): ?>
            <?php
                $guideImages = [
                    'kandy' => 'kandy.jpeg',
                    'colombo' => 'colombo.jpeg',
                
                ];
                $destinationKey = strtolower(trim($guide['destination']));
                $guideImage = $guideImages[$destinationKey] ?? null;
            ?>
            <div class="card">
                <?php if ($guideImage): ?>
                    <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($guideImage) ?>"
                         alt="<?= htmlspecialchars($guide['destination']) ?>">
                <?php else: ?>
                    <div style="width:100%;height:200px;
                        background:linear-gradient(135deg,#1B3A6B,#2E75B6);
                        display:flex;align-items:center;
                        justify-content:center;">
                        <i class="fas fa-map-marked-alt"
                           style="font-size:4rem;color:rgba(255,255,255,0.4);"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($guide['destination']) ?>
                    </span>
                    <h3><?= htmlspecialchars($guide['title']) ?></h3>
                    <p>
                        <?= substr(htmlspecialchars($guide['content']),
                                   0, 100) ?>...
                    </p>
                    <div class="card-meta">
                        <span class="meta-item">
                            <i class="fas fa-sun"></i>
                            Best: <?= htmlspecialchars(
                                $guide['best_time'] ?? 'Year round') ?>
                        </span>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/globetrek/index.php?url=home/guide_detail/<?= $guide['id'] ?>"
                           class="btn-view">
                            <i class="fas fa-book-open"></i>
                            Read Guide
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-book"></i>
            <p>No travel guides available yet.</p>
        </div>
        <?php endif; ?>

    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>