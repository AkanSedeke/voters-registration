<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    
    try {
        include_once "../utils/AuthMiddleware.php";
        
        if (isset($_POST['voter_id']) || isset($_POST['vote_phone']) || isset($_POST['vote_address'])) {
            // Recieve data from $_POST requests
            $voter_id = $_POST['voter_id'];
            $vote_phone = $_POST['vote_phone'];
            $vote_address = $_POST['vote_address'];
            $province_id = isset($_POST['vote_province']) ? $_POST['vote_province'] : null;
            $poll_unit_id = isset($_POST['poll_unit']) ? $_POST['poll_unit'] : null;
            $userid = $auth->user['id'];

            $update_sql = "UPDATE voters SET vote_id='$voter_id', phone='$vote_phone', address='$vote_address',
                        polling_unit_id='$poll_unit_id', province_id='$province_id' WHERE user_id='$userid'";

            if ($conn->query($update_sql)) {
                header("HTTP/1 200");
                echo json_encode([
                    'success' => true,
                    'message' => 'voter information updated successfully',
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
                'message' => "Some required fields are missing."
            ]);
        }
    } catch (\Throwable $th) {
        header("HTTP/1 " . (!is_null($th->getCode()) ? $th->getCode() : '500'));
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
    }


    function getUserData($userid, $conn) {
        $sql = "SELECT id, firstname, lastname, email, photo, role, phone, dob, bio, gender FROM users WHERE id = '$userid'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

?>