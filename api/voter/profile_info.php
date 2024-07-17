<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    // Check for the request parameter (officer_id or voter_id)
    $user_id = $_GET['voter_id'];

    $sql = "SELECT * FROM voters JOIN users ON voters.user_id=users.id WHERE users.id='$user_id' ORDER BY users.firstname";


    $result = $conn->query($sql);

    $voter = $result->fetch_assoc();
    $voter['province'] = fetchProvinceDetials($voter['province_id'], $conn);
    $voter['polling_unit'] = fetchPollUnit($voter['polling_unit_id'], $conn);


    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'voter' => $voter,
        'message' => 'Voter record fetched successfully',
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