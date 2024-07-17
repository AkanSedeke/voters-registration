<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    $voters = array();

    // Form the SQL String Based on Search Criteria
    if ((isset($_GET['search']) && ($_GET['search'] != "")) || (isset($_GET['province_id']) && ($_GET['province_id'] != ""))) {
        $sql = "SELECT * FROM voters JOIN users ON voters.user_id=users.id ";

        // if search search value is present
        if ((isset($_GET['search']) && ($_GET['search'] != ""))) {
            $searchValue = $_GET['search']; // Get the value from the request into a serchValue varable
            $sql .= "WHERE (users.lastname LIKE '%$searchValue%' OR users.firstname LIKE '%$searchValue%') ";
        }

        // if province_id value is present
        if (isset($_GET['province_id']) && ($_GET['province_id'] != "")) {
            $province_id = $_GET['province_id']; // Get the value from the request into a serchValue varable
            if(isset($_GET['search'])){
                $sql .= "AND voters.province_id = '$province_id' "; // Add AND Logical operator if the search value criteria above is present
            }else{
                $sql .= "WHERE voters.province_id = '$province_id' "; // Otherwise, use only this criteria with a WHERE Clause
            }
        }

        // Order the query results
        $sql .= "ORDER BY users.firstname";
    } else {
        // If no search criteria, fetch all polling units
        $sql = "SELECT * FROM voters JOIN users ON voters.user_id=users.id ORDER BY users.firstname";
    }

    // echo "hhh:" . $sql;


    $result = $conn->query($sql);
    while($voter = $result->fetch_assoc()) {
        $voter['province'] = fetchProvinceDetials($voter['province_id'], $conn);
        $voter['polling_unit'] = fetchPollUnit($voter['polling_unit_id'], $conn);
        array_push($voters, $voter);  
    }


    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'voters' => $voters,
        'message' => 'Voters record fetched successfully',
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