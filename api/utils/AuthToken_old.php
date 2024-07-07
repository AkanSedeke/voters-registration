<?php

    // Define a cryptographically secure secret key (store securely outside code)
    define('SECRET_KEY', 'voting_portal');

    // Function to generate a random string for token payload
    function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    // Function to generate a JWT (JSON Web Token)
    function generateToken($userId, $expiration = 3600, $data = []) { // Default expiration: 1 hour

        $header = [
            'alg' => 'HS256', // Use HMAC SHA-256 for signing
            'typ' => 'JWT'
        ];

        $payload = [
            'iss' => 'your_api_domain',  // Issuer (your API domain)
            'aud' => $userId,          // Audience (user ID for whom the token is issued)
            'exp' => time() + $expiration, // Expiration time
            'iat' => time(),             // Issued at time
            'data' => $data                // Optional custom data for the user
        ];

        // Encode header and payload using base64url encoding
        $encodedHeader = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $encodedPayload = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');

        // Create signature string
        $signature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", SECRET_KEY, true);
        $encodedSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        // Build the JWT string
        $token = "$encodedHeader.$encodedPayload.$encodedSignature";

        return $token;
    }

    // Example usage:
    // $userId = 123;  // Replace with actual user ID
    // $token = generateToken($userId);

    // echo $token;

    // Function to verify a JWT (JSON Web Token)
    function verifyToken($token) {

        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            throw new Exception('Invalid JWT format');
        }

        // Decode header, payload, and signature
        $header = json_decode(base64_decode(strtr($parts[0], '-_', '+/')), true);
        $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
        $signature = base64_decode(strtr($parts[2], '-_', '+/'));

        // Check signature validity using HMAC SHA-256
        $expectedSignature = hash_hmac('sha256', "$parts[0].$parts[1]", SECRET_KEY, true);
        if ($signature !== $expectedSignature) {
            throw new Exception('Invalid token signature');
        }

        // Validate expiration time
        if (isset($payload['exp']) && time() > $payload['exp']) {
            throw new Exception('Token expired');
        }

        // Additional checks (optional)
        // - Validate issuer (iss)
        // - Validate audience (aud)
        // - Check if specific claims exist in data

        return $payload; // Return decoded payload if valid
    }

    // // Check for Authorization header
    // if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    //     throw new Exception('Authorization header missing');
    // }

    // // Extract token from Authorization header
    // $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    // list($scheme, $token) = explode(' ', $authHeader, 2);  // Split by space

    // // Validate scheme (should be "Bearer")
    // if (strtolower($scheme) !== 'bearer') {
    //     throw new Exception('Invalid authorization scheme');
    // }

    // try {
    //     $decodedPayload = verifyToken($token);
    //     echo "Token is valid! User ID: " . $decodedPayload['aud']; // Example usage of data
    // } catch (Exception $e) {
    //     echo "Error: " . $e->getMessage();
    //     http_response_code(401); // Set unauthorized status code
    // }

    // Code From: https://stackoverflow.com/questions/40582161/how-to-properly-use-bearer-tokens
    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    function getBearerToken() {
        $headers = getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }



?>