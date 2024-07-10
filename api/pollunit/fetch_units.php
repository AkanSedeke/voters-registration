<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    $poll_units = array();

    // Form the SQL String Based on Search Criteria
    if ((isset($_GET['search']) && ($_GET['search'] != "")) || (isset($_GET['province_id']) && ($_GET['province_id'] != ""))) {
        $sql = "SELECT * FROM polling_units ";

        // if search search value is present
        if ((isset($_GET['search']) && ($_GET['search'] != ""))) {
            $searchValue = $_GET['search']; // Get the value from the request into a serchValue varable
            $sql .= "WHERE (punit_code LIKE '%$searchValue%' OR punit_address LIKE '%$searchValue%') ";
        }

        // if province_id value is present
        if (isset($_GET['province_id']) && ($_GET['province_id'] != "")) {
            $province_id = $_GET['province_id']; // Get the value from the request into a serchValue varable
            if($_GET['search'] != ""){
                $sql .= "AND province_id = '$province_id' "; // Add AND Logical operator if the search value criteria above is present
            }else{
                $sql .= "WHERE province_id = '$province_id' "; // Otherwise, use only this criteria with a WHERE Clause
            }
            
        }

        // Order the query results
        $sql .= "ORDER BY punit_code";
    } else {
        // If no search criteria, fetch all polling units
        $sql = "SELECT * FROM polling_units ORDER BY punit_code";
    }

    // echo "hhh:" . $sql;


    $result = $conn->query($sql);
    while($unit = $result->fetch_assoc()) {
        $unit['province'] = fetchProvinceDetials($unit['province_id'], $conn);
        array_push($poll_units, $unit);  
    }


    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'units' => $poll_units,
        'message' => 'Polling Units fetched successfully',
    ]);


    function fetchProvinceDetials($province_id, $conn){
        $sql = "SELECT id, province as name FROM provinces WHERE id='$province_id' LIMIT 1";
        $result = $conn->query($sql);
        return $province = $result->fetch_assoc();
    }