<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Include Connect.php
include_once '../utils/connect.php';

$stats = array();

try{

    $stats['no_voter'] = getVoterCount($conn);
    $stats['no_officer'] = count(getOfficer($conn));
    $stats['no_province'] = getProvinceCount($conn);
    $stats['no_poll_unit'] = getPUnitCount($conn);
    $stats['voter_list'] = getVoter($conn);
    $stats['officer_list'] = getOfficer($conn);

    header('HTTP/1 200');
    echo json_encode([
        'success' => true,
        'stats' => $stats
    ]);
}catch(Throwable $th){
    header('HTTP/1 ' . !empty($th->getCode()) ? $th->getCode() : '500');
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage(),
    ]);
}



// Create Functions to get all statistics
function getVoterCount($conn) {
    $sqlString = "SELECT * FROM voters";
    $voter = $conn->query($sqlString);

    return $voter->num_rows;
}

function getVoter($conn) {
    $sqlString = "SELECT voters.user_id, voters.vote_id, voters.province_id, voters.polling_unit_id, users.id, users.firstname, users.lastname 
        FROM voters JOIN users ON users.id=voters.user_id LIMIT 10";
    $result = $conn->query($sqlString);

    $voters = array();

    while ($voter = $result->fetch_assoc()) {
        $voter['polling_unit'] = fetchPollUnit($voter['polling_unit_id'], $conn);
        unset($voter['polling_unit_id']);
        $voter['province'] = fetchProvince($voter['province_id'], $conn);
        unset($voter['province_id']);
        array_push($voters, $voter);
    }

    return $voters;
}

function getOfficer($conn) {
    $sqlString = "SELECT * FROM users WHERE role='officer'";
    $result = $conn->query($sqlString);

    $officers = array();

    while ($officer = $result->fetch_assoc()) {
        array_push($officers, $officer);
    }

    return $officers;
}

function getProvinceCount($conn) {
    $sqlString = "SELECT * FROM provinces";
    $voter = $conn->query($sqlString);

    return $voter->num_rows;
}

function getPUnitCount($conn) {
    $sqlString = "SELECT * FROM polling_units";
    $pollUnits = $conn->query($sqlString);

    return $pollUnits->num_rows;
}

function fetchProvince($provinceId, $conn) {
    $sql = "SELECT id, province as name FROM provinces WHERE id = '$provinceId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
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


?>