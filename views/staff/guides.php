<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
<div class="container">
<div class="dashboard-layout">

<!-- SIDEBAR -->
<aside class="dashboard-sidebar">
    <div class="user-info">
        <div class="dash-avatar">
            <i class="fas fa-user-tie"></i>
        </div>
        <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>
        <small>Staff Member</small>
    </div>
    <nav class="dash-nav">
        <a href="http://localhost/globetrek/index.php?url=staff/dashboard">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/bookings">
            <i class="fas fa-calendar-check"></i> Manage Bookings
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/packages">
            <i class="fas fa-suitcase"></i> Manage Packages
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/accommodations">
            <i class="fas fa-hotel"></i> Accommodations
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/coordination">
            <i class="fas fa-bus"></i> Hotel & Transport
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/guides"
           class="active">
            <i class="fas fa-book"></i> Travel Guides
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/queries">
            <i class="fas fa-comments"></i> Customer Queries
        </a>
        <a href="http://localhost/globetrek/index.php?url=auth/logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>

<!-- MAIN -->
<div class="dashboard-main">

    <h2>
        <i class="fas fa-book"
           style="color:var(--blue);margin-right:8px;"></i>
        Manage Travel Guides
    </h2>

    <?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?= htmlspecialchars($success) ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <!-- EDIT FORM -->
    <?php if ($editGuide): ?>
    <div class="edit-form-card">
        <h3>
            <i class="fas fa-edit"
               style="color:var(--blue);margin-right:8px;"></i>
            Edit: <?= htmlspecialchars($editGuide['title']) ?>
        </h3>
        <form method="POST"
              action="http://localhost/globetrek/index.php?url=staff/guides">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="guide_id"
                   value="<?= $editGuide['id'] ?>">

            <div class="form-row">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" required
                           value="<?= htmlspecialchars($editGuide['title']) ?>">
                </div>
                <div class="form-group">
                    <label>Destination</label>
                    <input type="text" name="destination" required
                           value="<?= htmlspecialchars($editGuide['destination']) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" rows="5" required><?= htmlspecialchars($editGuide['content']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Travel Tips</label>
                <textarea name="tips" rows="3"><?= htmlspecialchars($editGuide['tips'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Best Time to Visit</label>
                <input type="text" name="best_time"
                       value="<?= htmlspecialchars($editGuide['best_time'] ?? '') ?>">
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="http://localhost/globetrek/index.php?url=staff/guides"
                   class="btn-outline-main">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <?php else: ?>

    <!-- ADD NEW GUIDE -->
    <details class="collapsible">
        <summary>
            <i class="fas fa-plus"></i> Add New Guide
        </summary>
        <form method="POST"
              action="http://localhost/globetrek/index.php?url=staff/guides"
              class="package-form">
            <input type="hidden" name="action" value="create">

            <div class="form-row">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title"
                           placeholder="e.g. Sigiriya Rock Guide" required>
                </div>
                <div class="form-group">
                    <label>Destination</label>
                    <input type="text" name="destination"
                           placeholder="e.g. Sigiriya" required>
                </div>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" rows="5"
                          placeholder="Describe the destination..."
                          required></textarea>
            </div>

            <div class="form-group">
                <label>Travel Tips</label>
                <textarea name="tips" rows="3"
                          placeholder="Useful tips for visitors..."></textarea>
            </div>

            <div class="form-group">
                <label>Best Time to Visit</label>
                <input type="text" name="best_time"
                       placeholder="e.g. January to April">
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Add Guide
            </button>
        </form>
    </details>

    <?php endif; ?>

    <!-- GUIDES TABLE -->
    <h3 style="margin-top:2rem;margin-bottom:1rem;">
        <i class="fas fa-list"
           style="color:var(--blue);margin-right:8px;"></i>
        All Guides
        <span style="font-size:0.9rem;color:var(--grey);
                     font-weight:400;margin-left:8px;">
            (<?= count($guides) ?> total)
        </span>
    </h3>

    <?php if (!empty($guides)): ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Destination</th>
                <th>Best Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($guides as $guide): ?>
            <tr>
                <td>
                    <strong>
                        <?= htmlspecialchars($guide['title']) ?>
                    </strong>
                    <br>
                    <small style="color:var(--grey);">
                        <?= substr(htmlspecialchars(
                            $guide['content']), 0, 50) ?>...
                    </small>
                </td>
                <td>
                    <i class="fas fa-map-marker-alt"
                       style="color:var(--danger);margin-right:4px;"></i>
                    <?= htmlspecialchars($guide['destination']) ?>
                </td>
                <td>
                    <i class="fas fa-sun"
                       style="color:var(--gold);margin-right:4px;"></i>
                    <?= htmlspecialchars(
                        $guide['best_time'] ?? 'Year round') ?>
                </td>
                <td>
                    <div style="display:flex;gap:5px;">

                        <!-- EDIT -->
                        <a href="http://localhost/globetrek/index.php?url=staff/guides&edit=<?= $guide['id'] ?>"
                           class="btn-sm btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- DELETE -->
                        <form method="POST"
                              action="http://localhost/globetrek/index.php?url=staff/guides"
                              style="display:inline;">
                            <input type="hidden" name="action"
                                   value="delete">
                            <input type="hidden" name="guide_id"
                                   value="<?= $guide['id'] ?>">
                            <button type="submit"
                                    class="btn-sm btn-danger"
                                    onclick="return confirm(
                                        'Remove this guide?')">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-book"></i>
        <p>No travel guides added yet.</p>
    </div>
    <?php endif; ?>

</div>
</div>
</div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>