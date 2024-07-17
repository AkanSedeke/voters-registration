<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    // Check for the request parameter (officer_id or voter_id)
    $user_id = $_GET['officer_id'];

    $sql = "SELECT * FROM users WHERE id='$user_id'";


    $result = $conn->query($sql);

    $officer = $result->fetch_assoc();


    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'officer' => $officer,
        'message' => 'officer record fetched successfully',
    ]);


    function fetchProvinceDetials($province_id, $conn){
        $sql = "SELECT id, province as name FROM provinces WHERE id='$province_id' LIMIT 1";
        $result = $conn->query($sql);
        return $province = $result->fetch_assoc();
    }

    function fetchPollUnit($unitId, $conn) {
        $sql = "SELECT id, punit_code, punit_address FROM polling_units WHERE id = '$unitId'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }