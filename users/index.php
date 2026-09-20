<?php

session_start();

require '../Database/Database.php';
require '../Models/User.php';
include '../layout/header.php';

$database = new Database();
$db = $database->getConnection();

User::setConnection($db);

$userController = new User();
$userController->authenticateUser();

$users = $userController->getUsers();

$user_first_name = $userController->getUserName();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../layout/style.css">

<title>Manage Users</title>

</head>

<body>

<!-- Navigation -->

<nav class="navbar">

    <a href="../index.php" class="brand">

        <i class='bx bx-library'></i>

        <span>Library</span>

    </a>


    <div class="nav-links">

        <a href="../index.php">

            <i class='bx bxs-dashboard'></i>

            <span>Analytics</span>

        </a>


        <a href="index.php" class="active">

            <i class='bx bxs-user'></i>

            <span>Manage Users</span>

        </a>


        <a href="../books/index.php">

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

<main class="management-page">

    <div class="management-header">

        <div>

            <span class="page-label">
                LIBRARY MANAGEMENT
            </span>

            <h1>Manage Users</h1>

            <p>
                View and manage registered library user accounts.
            </p>

        </div>


        <a href="../users/create.php" class="primary-action">

            <i class='bx bx-user-plus'></i>

            Add User

        </a>

    </div>


    <!-- Users Table -->

    <section class="data-panel">

        <div class="data-panel-header">

            <div>

                <h2>User Accounts</h2>

                <span>
                    <?= count($users) ?> registered users
                </span>

            </div>


            <div class="table-search">

                <i class='bx bx-search'></i>

                <input
                    type="text"
                    id="userSearch"
                    placeholder="Search users..."
                >

            </div>

        </div>


        <div class="table-wrapper">

            <table id="usersTable" class="modern-table">

                <thead>

                    <tr>

                        <th>User</th>

                        <th>Email</th>

                        <th>Role</th>

                        <th>Status</th>

                        <th class="actions-column">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody id="userTableBody">

                    <?php if (!empty($users)): ?>

                        <?php foreach ($users as $user): ?>

                            <tr>

                                <td>

                                    <div class="item-info">

                                        <div class="user-table-avatar">

                                            <?= strtoupper(
                                                substr($user->first_name, 0, 1)
                                            ) ?>

                                        </div>


                                        <div>

                                            <strong>

                                                <?= htmlspecialchars($user->first_name) ?>

                                                <?= htmlspecialchars($user->last_name) ?>

                                            </strong>

                                            <span>
                                                User ID #<?= $user->id ?>
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <span class="email-text">
                                        <?= htmlspecialchars($user->email) ?>
                                    </span>

                                </td>


                                <td>

                                    <span class="role-badge">

                                        <?= htmlspecialchars($user->role) ?>

                                    </span>

                                </td>


                                <td>

                                    <?php if ($user->status === 'active'): ?>

                                        <span class="status-badge active">
                                            <i class='bx bxs-circle'></i>
                                            Active
                                        </span>

                                    <?php else: ?>

                                        <span class="status-badge inactive">
                                            <i class='bx bxs-circle'></i>
                                            Deactivated
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div class="table-actions">

                                        <a
                                            href="show.php?id=<?= $user->id ?>"
                                            class="action-btn view"
                                            title="View"
                                        >
                                            <i class='bx bx-show'></i>
                                        </a>


                                        <a
                                            href="edit.php?id=<?= $user->id ?>"
                                            class="action-btn edit"
                                            title="Edit"
                                        >
                                            <i class='bx bx-edit'></i>
                                        </a>


                                        <a
                                            href="confirmation.php?id=<?= $user->id ?>"
                                            class="action-btn delete"
                                            title="Delete"
                                        >
                                            <i class='bx bx-trash'></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5">

                                <div class="empty-state">

                                    <i class='bx bx-user-x'></i>

                                    <h3>No Users Found</h3>

                                    <p>
                                        There are currently no registered users.
                                    </p>

                                    <a
                                        href="../users/create.php"
                                        class="primary-action"
                                    >
                                        <i class='bx bx-user-plus'></i>
                                        Add First User
                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>


    <!-- Logout -->

    <div class="logout-container">

        <a href="../auth/logout.php" class="logout-btn">

            <i class='bx bxs-log-out'></i>

            Logout

        </a>

    </div>

</main>


<script>

    const searchInput = document.getElementById('userSearch');
    const rows = document.querySelectorAll('#userTableBody tr');

    searchInput.addEventListener('input', function () {

        const searchValue = this.value.toLowerCase();

        rows.forEach(function (row) {

            const text = row.textContent.toLowerCase();

            row.style.display =
                text.includes(searchValue) ? '' : 'none';

        });

    });

</script>

</body>

</html>

<?php include '../layout/footer.php'; ?>
