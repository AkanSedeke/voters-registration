<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: *');
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    include_once "../utils/AuthToken.php";

    try {
        // Check for Authorization header
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new Exception('Authorization header missing', 401);
        }

        echo json_encode([
            'auth' => $_SERVER['HTTP_AUTHORIZATION']
        ]);
    } catch (\Throwable $th) {
        header("HTTP/1 " . $th->getCode());
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
    }

?>