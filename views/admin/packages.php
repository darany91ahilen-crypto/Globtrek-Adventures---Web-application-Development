<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
<div class="container">
<div class="dashboard-layout">

<!-- SIDEBAR -->
 <aside class="dashboard-sidebar">
    
    <nav class="dash-nav">
        <a href="http://localhost/globetrek/index.php?url=admin/dashboard">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="http://localhost/globetrek/index.php?url=admin/bookings">
            <i class="fas fa-calendar-check"></i> All Bookings
        </a>
        <a href="http://localhost/globetrek/index.php?url=admin/packages"
           class="active">
            <i class="fas fa-suitcase"></i> Manage Packages
        </a>
        <a href="http://localhost/globetrek/index.php?url=admin/users">
            <i class="fas fa-users"></i> Manage Users
        </a>
        <a href="http://localhost/globetrek/index.php?url=admin/staff">
            <i class="fas fa-user-tie"></i> Manage Staff
        </a>
        <a href="http://localhost/globetrek/index.php?url=admin/reports">
            <i class="fas fa-chart-bar"></i> Reports
        </a>
        <a href="http://localhost/globetrek/index.php?url=auth/logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>

<!-- MAIN -->
<div class="dashboard-main">

    <h2>
        <i class="fas fa-suitcase"
           style="color:var(--blue);margin-right:8px;"></i>
        Manage Packages
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

    <!-- ADD NEW PACKAGE -->
    <?php if (!$editPackage): ?>
    <details class="collapsible">
        <summary>
            <i class="fas fa-plus"></i> Add New Package
        </summary>
        <form method="POST"
              action="http://localhost/globetrek/index.php?url=admin/packages"
              enctype="multipart/form-data"
              class="package-form">
            <input type="hidden" name="action" value="create">

            <div class="form-row">
                <div class="form-group">
                    <label>Package Title</label>
                    <input type="text" name="title"
                           placeholder="Norther Heritage View"
                           required>
                </div>
                <div class="form-group">
                    <label>Destination</label>
                    <input type="text" name="destination"
                           placeholder="Jaffna" required>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"
                          required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Duration (Days)</label>
                    <input type="number" name="duration_days"
                           min="1" placeholder="5" required>
                </div>
                <div class="form-group">
                    <label>Price Per Person (Rs.)</label>
                    <input type="number" name="price"
                           step="1" min="0"
                           placeholder="50000" required>
                </div>
                <div class="form-group">
                    <label>Max Persons</label>
                    <input type="number" name="max_persons"
                           min="1" placeholder="10" required>
                </div>
            </div>

            <div class="form-group">
                <label>What is Included (comma separated)</label>
                <input type="text" name="includes"
                       placeholder="Guide, Safari, etc...">
            </div>

            <div class="form-group">
                <label>Itinerary (one day per line)</label>
                <textarea name="itinerary" rows="5"
                          placeholder="Day 1: Safari&#10;Day 2: Return"></textarea>
            </div>

            <div class="form-group">
                <label>Package Image</label>
                <input type="file" name="package_image"
                       accept="image/*" class="file-input">
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Add
            </button>
        </form>
    </details>

    <?php else: ?>

    <!-- EDIT PACKAGE -->
    <div class="edit-form-card">
        <h3>
            <i class="fas fa-edit"
               style="color:var(--blue);margin-right:8px;"></i>
            Edit: <?= htmlspecialchars($editPackage['title']) ?>
        </h3>
        <form method="POST"
              action="http://localhost/globetrek/index.php?url=admin/packages"
              enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="package_id"
                   value="<?= $editPackage['id'] ?>">

            <div class="form-row">
                <div class="form-group">
                    <label>Package Title</label>
                    <input type="text" name="title" required
                           value="<?= htmlspecialchars($editPackage['title']) ?>">
                </div>
                <div class="form-group">
                    <label>Destination</label>
                    <input type="text" name="destination" required
                           value="<?= htmlspecialchars($editPackage['destination']) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3" required><?= htmlspecialchars($editPackage['description']) ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Duration (Days)</label>
                    <input type="number" name="duration_days" min="1" required
                           value="<?= $editPackage['duration_days'] ?>">
                </div>
                <div class="form-group">
                    <label>Price Per Person (Rs.)</label>
                    <input type="number" name="price" step="1" min="0" required
                           value="<?= $editPackage['price'] ?>">
                </div>
                <div class="form-group">
                    <label>Max Persons</label>
                    <input type="number" name="max_persons" min="1" required
                           value="<?= $editPackage['max_persons'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label>What is Included</label>
                <input type="text" name="includes"
                       value="<?= htmlspecialchars($editPackage['includes']) ?>">
            </div>

            <div class="form-group">
                <label>Itinerary</label>
                <textarea name="itinerary" rows="5"><?= htmlspecialchars($editPackage['itinerary']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Current Image</label>
                <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($editPackage['image']) ?>"
                     onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'"
                     style="width:120px;height:80px;object-fit:cover;
                            border-radius:6px;display:block;
                            margin-bottom:8px;">
                <label>Upload New Image (optional)</label>
                <input type="file" name="package_image"
                       accept="image/*" class="file-input">
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="http://localhost/globetrek/index.php?url=admin/packages"
                   class="btn-outline-main">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <?php if (!empty($packages)): ?>
    <div style="overflow-x:auto;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Destination</th>
                <th>Duration</th>
                <th>Price</th>
                <th>Max</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($packages as $package): ?>
            <tr>
                <td>
                    <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($package['image']) ?>"
                         onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'"
                         style="width:65px;height:48px;
                                object-fit:cover;border-radius:5px;">
                </td>
                <td>
                    <strong><?= htmlspecialchars($package['title']) ?></strong>
                    <br>
                    <small style="color:var(--grey);">
                        <?= substr(htmlspecialchars($package['description']),0,40) ?>...
                    </small>
                </td>
                <td>
                    <i class="fas fa-map-marker-alt"
                       style="color:var(--danger);margin-right:4px;"></i>
                    <?= htmlspecialchars($package['destination']) ?>
                </td>
                <td>
                    <i class="fas fa-clock"
                       style="color:var(--blue);margin-right:4px;"></i>
                    <?= $package['duration_days'] ?> Days
                </td>
                <td>
                    <strong>
                        <?= formatLKR($package['price']) ?>
                    </strong>
                </td>
                <td>
                    <i class="fas fa-users"
                       style="color:var(--grey);margin-right:4px;"></i>
                    <?= $package['max_persons'] ?>
                </td>
                <td>
                    <form method="POST"
                          action="http://localhost/globetrek/index.php?url=admin/packages"
                          style="display:inline;">
                        <input type="hidden" name="action"
                               value="toggle_featured">
                        <input type="hidden" name="package_id"
                               value="<?= $package['id'] ?>">
                        <input type="hidden" name="featured"
                               value="<?= $package['featured'] ? 0 : 1 ?>">
                        <button type="submit"
                                class="<?= $package['featured']
                                    ? 'btn-featured-on'
                                    : 'btn-featured-off' ?>">
                            <i class="fas fa-star"></i>
                            <?= $package['featured']
                                ? 'Featured' : 'Set Featured' ?>
                        </button>
                    </form>
                </td>
                <td>
                    <div style="display:flex;gap:5px;flex-wrap:wrap;">

                        <!-- EDIT BUTTON -->
                        <a href="http://localhost/globetrek/index.php?url=admin/packages&edit=<?= $package['id'] ?>"
                           class="btn-sm btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- DELETE BUTTON -->
                        <form method="POST"
                              action="http://localhost/globetrek/index.php?url=admin/packages"
                              style="display:inline;">
                            <input type="hidden" name="action"
                                   value="delete">
                            <input type="hidden" name="package_id"
                                   value="<?= $package['id'] ?>">
                            <button type="submit"
                                    class="btn-sm btn-danger"
                                    onclick="return confirm(
                                        'Remove this package?')">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-suitcase"></i>
        <p>No packages found.</p>
    </div>
    <?php endif; ?>

</div>
</div>
</div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>