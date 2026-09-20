<?php

session_start();

require '../Database/database.php';
require '../Models/Book.php';
require '../Models/User.php';
include '../layout/header.php';

$database = new Database();
$db = $database->getConnection();

Book::setConnection($db);

$userController = new User();
$userController->authenticateUser();

$books = Book::all();

$user_first_name = $userController->getUserName();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../layout/style.css">

<title>Manage Books</title>

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

        <a href="../users/index.php">
            <i class='bx bxs-user'></i>
            <span>Manage Users</span>
        </a>

        <a href="index.php" class="active">
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

            <h1>Manage Books</h1>

            <p>
                View, update, and manage books in the library collection.
            </p>

        </div>

        <a href="../books/create.php" class="primary-action">

            <i class='bx bx-plus'></i>

            Add Book

        </a>

    </div>


    <!-- Books Table -->

    <section class="data-panel">

        <div class="data-panel-header">

            <div>

                <h2>Book Collection</h2>

                <span>
                    <?= count($books) ?> books available
                </span>

            </div>


            <div class="table-search">

                <i class='bx bx-search'></i>

                <input
                    type="text"
                    id="bookSearch"
                    placeholder="Search books..."
                >

            </div>

        </div>


        <div class="table-wrapper">

            <table id="booksTable" class="modern-table">

                <thead>

                    <tr>

                        <th>Book</th>

                        <th>SKU</th>

                        <th>Author</th>

                        <th>Genre</th>

                        <th>Year</th>

                        <th class="actions-column">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody id="bookTableBody">

                    <?php if (!empty($books)): ?>

                        <?php foreach ($books as $book): ?>

                            <tr>

                                <td>

                                    <div class="item-info">

                                        <div class="item-icon book-icon">
                                            <i class='bx bxs-book'></i>
                                        </div>

                                        <div>

                                            <strong>
                                                <?= htmlspecialchars($book->title) ?>
                                            </strong>

                                            <span>
                                                Book ID #<?= $book->id ?>
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <span class="code-badge">
                                        <?= htmlspecialchars($book->sku) ?>
                                    </span>

                                </td>


                                <td>
                                    <?= htmlspecialchars($book->author) ?>
                                </td>


                                <td>

                                    <span class="category-badge">
                                        <?= htmlspecialchars($book->genre) ?>
                                    </span>

                                </td>


                                <td>
                                    <?= htmlspecialchars($book->year_published) ?>
                                </td>


                                <td>

                                    <div class="table-actions">

                                        <a
                                            href="../books/show.php?id=<?= $book->id ?>"
                                            class="action-btn view"
                                            title="View"
                                        >
                                            <i class='bx bx-show'></i>
                                        </a>


                                        <a
                                            href="edit.php?id=<?= $book->id ?>"
                                            class="action-btn edit"
                                            title="Edit"
                                        >
                                            <i class='bx bx-edit'></i>
                                        </a>


                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'librarian'): ?>

                                            <a
                                                href="confirmation.php?id=<?= $book->id ?>"
                                                class="action-btn delete"
                                                title="Delete"
                                            >
                                                <i class='bx bx-trash'></i>
                                            </a>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6">

                                <div class="empty-state">

                                    <i class='bx bx-book-open'></i>

                                    <h3>No Books Found</h3>

                                    <p>
                                        There are currently no books in the library.
                                    </p>

                                    <a
                                        href="../books/create.php"
                                        class="primary-action"
                                    >
                                        <i class='bx bx-plus'></i>
                                        Add First Book
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

    const searchInput = document.getElementById('bookSearch');
    const rows = document.querySelectorAll('#bookTableBody tr');

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
