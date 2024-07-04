<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once '../utils/connect.php';

try {

    // create users table structure if not exist
    $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        photo VARCHAR(255),
        role VARCHAR(100),
        created_at DATETIME DEFAULT(CURRENT_TIMESTAMP),
        updated_at DATETIME DEFAULT(CURRENT_TIMESTAMP)
    )";

    $conn->query($sqlUsers);

    // create Personal Access Token table structure if not exist
    $sqlAccessToken = "CREATE TABLE IF NOT EXISTS access_tokens (
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT(CURRENT_TIMESTAMP),
        expires_at DATETIME
    )";

    $conn->query($sqlAccessToken);
    
    // create voters table structure if not exist
    $sqlVoters = "CREATE TABLE IF NOT EXISTS voters (
        id INT AUTO_INCREMENT PRIMARY KEY,
        vote_id VARCHAR(255) NOT NULL,
        user_id INTEGER NOT NULL,
        phone VARCHAR(255),
        address VARCHAR(255),
        photo VARCHAR(255),
        polling_unit_id INTEGER,
        ward_id INTEGER,
        lga_id INTEGER,
        state_id INTEGER,
        country_id INTEGER,
        created_at DATETIME DEFAULT(CURRENT_TIMESTAMP),
        updated_at DATETIME DEFAULT(CURRENT_TIMESTAMP)
    )";

    $conn->query($sqlVoters);

    // Return success
    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'message' => 'All database table structure created successfuly'
    ]);
} catch (\Throwable $th) {
    header("HTTP/1 500");
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage()
    ]);
}
