<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    $provinces = array();

    $sql = "SELECT * FROM provinces ORDER BY province";
    $result = $conn->query($sql);
    while($province = $result->fetch_assoc()) {
        array_push($provinces, $province);
    }


    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'provinces' => $provinces,
        'message' => 'Province fetched successfully',
    ]);