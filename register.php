<?php
@session_start();

// Check authentication
if (isset($_COOKIE['auth'])) :
    header('location: ./');
    exit();
endif;

$title = "GC | REGISTER";

require_once('./inc/serialize.php');
require_once('./controllers/RegisterController.php');
require_once('./controllers/FileController.php');

// Check if User file exists
checkFile('user');

require_once('./layout/header.php');



?>

<div class="container">
    <div class="d-flex justify-content-center">
        <div class="jumbotron col-sm-6 mt-5 mb-0">
            <?php
            if (isset($_SESSION['errorsRegister']) && !empty($_SESSION['errorsRegister'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    foreach ($_SESSION['errorsRegister'] as $error) : ?>
                        <li><?= $error ?></li>
                    <?php
                    endforeach; ?>
                </div>
            <?php
            endif; ?>
            <?php
            if (isset($_SESSION['createdUserFile'])) :
            ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check mr-2"></i><strong>Users file is created!</strong> You can now register a new user!
                </div>
            <?php
            endif;
            ?>
            <?php
            if (isset($_SESSION['NoUser'])) :
            ?>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i><strong>No user found!</strong> Kindly, register a new user!
                </div>
            <?php
            endif;
            ?>
            <form method="post">
                <div class="form-group">
                    <label for="name">Full Name&nbsp;<strong class="text-danger"><sup>(*)</sup></strong></label>
                    <input id="name" class="form-control" type="text" name="name" value="<?= @$_SESSION['nameReg'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username&nbsp;<strong class="text-danger"><sup>(*)</sup></strong></label>
                    <input id="username" class="form-control" type="text" name="username" value="<?= @$_SESSION['usernameReg'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password&nbsp;<strong class="text-danger"><sup>(*)</sup></strong></label>
                    <input id="password" class="form-control" type="password" name="password" value="<?= @$_SESSION['passwordReg'] ?>" autocomplete required>
                </div>
                <div class="form-check mb-3">
                    <input id="remember" class="form-check-input" type="checkbox" name="remember" <?= @$_SESSION['rememberReg'] ? 'checked' : '' ?>>
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>
                <small><strong class="text-danger">(*)</strong>: this field is required!</small>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-dark btn-block" name="register" type="submit">REGISTER</button>
                </div>
                <div class="mt-4">
                    Already have an account?&nbsp;<a class="badge p-2 badge-primary" href="./login">Sign in</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
unset($_SESSION['errorsRegister']);
unset($_SESSION['nameReg']);
unset($_SESSION['usernameReg']);
unset($_SESSION['passwordReg']);
unset($_SESSION['rememberReg']);
unset($_SESSION['NoUser']);
unset($_SESSION['createdUserFile']);
require_once('./layout/footer.php');
?>