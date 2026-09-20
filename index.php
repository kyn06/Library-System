<?php

session_start();

include 'layout/header.php';
require 'database/Database.php';
require 'models/User.php';
require 'models/Book.php';

$database = new Database();
$db = $database->getConnection();

User::setConnection($db);
Book::setConnection($db);

if (!isset($_SESSION['email'])) {
    header('Location: auth/login.php');
    exit;
}

$user = User::findByEmail($_SESSION['email']);

if (!$user) {
    session_destroy();
    header('Location: auth/login.php');
    exit;
}

$user_first_name = $user['first_name'];

$date = date('Y-m-d H:i:s', strtotime('-1 day'));
$dateNow = date('Y-m-d H:i:s');

$total_books = Book::countAllBooks();
$total_users = User::countAllUsers();
$new_books = Book::countNewBooks($date, $dateNow);
$new_users = User::countNewUsers($date, $dateNow);
$active_users = User::countUsersByStatus('active');
$inactive_users = User::countUsersByStatus('inactive');

?>

<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">

<link rel="stylesheet" href="layout/style.css">

<title>Library Dashboard</title>
```

</head>

<body>

```
<!-- Navigation -->

<nav class="navbar">

    <a href="index.php" class="brand">
        <i class='bx bx-library'></i>
        <span>Library</span>
    </a>

    <div class="nav-links">

        <a href="index.php" class="active">
            <i class='bx bxs-dashboard'></i>
            <span>Analytics</span>
        </a>

        <a href="users/index.php">
            <i class='bx bxs-user'></i>
            <span>Manage Users</span>
        </a>

        <a href="books/index.php">
            <i class='bx bxs-book'></i>
            <span>Manage Books</span>
        </a>

    </div>

    <div class="user-links">

        <a href="#">
            <span class="user-avatar">
                <?= strtoupper(substr($user_first_name, 0, 1)) ?>
            </span>

            <span class="user-name">
                <?= htmlspecialchars($user_first_name) ?>
            </span>

            <i class='bx bx-chevron-down'></i>
        </a>

    </div>

</nav>


<!-- Main Content -->

<main class="dashboard">

    <div class="page-header">

        <div>

            <span class="page-label">
                LIBRARY MANAGEMENT SYSTEM
            </span>

            <h1>Analytics</h1>

            <p>
                Welcome back, <?= htmlspecialchars($user_first_name) ?>.
                Here's your library overview.
            </p>

        </div>

        <div class="date-display">

            <i class='bx bx-calendar'></i>

            <?= date('F j, Y') ?>

        </div>

    </div>


    <!-- Statistics -->

    <section class="stats-grid">

        <div class="stat-card books">

            <div class="stat-icon">
                <i class='bx bxs-book'></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Books
                </span>

                <strong>
                    <?= $total_books ?>
                </strong>

                <small>
                    Books in library
                </small>

            </div>

        </div>


        <div class="stat-card new-books">

            <div class="stat-icon">
                <i class='bx bxs-book-add'></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    New Books
                </span>

                <strong>
                    <?= $new_books ?>
                </strong>

                <small>
                    Added in the last 24 hours
                </small>

            </div>

        </div>


        <div class="stat-card active-users">

            <div class="stat-icon">
                <i class='bx bxs-user-check'></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Active Users
                </span>

                <strong>
                    <?= $active_users ?>
                </strong>

                <small>
                    Currently active
                </small>

            </div>

        </div>


        <div class="stat-card total-users">

            <div class="stat-icon">
                <i class='bx bxs-group'></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Users
                </span>

                <strong>
                    <?= $total_users ?>
                </strong>

                <small>
                    Registered accounts
                </small>

            </div>

        </div>


        <div class="stat-card new-users">

            <div class="stat-icon">
                <i class='bx bxs-user-plus'></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    New Users
                </span>

                <strong>
                    <?= $new_users ?>
                </strong>

                <small>
                    Registered in 24 hours
                </small>

            </div>

        </div>


        <div class="stat-card inactive-users">

            <div class="stat-icon">
                <i class='bx bxs-user-x'></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Inactive Users
                </span>

                <strong>
                    <?= $inactive_users ?>
                </strong>

                <small>
                    Currently inactive
                </small>

            </div>

        </div>

    </section>


    <!-- Bottom Section -->

    <section class="dashboard-bottom">

        <div class="overview-panel">

            <div class="panel-header">

                <div>

                    <span>OVERVIEW</span>

                    <h2>Library Summary</h2>

                </div>

                <i class='bx bx-library'></i>

            </div>

            <div class="library-summary">

                <div class="summary-item">

                    <div class="summary-icon">
                        <i class='bx bxs-book'></i>
                    </div>

                    <div>
                        <strong><?= $total_books ?></strong>
                        <span>Total books available</span>
                    </div>

                </div>


                <div class="summary-item">

                    <div class="summary-icon">
                        <i class='bx bxs-group'></i>
                    </div>

                    <div>
                        <strong><?= $total_users ?></strong>
                        <span>Registered library users</span>
                    </div>

                </div>

            </div>

        </div>


        <div class="quick-panel">

            <div class="panel-header">

                <div>

                    <span>SHORTCUTS</span>

                    <h2>Quick Actions</h2>

                </div>

                <i class='bx bx-right-arrow-alt'></i>

            </div>

            <div class="quick-actions">

                <a href="books/index.php">
                    <i class='bx bxs-book-add'></i>
                    <span>Manage Books</span>
                    <i class='bx bx-chevron-right arrow'></i>
                </a>

                <a href="users/index.php">
                    <i class='bx bxs-user-detail'></i>
                    <span>Manage Users</span>
                    <i class='bx bx-chevron-right arrow'></i>
                </a>

            </div>

        </div>

    </section>


    <!-- Logout -->

    <div class="logout-container">

        <a href="auth/logout.php" class="logout-btn">
            <i class='bx bxs-log-out'></i>
            Logout
        </a>

    </div>

</main>
```

</body>

</html>

<?php include 'layout/footer.php'; ?>
