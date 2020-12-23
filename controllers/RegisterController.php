<?php

/*
* Validation for 'Register' form START
*/

if (isset($_POST['register'])) :

    // Initiate errorsRegister session as an array
    $_SESSION['errorsRegister'] = [];

    // Sanitize inputs function 
    function sanitize($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);

        return $input;
    }


    // Sanitize POST inputs
    $_POST['name']      = sanitize($_POST['name']);
    $_POST['username']  = sanitize($_POST['username']);


    // Creating session
    $_SESSION['nameReg']       = $_POST['name'];
    $_SESSION['usernameReg']   = $_POST['username'];
    $_SESSION['passwordReg']   = $_POST['password'];
    @$_SESSION['rememberReg']   = $_POST['remember'];


    /*
    * Inputs validation START
    */
    // Check if the inputs are filled
    if (empty($_POST['name'])) :
        array_push($_SESSION['errorsRegister'], 'Name field is required.');
    endif;

    if (empty($_POST['username'])) :
        array_push($_SESSION['errorsRegister'], 'Username field is required.');
    endif;

    if (empty($_POST['password'])) :
        array_push($_SESSION['errorsRegister'], 'Password field is required.');
    endif;


    // Check input' length
    if (!empty($_POST['name']) && strlen($_POST['name']) < 3) :
        array_push($_SESSION['errorsRegister'], 'Name should contain at least 3 characters.');
    endif;

    if (!empty($_POST['username']) && strlen($_POST['username']) < 3) :
        array_push($_SESSION['errorsRegister'], 'Username should contain at least 3 characters.');
    endif;

    if (!empty($_POST['password']) && strlen($_POST['password']) < 6) :
        array_push($_SESSION['errorsRegister'], 'Password. should contain at least 6 characters.');
    endif;


    // Filter inputs
    if (!empty($_POST['name']) && strlen($_POST['name']) > 2 && !filter_var($_POST['name'], FILTER_SANITIZE_STRING)) :
        array_push($_SESSION['errorsRegister'], 'Name format is not correct.');
    endif;

    if (!empty($_POST['username']) && strlen($_POST['username']) > 2 && !filter_var($_POST['username'], FILTER_SANITIZE_STRING)) :
        array_push($_SESSION['errorsRegister'], 'Username format is not correct.');
    endif;


    // Check if the username is unique
    $users = unserializeArray();
    foreach ($users as $user) :
        if ($user['username'] == $_POST['username']) :
            array_push($_SESSION['errorsRegister'], 'This username is already taken.');
            break;
        endif;
    endforeach;
    /*
    * Inputs validation END
    */


    // If there's no error: add the user and redirect
    if (empty($_SESSION['errorsRegister'])) :

        // Unserialize users array
        $usersArray = unserializeArray();


        // Determine next ID
        if (!empty($usersArray))
            $id = end($usersArray)["id"];
        else
            $id = 0;


        // Hashing the password
        $_POST['password']  = password_hash($_POST['password'], PASSWORD_DEFAULT);


        // Insert the user in the array
        array_push($usersArray, [
            "id"        => ++$id,
            "name"      => $_POST["name"],
            "username"  => $_POST["username"],
            "password"  => $_POST["password"]
        ]);


        // Set Cookies
        if (isset($_SESSION['rememberReg'])) :
            // One year
            setcookie('auth', TRUE, time() + 31556926);
            setcookie('name', $_POST["name"], time() + 31556926);
            setcookie('last_login', time(), time() + 31556926);
        else :
            // One hour
            setcookie('auth', TRUE, time() + 3600);
            setcookie('name', $_POST["name"], time() + 3600);
            setcookie('last_login', time(), time() + 3600);
        endif;


        // Serrialize users array in users.txt
        serializeArray($usersArray);

        unset($_SESSION['nameReg']);
        unset($_SESSION['usernameReg']);
        unset($_SESSION['passwordReg']);
        unset($_SESSION['rememberReg']);


        // Redirect to the home page
        header('location: ./');
    endif;
endif;
/*
* Validation for 'Register' form END
*/