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
                    <a href="http://localhost/globetrek/index.php?url=staff/packages"
                       class="active">
                        <i class="fas fa-suitcase"></i> Manage Packages
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/accommodations">
                        <i class="fas fa-hotel"></i> Accommodations
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/coordination">
                        <i class="fas fa-bus"></i> Hotel & Transport
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

                <!-- EDIT FORM -->
                <?php if ($editPackage): ?>
                <div class="edit-form-card">
                    <h3>
                        <i class="fas fa-edit"
                           style="color:var(--blue);margin-right:8px;"></i>
                        Edit Package —
                        <?= htmlspecialchars($editPackage['title']) ?>
                    </h3>

                    <form method="POST"
                          action="http://localhost/globetrek/index.php?url=staff/packages"
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
                                <input type="number" name="duration_days"
                                       min="1" required
                                       value="<?= $editPackage['duration_days'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Price Per Person (Rs.)</label>
                                <input type="number" name="price"
                                       step="1" min="0" required
                                       value="<?= $editPackage['price'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Max Persons</label>
                                <input type="number" name="max_persons"
                                       min="1" required
                                       value="<?= $editPackage['max_persons'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>What is Included (comma separated)</label>
                            <input type="text" name="includes"
                                   value="<?= htmlspecialchars($editPackage['includes']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Itinerary (one day per line)</label>
                            <textarea name="itinerary" rows="6"><?= htmlspecialchars($editPackage['itinerary']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Current Image</label>
                            <div style="margin-bottom:0.8rem;">
                                <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($editPackage['image']) ?>"
                                     alt="current"
                                     onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'"
                                     style="width:120px;height:80px;
                                            object-fit:cover;border-radius:6px;
                                            border:2px solid #dde6f5;">
                            </div>
                            <label>Upload New Image (optional)</label>
                            <input type="file" name="package_image"
                                   accept="image/*" class="file-input">
                            <small style="color:var(--grey);font-size:0.8rem;">
                                <i class="fas fa-info-circle"></i>
                                Leave empty to keep current image
                            </small>
                        </div>

                        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Save Changes
                            </button>
                            <a href="http://localhost/globetrek/index.php?url=staff/packages"
                               class="btn-outline-main">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <?php else: ?>

                <!-- ADD NEW PACKAGE -->
                <details class="collapsible">
                    <summary>
                        <i class="fas fa-plus"></i>
                        Add package
                    </summary>

                    <form method="POST"
                          action="http://localhost/globetrek/index.php?url=staff/packages"
                          enctype="multipart/form-data"
                          class="package-form">
                        <input type="hidden" name="action" value="create">

                        <div class="form-row">
                            <div class="form-group">
                                <label>Package Title</label>
                                <input type="text" name="title"
                                       placeholder="e.g. Cultural Triangle Tour"
                                       required>
                            </div>
                           <div class="form-group">
    <label>Destination</label>
    <select name="destination" required>
        <option value="">-- Select Destination --</option>
        <?php foreach ($destinations as $d): ?>
        <option value="<?= htmlspecialchars($d['name']) ?>">
            <?= htmlspecialchars($d['name']) ?>
        </option>
        <?php endforeach; ?>
    </select>
</div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" rows="3"
                                      placeholder="Describe this tour package..."
                                      required></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Duration (Days)</label>
                                <input type="number" name="duration_days"
                                       min="1" placeholder="e.g. 5" required>
                            </div>
                            <div class="form-group">
                                <label>Price Per Person (Rs.)</label>
                                <input type="number" name="price"
                                       step="1" min="0"
                                       placeholder="e.g. 45000" required>
                            </div>
                            <div class="form-group">
                                <label>Max Persons</label>
                                <input type="number" name="max_persons"
                                       min="1" placeholder="e.g. 10" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>What is Included (comma separated)</label>
                            <input type="text" name="includes"
                                   placeholder="Hotel, Transport, Guide, Meals">
                        </div>

                        <div class="form-group">
                            <label>Itinerary (one day per line)</label>
                            <textarea name="itinerary" rows="6"
                                      placeholder="Day 1: Arrival&#10;Day 2: City Tour"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Package Image</label>
                            <input type="file" name="package_image"
                                   accept="image/*" class="file-input">
                            <small style="color:var(--grey);font-size:0.8rem;">
                                <i class="fas fa-info-circle"></i>
                                JPG, PNG or WEBP — Max 2MB
                            </small>
                        </div>

                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Add Package
                        </button>
                    </form>
                </details>

                <?php endif; ?>

                <!-- PACKAGES TABLE -->
                <h3 style="margin-top:2rem;margin-bottom:1rem;">
                    <i class="fas fa-list"
                       style="color:var(--blue);margin-right:8px;"></i>
                    All Packages
                    <span style="font-size:0.9rem;color:var(--grey);
                                 font-weight:400;margin-left:8px;">
                        (<?= count($packages) ?> total)
                    </span>
                </h3>

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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packages as $pkg): ?>
                        <tr>
                            <td>
                                <img src="http://localhost/globetrek/assets/images/<?= htmlspecialchars($pkg['image']) ?>"
                                     alt="<?= htmlspecialchars($pkg['title']) ?>"
                                     onerror="this.src='http://localhost/globetrek/assets/images/default.jpg'"
                                     style="width:65px;height:48px;
                                            object-fit:cover;border-radius:5px;">
                            </td>
                            <td>
                                <strong>
                                    <?= htmlspecialchars($pkg['title']) ?>
                                </strong>
                                <br>
                                <small style="color:var(--grey);">
                                    <?= substr(htmlspecialchars($pkg['description']), 0, 45) ?>...
                                </small>
                            </td>
                            <td>
                                <i class="fas fa-map-marker-alt"
                                   style="color:var(--danger);margin-right:4px;"></i>
                                <?= htmlspecialchars($pkg['destination']) ?>
                            </td>
                            <td>
                                <i class="fas fa-clock"
                                   style="color:var(--blue);margin-right:4px;"></i>
                                <?= $pkg['duration_days'] ?> days
                            </td>
                            <td>
                                <strong style="color:var(--navy);">
                                    Rs.<?= number_format($pkg['price'], 0) ?>
                                </strong>
                            </td>
                            <td>
                                <i class="fas fa-users"
                                   style="color:var(--grey);margin-right:4px;"></i>
                                <?= $pkg['max_persons'] ?>
                            </td>
                            <td>
                                <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                    <a href="http://localhost/globetrek/index.php?url=staff/packages&edit=<?= $pkg['id'] ?>"
                                       class="btn-sm btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                               <form method="POST"
      action="http://localhost/globetrek/index.php?url=staff/packages"
      style="display:inline;">
    <input type="hidden" name="action" value="delete">
  <input type="hidden" name="package_id" value="<?= $pkg['id'] ?>">
    <button type="submit"
            class="btn-sm btn-danger"
            onclick="return confirm('Delete this package?')">
        <i class="fas fa-trash"></i> Delete
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
                    <p>No packages added yet.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>