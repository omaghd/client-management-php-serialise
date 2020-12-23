<?php

// Determine the path
isset($_POST['login']) || isset($_POST['register']) ? $path = "users.txt" : $path = "clients.txt";

// Serialize function
function serializeArray($array)
{
    global $path;

    $array = serialize($array);
    file_put_contents($path, $array);
}


// Unserialize function
function unserializeArray()
{
    global $path;

    $content        = file_get_contents($path);

    if (!empty($content))
        $array    = unserialize($content);
    else
        $array    = [];

    return $array;
}
