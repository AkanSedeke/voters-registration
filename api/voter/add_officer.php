<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    
    try {
        // include_once "../utils/AuthMiddleware.php";
        
        if (isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['email'])) {
            // Recieve data from $_POST requests
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
            $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
            $dob = isset($_POST['dob']) ? $_POST['dob'] : null;
            $bio = isset($_POST['bio']) ? $_POST['bio'] : null;
            $password = md5('123456');

            // Restrict Date of birth
            $yob = (int)date('Y', strtotime($dob));
            $currentYear = (int)date('Y', time());
            if (($currentYear - $yob) < 18) {
                throw new Exception("Officer can't be less than 18 years!", 422);
            }

            // Check if the request has file
            $imagePath = null;
            if(file_exists($_FILES['profile_image']['tmp_name']) || is_uploaded_file($_FILES['profile_image']['tmp_name'])) {
                $imagePath = uploadImage($_FILES['profile_image']);
            }

            // Insert Query String
            $insert_sql = "INSERT INTO users(firstname, lastname, email, phone, gender, dob, bio, photo, password, role)
                         VALUES('$firstname', '$lastname', '$email', '$phone', '$gender', '$dob', '$bio', '$imagePath', '$password', 'officer')";
            

            if ($conn->query($insert_sql)) {
                header("HTTP/1 200");
                echo json_encode([
                    'success' => true,
                    'message' => 'User data inserted successfully',
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

    function uploadImage($imageFile) {
        $target_dir = "../../public/assets/images/users/";
        $filename = time() . basename($imageFile["name"]);
        $target_file = $target_dir . $filename;
        $tempName = $imageFile['tmp_name'];
        $imagePath = "assets/images/users/" . $filename;

        if (move_uploaded_file($tempName, $target_file)) {
            return $imagePath;
        }else{
            return null;
        }
    }

?>