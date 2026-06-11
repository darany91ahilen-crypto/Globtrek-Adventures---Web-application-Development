<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
<div class="container">
<div class="dashboard-layout">

<!-- SIDEBAR -->
<aside class="dashboard-sidebar">
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
        <a href="http://localhost/globetrek/index.php?url=staff/accommodations"
           class="active">
            <i class="fas fa-hotel"></i> Accommodations
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/coordination">
            <i class="fas fa-bus"></i> Hotel & Transport
        </a>
        <a href="http://localhost/globetrek/index.php?url=staff/guides">
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
        Accommodations
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
    <?php if ($editAccommodation): ?>
    <div class="edit-form-card">
        <h3>
            <i class="fas fa-edit"
               style="color:var(--blue);margin-right:8px;"></i>
            Edit: <?= htmlspecialchars($editAccommodation['name']) ?>
        </h3>
        <form method="POST"
              action="http://localhost/globetrek/index.php?url=staff/accommodations">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="acc_id"
                   value="<?= $editAccommodation['id'] ?>">

            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required
                           value="<?= htmlspecialchars($editAccommodation['name']) ?>">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" required
                           value="<?= htmlspecialchars($editAccommodation['location']) ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Type</label>
                    <select name="type">
                        <option value="hotel" <?= $editAccommodation['type']==='hotel' ? 'selected' : '' ?>>Hotel</option>
                        <option value="guesthouse" <?= $editAccommodation['type']==='guesthouse' ? 'selected' : '' ?>>Guesthouse</option>
                        <option value="resort" <?= $editAccommodation['type']==='resort' ? 'selected' : '' ?>>Resort</option>
                        <option value="villa" <?= $editAccommodation['type']==='villa' ? 'selected' : '' ?>>Villa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Price Per Night (Rs.)</label>
                    <input type="number" name="price_per_night" min="0" step="1"
                           value="<?= $editAccommodation['price_per_night'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"><?= htmlspecialchars($editAccommodation['description']) ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Max Guests</label>
                    <input type="number" name="max_guests" min="1"
                           value="<?= $editAccommodation['max_guests'] ?? 2 ?>">
                </div>
                <div class="form-group">
                    <label>Contact Phone</label>
                    <input type="text" name="contact_phone"
                           value="<?= htmlspecialchars($editAccommodation['contact_phone'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Amenities (comma separated)</label>
                <input type="text" name="amenities"
                       value="<?= htmlspecialchars($editAccommodation['amenities'] ?? '') ?>">
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="http://localhost/globetrek/index.php?url=staff/accommodations"
                   class="btn-outline-main">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <?php else: ?>

    <!-- ADD NEW -->
    <details class="collapsible">
        <summary>
            <i class="fas fa-plus"></i> Add New Accommodation
        </summary>
        <form method="POST"
              action="http://localhost/globetrek/index.php?url=staff/accommodations"
              class="package-form">
            <input type="hidden" name="action" value="create">

            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name"
                           placeholder="Kingsbury Hotel" required>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location"
                           placeholder="Colombo" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Type</label>
                    <select name="type">
                        <option value="hotel">Hotel</option>
                        <option value="guesthouse">Guesthouse</option>
                        <option value="resort">Resort</option>
                        <option value="villa">Villa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Price Per Night (Rs.)</label>
                    <input type="number" name="price_per_night"
                           min="0" step="1" placeholder="5000">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"
                          placeholder="About acc"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Max Guests</label>
                    <input type="number" name="max_guests"
                           min="1" placeholder="2">
                </div>
                <div class="form-group">
                    <label>Contact Phone</label>
                    <input type="text" name="contact_phone">
                </div>
                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="email" name="contact_email"
                           placeholder="hotel@gmail.com">
                </div>
            </div>

            <div class="form-group">
                <label>Amenities (comma separated)</label>
                <input type="text" name="amenities"
                       placeholder="WiFi, DJ, Bar, Restaurant">
            </div>
            <div class="form-group">
                <label>Accommodation Image</label>
                <input type="file" name="accommodation_image"
                       accept="image/*" class="file-input">
                <small style="color:var(--grey);font-size:0.8rem;">
                    <i class="fas fa-info-circle"></i>
                    JPG, PNG or WEBP - Max 2MB
                </small>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Add Accommodation
            </button>
        </form>
    </details>

    <?php endif; ?>

    <!-- TABLE -->
    <h3 style="margin-top:2rem;margin-bottom:1rem;">
        <i class="fas fa-list"
           style="color:var(--blue);margin-right:8px;"></i>
        All Accommodations
        <span style="font-size:0.9rem;color:var(--grey);
                     font-weight:400;margin-left:8px;">
            (<?= count($accommodations) ?> total)
        </span>
    </h3>

    <?php if (!empty($accommodations)): ?>
    <div style="overflow-x:auto;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Type</th>
                <th>Price/Night</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($accommodations as $accommodation): ?>
            <tr>
                <td>
                    <strong>
                        <?= htmlspecialchars($accommodation['name']) ?>
                    </strong>
                </td>
                <td>
                    <i class="fas fa-map-marker-alt"
                       style="color:var(--danger);margin-right:4px;"></i>
                    <?= htmlspecialchars($accommodation['location']) ?>
                </td>
                <td>
                    <span class="acc-type-badge
                          acc-<?= $accommodation['type'] ?>">
                        <?= ucfirst($accommodation['type']) ?>
                    </span>
                </td>
                <td>
                    <?= formatLKR($accommodation['price_per_night']) ?>
                </td>
                <td>
                    <div style="display:flex;gap:5px;">

                        <!-- EDIT -->
                        <a href="http://localhost/globetrek/index.php?url=staff/accommodations&edit=<?= $accommodation['id'] ?>"
                           class="btn-sm btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- DELETE -->
                        <form method="POST"
                              action="http://localhost/globetrek/index.php?url=staff/accommodations"
                              style="display:inline;">
                            <input type="hidden" name="action"
                                   value="delete">
                            <input type="hidden" name="acc_id"
                                   value="<?= $accommodation['id'] ?>">
                            <button type="submit"
                                    class="btn-sm btn-danger"
                                    onclick="return confirm(
                                        'Remove this accommodation?')">
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
        <i class="fas fa-hotel"></i>
        <p>No accommodations added yet.</p>
    </div>
    <?php endif; ?>

</div>
</div>
</div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>