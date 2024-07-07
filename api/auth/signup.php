<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = getUserRole($conn);

    if (!userEmailExists($email, $conn)) {
        $insert_sql = "INSERT INTO users(firstname,lastname,email,password,role) 
                VALUES ('$firstname','$lastname','$email','$password', '$role')";
        $insert = $conn->query($insert_sql);
        
        try {
            if ($insert) {
                $user = getUserData($email, $conn); // Fetch the stored user data

                // If role is voter, store the record on the voter's database table as well
                if ($role == 'voter') {
                    $voter_id = time();
                    $user_id = $user['id'];

                    $insert_voter_sql = "INSERT INTO voters(vote_id,user_id) 
                                            VALUES ('$voter_id','$user_id')";
                    $insert = $conn->query($insert_voter_sql);
                }

                header("HTTP/1 200");
                echo json_encode([
                    'success' => true,
                    'message' => 'User account created successfully',
                    'user' => $user,
                    'api_token' => getAccessToken($email, $conn)
                ]);
            } else {
                header("HTTP/1 500");
                echo json_encode([
                    'success' => false,
                    'message' => "An unexpected error occured."
                ]);
            }
        } catch (\Throwable $th) {
            header("HTTP/1 500");
            echo json_encode([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }

    }else{
        header("HTTP/1 422");
        echo json_encode([
            'success' => false,
            'message' => "User with username or email already exists."
        ]);
    }

    function getUserRole($conn) {
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return 'voter';
        } else {
            return 'admin';
        }
    }

    function userEmailExists($email, $conn) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }

    function getUserData($email, $conn) {
        $sql = "SELECT id, firstname, lastname, email, photo, role FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }


    function getAccessToken($email, $conn) {
        include_once "../utils/AuthToken.php";
        $expiry = time() + 60*60*24;
        $token = generateToken($email, $expiry);

        // Save Token
        if (userAccessEmailExists($email, $conn)) {
            $sql = "UPDATE access_tokens SET token ='$token', expires_at='$expiry' WHERE email = '$email'";
        } else {
            $sql = "INSERT INTO access_tokens(email, token, expires_at) VALUES('$email','$token','$expiry')";
        }

        $result = $conn->query($sql);
        if ($result) {
            return $token;
        } else {
            return null;
        }
    }

    function userAccessEmailExists($email, $conn) {
        $sql = "SELECT * FROM access_tokens WHERE email = '$email'";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }


?>