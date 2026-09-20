<?php
include '../layout/header.php';
require '../Database/Database.php';
require '../Models/User.php';

session_start([
    'cookie_lifetime' => 86400,
]);

$database = new Database();
$db = $database->getConnection();

User::setConnection($db);

if (isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (User::login($email, $password)) {
        header('Location: ../index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layout/style.css">
    <title>Login</title>
</head>

<body class="auth-page">
    <div class="auth-card">
        <div class="card-body">
            <form action="login.php" method="POST">
                <h1>Login</h1>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= ($_SESSION['success']) ?>
                    </div>
                    <?php unset($_SESSION['success']);
                    endif; ?>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control <?= (isset($_SESSION['error']) ? 'is-invalid' : '') ?>"
                            id="email" name="email">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="invalid-feedback">
                                <?= $_SESSION['error'] ?>
                            </div>
                            <?php unset($_SESSION['error']);
                            endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>

</html>