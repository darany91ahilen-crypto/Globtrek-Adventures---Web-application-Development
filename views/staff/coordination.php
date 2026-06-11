<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="dashboard-layout">

            <!-- SIDEBAR -->
            <aside class="dashboard-sidebar">
                <nav class="dash-nav">
                    <a href="http://localhost/globetrek/index.php?url=staff/dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/bookings">
                        <i class="fas fa-calendar-check"></i>
                        Manage Bookings
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/packages">
                        <i class="fas fa-suitcase"></i>
                        Manage Packages
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/accommodations">
                        <i class="fas fa-hotel"></i>
                        Accommodations
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/coordination"
                       class="active">
                        <i class="fas fa-bus"></i>
                        Hotel & Transport
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=staff/queries">
                        <i class="fas fa-comments"></i>
                        Customer Queries
                    </a>
                    <a href="http://localhost/globetrek/index.php?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </nav>
            </aside>

            <!-- MAIN -->
            <div class="dashboard-main">

                <h2>
                    Hotel & Transport
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

                <!-- ADD COORDINATION FORM -->
                <div class="coord-form-card">
                    
                    <form method="POST"
                          action="http://localhost/globetrek/index.php?url=staff/coordination">
                        <input type="hidden" name="action" value="create">

                        <div class="form-group">
                            <label>
                                <i class="fas fa-calendar-check"
                                   style="color:var(--blue);
                                          margin-right:5px;"></i>
                                Select Booking
                            </label>
                            <select name="booking_id" required>
                                <option value="">
                                    -- Select a Booking --
                                </option>
                                <?php foreach ($bookings as $b): ?>
                                <option value="<?= $b['id'] ?>">
                                    #<?= str_pad($b['id'],6,'0',STR_PAD_LEFT) ?>
                                    — <?= htmlspecialchars($b['full_name']) ?>
                                    — <?= htmlspecialchars($b['package_title']) ?>
                                    — <?= date('d M Y',
                                        strtotime($b['travel_date'])) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-hotel"
                                       style="color:var(--blue);
                                              margin-right:5px;"></i>
                                    Hotel Name
                                </label>
                                <input type="text"
                                       name="hotel_name"
                                       placeholder="Kingsbury Hotel"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-phone"
                                       style="color:var(--blue);
                                              margin-right:5px;"></i>
                                    Hotel Contact
                                </label>
                                <input type="text"
                                       name="hotel_contact">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-info-circle"
                                   style="color:var(--blue);
                                          margin-right:5px;"></i>
                                Hotel Status
                            </label>
                            <select name="hotel_status">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-bus"
                                       style="color:var(--blue);
                                              margin-right:5px;"></i>
                                    Transport Type
                                </label>
                                <input type="text"
                                       name="transport_type"
                                       placeholder="Van, Bus, Car">
                            </div>
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-phone-alt"
                                       style="color:var(--blue);
                                              margin-right:5px;"></i>
                                    Transport Contact
                                </label>
                                <input type="text"
                                       name="transport_contact"
                                       placeholder="+94 77 000 0000">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-info-circle"
                                   style="color:var(--blue);
                                          margin-right:5px;"></i>
                                Transport Status
                            </label>
                            <select name="transport_status">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Save Coordination
                        </button>
                    </form>
                </div>

                <!-- COORDINATION TABLE -->
                <h3 style="margin-bottom:1rem;">
                    <i class="fas fa-list"
                       style="color:var(--blue);
                              margin-right:8px;"></i>
                    All Coordinations
                </h3>

                <?php if (!empty($coordinations)): ?>
                <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Booking</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Hotel</th>
                            <th>Hotel Status</th>
                            <th>Transport</th>
                            <th>Transport Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coordinations as $c): ?>
                        <tr>
                            <td>
                                #<?= str_pad($c['booking_id'],
                                             6,'0',STR_PAD_LEFT) ?>
                                <br>
                                <small style="color:var(--grey);">
                                    <?= date('d M Y',
                                        strtotime($c['travel_date'])) ?>
                                </small>
                            </td>
                            <td>
                                <?= htmlspecialchars($c['customer_name']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($c['package_title']) ?>
                            </td>
                            <td>
                                <strong>
                                    <?= htmlspecialchars($c['hotel_name']) ?>
                                </strong>
                                <br>
                                <small style="color:var(--grey);">
                                    <?= htmlspecialchars($c['hotel_contact'] ?? '') ?>
                                </small>
                            </td>
                            <td>
                                <span class="status-badge
                                      status-<?= $c['hotel_status'] ?>">
                                    <?= ucfirst($c['hotel_status']) ?>
                                </span>
                            </td>
                            <td>
                                <strong>
                                    <?= htmlspecialchars($c['transport_type'] ?? 'N/A') ?>
                                </strong>
                                <br>
                                <small style="color:var(--grey);">
                                    <?= htmlspecialchars($c['transport_contact'] ?? '') ?>
                                </small>
                            </td>
                            <td>
                                <span class="status-badge
                                      status-<?= $c['transport_status'] ?>">
                                    <?= ucfirst($c['transport_status']) ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST"
                                      style="display:inline;">
                                    <input type="hidden"
                                           name="action"
                                           value="delete">
                                    <input type="hidden"
                                           name="coord_id"
                                           value="<?= $c['id'] ?>">
                                    <button type="submit"
                                            class="btn-sm btn-danger"
                                            onclick="return confirm('Remove this record?')">
                                        <i class="fas fa-trash"></i>
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>

                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-bus"></i>
                    <p>No coordination records yet.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>