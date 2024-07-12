<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    try {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
    
            $sql = "SELECT id, firstname, lastname, email, photo, role, phone, dob, bio, gender FROM users WHERE email = '$email' AND password='$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                header("HTTP/1 200");
                echo json_encode([
                    'success' => true,
                    'message' => 'User account created successfully',
                    'user' => $user,
                    'api_token' => getAccessToken($email, $conn)
                ]);
            } else {
                header("HTTP/1 402");
                echo json_encode([
                    'success' => false,
                    'message' => "Invalid email or password entered."
                ]);
            }
        } else {
            header("HTTP/1 422");
            echo json_encode([
                'success' => false,
                'message' => "Missing email or password parameters. Kindly ensure they were entered correctly"
            ]);
        }
    } catch (\Throwable $th) {
        header("HTTP/1 500");
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
    }
    

    function getAccessToken($email, $conn) {
        include_once "../utils/AuthToken.php";
        $expiry = time() + 60*60*24;
        $token = generateToken($email, $expiry);

        // Save Token
        if (userEmailExists($email, $conn)) {
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

    function userEmailExists($email, $conn) {
        $sql = "SELECT * FROM access_tokens WHERE email = '$email'";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }

?>