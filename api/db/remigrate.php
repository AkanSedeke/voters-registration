<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once '../utils/connect.php';

    
    // create users table structure if not exist
    $sqlUsers = "DROP DATABASE IF EXISTS voting_uk";
    
    // create users table structure if not exist
    $sqlUsers = "DROP TABLE IF EXISTS users";

    $conn->query($sqlUsers);

    // create Personal Access Token table structure if not exist
    $sqlAccessToken = "DROP TABLE IF EXISTS access_tokens";

    $conn->query($sqlAccessToken);
    
    // create voters table structure if not exist
    $sqlVoters = "DROP TABLE IF EXISTS voters";

    $conn->query($sqlVoters);

    // create province table structure if not exist
    $sqlProvinces = "DROP TABLE IF EXISTS provinces";

    $conn->query($sqlProvinces);

    // create polling unit table structure if not exist
    $sqlPollingUnit = "DROP TABLE IF EXISTS polling_units";

    $conn->query($sqlPollingUnit);

    include_once 'migrate.php';