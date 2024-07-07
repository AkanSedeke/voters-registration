<?php

    include_once 'AuthToken.php';

    $headers = null; // Initialize headers to null

    // Check for Authorization header on the global server varaible $_SERVER and assign it to headers
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) { // If Authorization not found, search for HTTP_AUTHORIZATION
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } 
    elseif (function_exists('apache_request_headers')) { // If HTTP_AUTHORIZATION not found, check if apache_request_headers function exists
        $requestHeaders = apache_request_headers();
        
        if (isset($requestHeaders['Authorization'])) { // Check if the Authorization header exists on the apache_request_headers function
            $headers = trim($requestHeaders['Authorization']);
        }
    }

    // If at this point, the $headers variable is still null, throw an exception for unauthorized access.
    if ($headers == null) {
        throw new Exception("Request Unauthorized", 401);
    }

    // Extract token from Authorization header
    list($scheme, $token) = explode(' ', $headers, 2);  // Split by space

    // Validate scheme (should be "Bearer")
    if (strtolower($scheme) !== 'bearer') {
        throw new Exception('Invalid authorization scheme', 401);
    }
    
    $auth = verifyToken($token);


?>