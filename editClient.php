<?php
@session_start();

// Check authentication
if (!isset($_COOKIE['auth'])) :
    header('location: ./');
    exit();
endif;

$title = 'GC | Edit Client';

require_once('./inc/crud.php');
require_once('./inc/serialize.php');
require_once('./controllers/FileController.php');


// Check if Client file exists
checkFile('client');

$clients = unserializeArray();
if (empty($clients)) :
    $_SESSION['NoClient'] = TRUE;
    header('location: ./addClient');
    exit();
endif;

$path           = "clients.txt";

$contenu        = file_get_contents($path);
$clientsArray   = unserialize($contenu);

foreach ($clientsArray as $currentClient) :
    if (isset($_GET["id"]) && $currentClient["id"] == (isset($_GET["id"]) ? $_GET['id'] : $_SESSION['idClient'])) :
        $currentName        = $currentClient["name"];
        $currentAdresse     = $currentClient["address"];
        $currentTel         = $currentClient["tel"];
    endif;
endforeach;

require_once('./layout/header.php');
?>

<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <h3 class="text-uppercase mb-4">
                <i class="fa fa-edit mr-2"></i>Edit client
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
            <form method="POST" action="." class="form-inline">
                <?php
                if (!isset($_GET['id']) && !isset($_SESSION['idClient']) && !isset($_SESSION['nameEdit']) && !isset($_SESSION['addressEdit']) && !isset($_SESSION['telEdit'])) :
                ?>
                    <div class="col-sm-12 mb-3 px-0">
                        <div class="form-group">
                            <label for="id" class="mr-3">Client</label>
                            <select id="id" class="form-control" name="id">
                                <?php
                                foreach ($clients as $client) :
                                ?>
                                    <option value="<?= $client['id'] ?>"><?= $client['name'] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                <?php
                else :
                ?>
                    <input type="hidden" name="id" value="<?php if (@$_GET["id"]) echo @$_GET["id"];
                                                            else echo @$_SESSION['idClient']; ?>">
                <?php
                endif;
                ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" class="form-control mx-3" type="text" value="<?php if (@$currentName) echo $currentName;
                                                                                    else echo @$_SESSION['nameEdit']; ?>" name="name">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input id="address" class="form-control mx-3" type="text" value="<?php if (@$currentAdresse) echo $currentAdresse;
                                                                                        else echo @$_SESSION['addressEdit']; ?>" name="address">
                </div>
                <div class="form-group">
                    <label for="tel">Tel.</label>
                    <input id="tel" class="form-control mx-3" type="tel" value="<?php if (@$currentTel) echo $currentTel;
                                                                                else echo @$_SESSION['telEdit']; ?>" name="tel">
                </div>
                <input class="btn btn-warning" type="submit" value="EDIT" name="edit">
            </form>

            <li class="mt-3 col-sm-6">
                To go back to the clients list, <a href="./">click here!</a>
            </li>
        </div>
    </div>
</body>

<?php
unset($_SESSION['errors']);
unset($_SESSION['idClient']);
unset($_SESSION['nameEdit']);
unset($_SESSION['addressEdit']);
unset($_SESSION['telEdit']);
require_once('./layout/footer.php');
?>