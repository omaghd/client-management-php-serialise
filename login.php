<?php
@session_start();

$title = "GC | LOGIN";


require_once('./inc/serialize.php');
require_once('./controllers/LoginController.php');

// Check authentication
if (isset($_COOKIE['auth'])) :
    header('location: ./');
    exit();
endif;

require_once('./inc/serialize.php');
require_once('./controllers/FileController.php');

// Check if User file exists
checkFile('user');

$path = 'users.txt';

if (@empty(unserializeArray())) :
    $_SESSION['NoUser'] = TRUE;
    header('location: ./register');
    exit();
endif;

require_once('./layout/header.php');




?>

<div class="container">
    <div class="d-flex justify-content-center">
        <div class="jumbotron col-sm-6 mt-5">
            <?php
            if (isset($_SESSION['errorsLogin']) && !empty($_SESSION['errorsLogin'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    foreach ($_SESSION['errorsLogin'] as $error) : ?>
                        <li><?= $error ?></li>
                    <?php
                    endforeach; ?>
                </div>
            <?php
            endif; ?>
            <?php
            if (isset($_GET['no_user']) && $_GET['no_user']) :
            ?>
                <div class="alert alert-info" role="alert">
                    There's no user registred yet! Kindly, register a new user!
                </div>
            <?php
            endif;
            ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input id="username" class="form-control" type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input id="password" class="form-control" type="password" name="password" autocomplete required>
                </div>
                <div class="form-check mb-3">
                    <input id="remember" class="form-check-input" type="checkbox" name="remember" value="true">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-dark btn-block" name="login" type="submit">LOGIN</button>
                </div>
                <div class="mt-4">
                    Don't have an account yet?&nbsp;<a class="badge p-2 badge-primary" href="./register">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once('./layout/footer.php');
unset($_SESSION['errorsLogin']);
?>