<?php
@session_start();

// Initiate errors session as an array
$_SESSION['errorsLogin'] = [];


// Sanitize inputs function 
function sanitize($input)
{
    $input = trim($input);
    $input = strip_tags($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}

// Validation for 'Login' form
if (isset($_POST['login'])) :

    if (empty($_POST['username'])) :
        array_push($_SESSION['errorsLogin'], 'Username field is required!');

    elseif (empty($_POST['password'])) :
        array_push($_SESSION['errorsLogin'], 'Password field is required!');

    else :
        $usersArray = unserializeArray();
        foreach ($usersArray as $user) :
            if ($user['username'] == $_POST['username']) :
                if (password_verify($_POST['password'], $user['password'])) :
                    $passed = TRUE;
                    break;
                endif;
            endif;
        endforeach;
        if ($passed) :
            if (isset($_POST['remember'])) :
                // One year
                @setcookie('auth', TRUE, time() + 31556926);
                @setcookie('name', $user["name"], time() + 31556926);
                @setcookie('last_login', time(), time() + 31556926);
                @setcookie('remember', TRUE, time() + 31556926);
            else :
                // One hour
                @setcookie('auth', TRUE, time() + 3600);
                @setcookie('name', $user["name"], time() + 3600);
                @setcookie('last_login', time(), time() + 3600);
            endif;
            header('location: ./');
            echo 'mzyan';
        else :
            array_push($_SESSION['errorsLogin'], 'Username or Password is incorrect!');
        endif;
    endif;
endif;
