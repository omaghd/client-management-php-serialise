<?php
@session_start();

$path = "clients.txt";


// Add Cew Client
function create($clients)
{
    global $path;

    // Check if the Client' file exists
    checkFile('client');


    // Determine the next Client' ID
    if (!empty($clients))
        // Return the last Client' ID 
        $id = end($clients)["id"];
    else
        $id = 0;


    // Add the client to the array
    array_push($clients, [
        "id"        => ++$id,
        "name"      => $_POST["name"],
        "address"   => $_POST["address"],
        "tel"       => $_POST["tel"]
    ]);

    // A variable for alert 
    $_SESSION['add'] = TRUE;

    // Unset sessions
    unset($_SESSION['nameAdd']);
    unset($_SESSION['addressAdd']);
    unset($_SESSION['telAdd']);
    unset($_SESSION['NoClient']);

    return $clients;
}


// Retrieve all clients information
function retrieve()
{
    global $path;

    // Check if the Client' file exists
    checkFile('client');

    $content        = file_get_contents($path);
    $clientsArray   = unserialize($content);

    return $clientsArray;
}


// Update a client information
function update($clients)
{
    for ($i = 0; $i < count($clients); $i++) :
        if ($clients[$i]["id"] == $_POST["id"]) :
            $clients[$i]["name"]    = $_POST["name"];
            $clients[$i]["address"] = $_POST["address"];
            $clients[$i]["tel"]     = $_POST["tel"];
        endif;
    endfor;

    // A variable for alert 
    $_SESSION['update'] = TRUE;

    // Unset sessions
    unset($_SESSION['idClient']);
    unset($_SESSION['nameEdit']);
    unset($_SESSION['addressEdit']);
    unset($_SESSION['telEdit']);

    return $clients;
}


// Remove a client information
function remove($clients)
{
    $id = $_POST["idClient"];

    for ($i = 0; $i < count($clients); $i++) :
        if ($clients[$i]["id"] == $id) :
            array_splice($clients, $i, 1);
            break;
        endif;
    endfor;

    // A variable for alert 
    $_SESSION['remove'] = TRUE;

    return $clients;
}
