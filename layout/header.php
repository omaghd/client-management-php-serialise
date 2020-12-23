<?php
@session_start();

date_default_timezone_set('UTC');

require_once('./controllers/FileController.php');
if (isset($_POST['dU'])) :
    deleteFile('user');
elseif (isset($_POST['dC'])) :
    deleteFile('client');
endif;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="./">GC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
        <?php if (isset($_COOKIE['auth'])) :  ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= explode("/", $_SERVER['REQUEST_URI'])[3] == 'addClient' ? ' active' : '' ?>">
                    <a class="nav-link" href="./addClient">New client
                        <?= explode("/", $_SERVER['REQUEST_URI'])[3] == 'addClient' ? '<span class="sr-only">(current)</span>' : '' ?>
                    </a>
                </li>
                <li class="nav-item <?= explode("/", $_SERVER['REQUEST_URI'])[3] == 'editClient' ? ' active' : '' ?>">
                    <a class="nav-link" href="./editClient">Edit client
                        <?= explode("/", $_SERVER['REQUEST_URI'])[3] == 'editClient' ? '<span class="sr-only">(current)</span>' : '' ?>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
        <?php if (!isset($_COOKIE['auth'])) :  ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="./login" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="./register" class="nav-link">Register</a>
                </li>
            </ul>
        <?php elseif (isset($_COOKIE['auth'])) :  ?>
            <ul class="navbar-nav ml-auto">

                <form method="post">
                    <input name="dC" value="1" type="hidden">
                    <button class="btn btn-danger" type="submit">Delete All Clients</button>
                </form>
                <form method="post">
                    <input name="dU" value="1" type="hidden">
                    <button class="btn btn-danger mx-1" type="submit">Delete All Users</button>
                </form>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                        Welcome !
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg-right text-nowrap">
                        <div class="d-flex align-items-center px-2">
                            <svg height="24" width="24" class="mr-2">
                                <rect fill="#a0d36a" x="0" y="0" height="24" width="24"></rect>
                                <text fill="#ffffff" font-size="12" text-anchor="middle" x="12" y="16"><?= $_COOKIE['name'][0] ?></text>
                            </svg>
                            <div>
                                <strong><?= $_COOKIE['name'] ?></strong>
                            </div>
                        </div>
                        <div class="px-2">
                            <small><strong>Last login:</strong> <?= date('F j - h:i A e', $_COOKIE['last_login']) ?></small>
                        </div>
                        <hr class="py-0">
                        <div class="px-2">
                            <a href="./logout" class="btn btn-block btn-outline-dark my-0">Logout</a>
                        </div>
                    </div>
                </div>
            </ul>
        <?php endif; ?>
    </div>
</nav>