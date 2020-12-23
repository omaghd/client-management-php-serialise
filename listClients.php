<?php
@session_start();

isset($_COOKIE['auth']) ? $title = "GC | Clients List" : $title = "GC | Home";

require_once('./controllers/FileController.php');
require_once('./inc/serialize.php');
require_once('./inc/crud.php');
require_once('./inc/validation.php');

// Check if Client file exists
if (isset($_COOKIE['auth']))
    checkFile('client');

// To add a new client
if (isset($_POST["add"]) && empty($_SESSION['errors'])) :
    $clients = unserializeArray();
    $clients = create($clients);
    serializeArray($clients);
endif;

// To edit an existing client's information
if (isset($_POST["edit"]) && empty($_SESSION['errors'])) :
    $clients = unserializeArray();
    $clients = update($clients);
    serializeArray($clients);
endif;

// To delete an existing client
if (isset($_POST["idClient"])) :
    $clients = unserializeArray();
    $clients = remove($clients);
    serializeArray($clients);
endif;

// To retrieve all the clients, if found
if (isset($_COOKIE['auth'])) :
    if (@empty(retrieve())) :
        if (!isset($_POST['add']) && !isset($_POST['edit'])) :
            $_SESSION['NoClient'] = TRUE;
            header('location: ./addClient');
            exit();
        endif;
    else :
        $clientsArray = retrieve();
    endif;
endif;

require_once('./layout/header.php');
?>

<body>
    <div class="container">
        <?php if (!isset($_COOKIE['auth'])) : ?>
            <div class="jumbotron mt-5">
                <h1 class="display-4">You must be logged in first!</h1>
                <hr class="my-4">
                <div class="d-flex align-items-center">
                    <a href="./login" class="btn btn-dark mr-3">Login</a>
                    <div class="mr-3">or</div>
                    <a href="./register" class="btn btn-outline-dark">Register</a>
                </div>
            </div>
        <?php else : ?>
            <div class="mt-5">
                <?php if (isset($_SESSION['add'])) : ?>
                    <div class="alert alert-success col-sm-12" role="alert">
                        Client bien ajouté!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif (isset($_SESSION['update'])) : ?>
                    <div class="alert alert-warning col-sm-12" role="alert">
                        Client bien modifié!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif (isset($_SESSION['remove'])) : ?>
                    <div class="alert alert-danger col-sm-12" role="alert">
                        Client bien supprimé!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="d-sm-flex justify-content-md-between justify-content-sm-center align-items-center">
                    <h3 class="text-uppercase">
                        <i class="fa fa-list mr-2"></i>Clients list
                    </h3>
                    <div>
                        <a href="addClient" class="btn btn-block btn-success text-decoration-none text-uppercase">
                            <i class="fa fa-plus mr-2"></i>Add new client
                        </a>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($clientsArray)) :
            ?>
                <div class="table-responsive mt-2">
                    <table class="table table-light table-hover text-nowrap text-center">
                        <thead>
                            <tr class="text-uppercase">
                                <td>ID</td>
                                <td>Name</td>
                                <td>Address</td>
                                <td>Tel.</td>
                                <td>Options</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cp = 0;
                            foreach ($clientsArray as $client) :
                                echo "<tr>";
                                echo "<td>" . $client["id"] . "</td>";
                                echo "<td>" . $client["name"] . "</td>";
                                echo "<td>" . $client["address"] . "</td>";
                                echo "<td>" . $client["tel"] . "</td>";
                                echo "<td>
                                <form method='post' id='delete" . @$client['id'] . "' action='.'>
                                    <a href=\"editClient?id=" . @$client['id'] . "\" class='btn btn-warning mr-1'>EDIT</a>
                                    <input type='hidden' value='" . @$client['id'] . "' name='idClient'>
                                    <button class='btn btn-danger ml-1' type='button' onclick='sure(" . @$client['id'] . ", \"" . $client["name"] . "\")' name='delete'>DELETE</button>
                                </form>
                            </td>";
                                echo "</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            else :
            ?>
                <h4 class="mt-3 text-center text-muted">No client found! Add a new client</h4>
            <?php
            endif;
            ?>
        <?php endif; ?>
    </div>
</body>
<?php
unset($_SESSION['add']);
unset($_SESSION['update']);
unset($_SESSION['remove']);
?>
<script>
    function sure(id, name) {
        if (confirm(`Are you sure you want to delete (N°${id}) ${name}'s information?`)) {
            return document.getElementById(`delete${id}`).submit();
        }
        return false;
    }
</script>

<?php require_once('./layout/footer.php') ?>