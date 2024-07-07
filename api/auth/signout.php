<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: *');
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    try {
        include_once "../utils/AuthMiddleware.php";

        if (deleteToken($auth->token)) {
            header("HTTP/1 200");
            echo json_encode([
                'success' => true,
                'message' => 'Logout successfully',
            ]);
        }else{
            header("HTTP/1 500");
            echo json_encode([
                'success' => false,
                'message' => 'Could logout due to an unexpected error.',
            ]);
        }
    } catch (\Throwable $th) {
        header("HTTP/1 " . $th->getCode());
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
    }

?>