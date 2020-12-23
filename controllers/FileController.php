<?php
@session_start();

// Create User or Client file to store their information
function createFile($file)
{
    if ($file == 'client') :
        $clientFile     = fopen("clients.txt", "a+");
        if ($clientFile) :
            $_SESSION['createdClientFile'] = TRUE;
            header('location: ./addClient');
            exit();
        endif;
    elseif ($file == 'user') :
        $userFile       = fopen("users.txt", "a+");
        if ($userFile) :
            $_SESSION['createdUserFile'] = TRUE;
            header('location: ./register');
            exit();
        endif;
    endif;
}


// Delete User or Client file
function deleteFile($file)
{
    if ($file == 'client') :
        $clientFile     = unlink('clients.txt');
        if ($clientFile) :
            header('location: ./');
            exit();
        endif;
    elseif ($file == 'user') :
        $userFile       = unlink('users.txt');
        if ($userFile) :
            header('location: ./logout');
            exit();
        endif;
    endif;
}


// Check if the file exists
function checkFile($file)
{
    if ($file == 'client') :
        $path = 'clients.txt';
        try {
            if (!file_exists($path)) :
                throw new Exception("Client file doesn't exist. Kindly, create one!");
                exit();
            endif;
        } catch (Exception $e) {
            header('location: error?c=1');
        }
        return true;
    elseif ($file == 'user') :
        $path = 'users.txt';
        try {
            if (!file_exists($path)) :
                throw new Exception("User file doesn't exist. Kindly, create one!");
                exit();
            endif;
        } catch (Exception $e) {
            header('location: error?u=1');
        }
        return true;
    endif;
}
