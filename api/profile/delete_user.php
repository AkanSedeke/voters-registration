<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    
    try {
        include_once "../utils/AuthMiddleware.php";
        
        if (isset($_GET['user_id']) && $_GET['user_id'] != '') {
            $userid = $_GET['user_id'];
            $update_sql = "DELETE FROM users WHERE id='$userid'";

            if ($conn->query($update_sql)) {
                header("HTTP/1 200");
                echo json_encode([
                    'success' => true,
                    'message' => 'User data deleted successfully',
                ]);
            } else {
                header("HTTP/1 500");
                echo json_encode([
                    'success' => false,
                    'message' => "An unexpected error occured."
                ]);
            }
        } else {
            header("HTTP/1 422");
            echo json_encode([
                'success' => false,
                'message' => "Cannot find the user record."
            ]);
        }
    } catch (\Throwable $th) {
        header("HTTP/1 " . (!is_null($th->getCode()) ? $th->getCode() : '500'));
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
    }

?>