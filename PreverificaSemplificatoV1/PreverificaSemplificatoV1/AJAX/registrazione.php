<?php
include_once("../classes/GestioneUtenti.php");
include_once("../classes/Emailer.php");

$gestioneUtenti = new GestioneUtenti();
$response;

$checkID = 0;

if (isset($_GET["username"]) && isset($_GET["password"])) {
    $username = $_GET["username"];
    $password = $_GET["password"];

    $checkID = $gestioneUtenti->checkCredentials($username, $password);
    if ($username != "" && $password != "") {
        if ($checkID != 0) {
            $response = array("status" => "Error", "message" => "Utente già esistente");
        } else {
            $gestioneUtenti->addUser($username, $password);
            $response = array("status" => "Ok", "message" => "Utente registrato!");
        }
    }
}

echo json_encode($response);
