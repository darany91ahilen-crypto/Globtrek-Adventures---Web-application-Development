<?php
$base_url = 'http://localhost/globetrek';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' | GlobeTrek Adventures' : 'GlobeTrek Adventures' ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="navbar">
    <div class="container nav-inner">
        <a href="<?= $base_url ?>/index.php" class="logo">
    <img src="<?= $base_url ?>/assets/images/logo.jpeg" 
         alt="GlobeTrek Adventures" 
         class="logo-img">
    GlobeTrek Adventures  </a>
    <button class="menu-toggle"
                type="button"
                aria-label="Open navigation menu"
                aria-expanded="false"
                aria-controls="main-nav">
            <i class="fas fa-bars"></i>
        </button>
        <nav>
            <a href="<?= $base_url ?>/index.php">Home</a>
            <a href="<?= $base_url ?>/index.php?url=package/index">Packages</a>
            <a href="<?= $base_url ?>/index.php?url=home/accommodation">Accommodation</a>
             <a href="http://localhost/globetrek/index.php?url=home/guides"> Travel Guides</a>
            <a href="<?= $base_url ?>/index.php?url=home/about">About</a>
            <a href="<?= $base_url ?>/index.php?url=home/contact">Contact</a>
         

            <?php if (isset($_SESSION['user_id'])): ?>

                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <a href="<?= $base_url ?>/index.php?url=admin/dashboard">Admin Panel</a>

                <?php elseif ($_SESSION['user_role'] === 'staff'): ?>
                    <a href="<?= $base_url ?>/index.php?url=staff/dashboard">Staff Panel</a>

                <?php else: ?>
                    <a href="<?= $base_url ?>/index.php?url=customer/dashboard">My Account</a>
                <?php endif; ?>

                <a href="<?= $base_url ?>/index.php?url=auth/logout" class="btn-nav">Logout</a>

            <?php else: ?>
                <a href="<?= $base_url ?>/index.php?url=auth/login" class="btn-nav">Login</a>
                <a href="<?= $base_url ?>/index.php?url=auth/register" class="btn-nav btn-outline">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="main-content">