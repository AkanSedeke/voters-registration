<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: *');
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    try {
        include_once "../utils/AuthMiddleware.php";

        echo json_encode([
            'auth' => $auth
        ]);
    } catch (\Throwable $th) {
        header("HTTP/1 " . $th->getCode());
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
    }

?>