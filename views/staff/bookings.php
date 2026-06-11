<?php require_once 'views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="dashboard-layout">
            <aside class="dashboard-sidebar">
                <nav class="dash-nav">
                    <a href="<?= BASE_URL ?>/?url=staff/dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/bookings" class="active">
                        <i class="fas fa-calendar-check"></i> Manage Bookings
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/packages">
                        <i class="fas fa-suitcase"></i> Manage Packages
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/accommodations">
                        <i class="fas fa-hotel"></i> Accommodations
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/coordination">
                        <i class="fas fa-bus"></i> Hotel & Transport
                    </a>
                    <a href="<?= BASE_URL ?>/?url=staff/queries">
                        <i class="fas fa-comments"></i> Customer Queries
                    </a>
                    <a href="<?= BASE_URL ?>/?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </aside>
            <div class="dashboard-main">
                <h2>Manage Bookings</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ref</th><th>Customer</th><th>Package</th>
                            <th>Travel Date</th><th>Persons</th>
                            <th>Total</th><th>Status</th><th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td>#<?= str_pad($b['id'], 6, '0', STR_PAD_LEFT) ?></td>
                            <td><?= htmlspecialchars($b['full_name']) ?></td>
                            <td><?= htmlspecialchars($b['package_title']) ?></td>
                            <td><?= date('d M Y', strtotime($b['travel_date'])) ?></td>
                            <td><?= $b['num_persons'] ?></td>
                            <td><?= formatLKR($b['total_price']) ?></td>
                            <td><span class="status-badge status-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                            <td>
                                <form method="POST" style="display:flex;gap:5px;">
                                    <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                                    <select name="status" class="select-sm">
                                        <option value="pending" <?= $b['status']==='pending'?'selected':'' ?>>Pending</option>
                                        <option value="confirmed" <?= $b['status']==='confirmed'?'selected':'' ?>>Confirmed</option>
                                        <option value="completed" <?= $b['status']==='completed'?'selected':'' ?>>Completed</option>
                                        <option value="cancelled" <?= $b['status']==='cancelled'?'selected':'' ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once 'views/layouts/footer.php'; ?>
