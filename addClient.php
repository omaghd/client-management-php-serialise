<?php
@session_start();

// Check authentication
if (!isset($_COOKIE['auth'])) :
    header('location: ./');
    exit();
endif;

$title = "GC | New Client";

require_once('./controllers/FileController.php');
require_once('./inc/crud.php');

// Check if Client file exists
checkFile('client');

require_once('./layout/header.php');

?>

<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <h3 class="text-uppercase mb-4">
                <i class="fa fa-plus mr-2"></i>Add a new client
            </h3>
            <hr class="my-4">
            <?php
            if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    foreach ($_SESSION['errors'] as $error) : ?>
                        <li><?= $error ?></li>
                    <?php
                    endforeach; ?>
                </div>
            <?php
            endif; ?>
            <?php
            if (isset($_SESSION['createdClientFile'])) :
            ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check mr-2"></i><strong>Clients file is created!</strong> You can now add a new client!
                </div>
            <?php
            endif;
            ?>
            <?php
            if (isset($_SESSION['NoClient'])) :
            ?>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i><strong>No Client Found!</strong> You can start creating new clients!
                </div>
            <?php
            endif;
            ?>
            <form method="POST" action="." class="form-inline">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" class="form-control mx-3" type="text" name="name" value="<?= @$_SESSION['nameAdd'] ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input id="address" class="form-control mx-3" type="text" name="address" value="<?= @$_SESSION['addressAdd'] ?>">
                </div>
                <div class="form-group">
                    <label for="tel">Tel.</label>
                    <input id="tel" class="form-control mx-3" type="tel" name="tel" value="<?= @$_SESSION['telAdd'] ?>">
                </div>
                <input class="btn btn-success" type="submit" value="ADD" name="add">
            </form>

            <li class="mt-3 col-sm-6">
                To go back to the clients list, <a href="./">click here!</a>
            </li>
        </div>
    </div>
</body>

<?php
unset($_SESSION['errors']);
unset($_SESSION['nameAdd']);
unset($_SESSION['addressAdd']);
unset($_SESSION['telAdd']);
unset($_SESSION['NoClient']);
unset($_SESSION['createdClientFile']);
require_once('./layout/footer.php');
?>