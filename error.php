<?php

$title = "GC | ERROR";

require_once('./controllers/FileController.php');

if (isset($_POST['createC'])) :
    createFile('client');
elseif (isset($_POST['createU'])) :
    createFile('user');
endif;

if (!isset($_GET['c']) && !isset($_GET['u'])) :
    header('location: ./');
    exit();
endif;

require_once('./layout/header.php');

?>

<div class="container mt-5">
    <div class="jumbotron">
        <h3>
            <li class="fa fa-exclamation-triangle mr-2"></li>Error!
        </h3>
        <hr class="my-4">
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong>
            <?php
            if (isset($_GET['c'])) :
            ?>
                <form action="" method="post">
                    <input type="hidden" name="createC" value="true">
                    Client file doesn't exist. Kindly, <button class="btn btn-outline-dark" type="submit">create one!</button>
                </form>
            <?php
            endif;
            ?>
            <?php
            if (isset($_GET['u'])) :
            ?>
                <form action="" method="post">
                    <input type="hidden" name="createU" value="true">
                    <div class="d-flex align-items-center">
                        <div class="mr-2">
                            User file doesn't exist. Kindly,
                        </div>
                        <button class="btn btn-outline-dark" type="submit">create one!</button>
                    </div>
                </form>
            <?php
            endif;
            ?>
        </div>
    </div>

</div>
<?php
require_once('./layout/footer.php');
?>