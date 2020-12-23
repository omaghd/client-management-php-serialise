<?php
@session_start();

// Initiate errors session as an array
$_SESSION['errors']         = [];


// Sanitize inputs function 
function sanitize($input)
{
    $input = trim($input);
    $input = strip_tags($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = str_replace('"', "&quot;", $input);
    $input = str_replace("'", "&apos;", $input);

    return $input;
}


// Validation for 'New Client' & 'Edit Client' forms
if (isset($_POST['add']) || isset($_POST['edit'])) :

    // Sanitize inputs
    $_POST['name']      = sanitize($_POST['name']);
    $_POST['address']   = sanitize($_POST['address']);
    $_POST['tel']       = sanitize($_POST['tel']);

    // Match Tel. input with its correct format
    $_POST['tel']       = preg_replace('/[^0-9+-]/', '', $_POST['tel']);

    // Creating session
    if (isset($_POST['add'])) :
        $_SESSION['nameAdd']       = $_POST['name'];
        $_SESSION['addressAdd']    = $_POST['address'];
        $_SESSION['telAdd']        = $_POST['tel'];
    endif;

    if (isset($_POST['edit'])) :
        $_SESSION['idClient']       = $_POST['id'];
        $_SESSION['nameEdit']       = $_POST['name'];
        $_SESSION['addressEdit']    = $_POST['address'];
        $_SESSION['telEdit']        = $_POST['tel'];
    endif;


    // Check if inputs are filled
    if (empty($_POST['name'])) :
        array_push($_SESSION['errors'], 'Name field is required.');
    endif;

    if (empty($_POST['address'])) :
        array_push($_SESSION['errors'], 'Address field is required.');
    endif;

    if (empty($_POST['tel'])) :
        array_push($_SESSION['errors'], 'Tel. field is required.');
    endif;


    // Check input' length
    if (!empty($_POST['name']) && strlen($_POST['name']) < 3) :
        array_push($_SESSION['errors'], 'Name should contain at least 3 characters.');
    endif;

    if (!empty($_POST['address']) && strlen($_POST['address']) < 6) :
        array_push($_SESSION['errors'], 'Address should contain at least 6 characters.');
    endif;

    if (!empty($_POST['tel']) && strlen($_POST['tel']) < 10) :
        array_push($_SESSION['errors'], 'Tel. should contain at least 10 characters.');
    endif;


    // Filter inputs
    if (!empty($_POST['name']) && strlen($_POST['name']) > 2 && !filter_var($_POST['name'], FILTER_SANITIZE_STRING)) :
        array_push($_SESSION['errors'], 'Name format is not correct.');
    endif;

    if (!empty($_POST['address']) && strlen($_POST['address']) > 5 && !filter_var($_POST['address'], FILTER_SANITIZE_STRING)) :
        array_push($_SESSION['errors'], 'Adress format is not correct.');
    endif;

    if (!empty($_POST['tel']) && strlen($_POST['tel']) > 9 && !filter_var($_POST['tel'], FILTER_SANITIZE_NUMBER_INT)) :
        array_push($_SESSION['errors'], 'Tel. format is not correct.');
    endif;


    // Redirect after validation
    if (!empty($_SESSION['errors']) && isset($_POST['add'])) :
        header('location: addClient');
    elseif (!empty($_SESSION['errors']) && isset($_POST['edit'])) :
        header('location: editClient');
    endif;

endif;
