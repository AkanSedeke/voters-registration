<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    $officers = array();

    // Form the SQL String Based on Search Criteria
    if (isset($_GET['search']) && $_GET['search'] != "") {
        $sql = "SELECT * FROM users  WHERE role='officer' ";

        // if search search value is present
        if ((isset($_GET['search']) && ($_GET['search'] != ""))) {
            $searchValue = $_GET['search']; // Get the value from the request into a serchValue varable
            $sql .= "AND (lastname LIKE '%$searchValue%' OR firstname LIKE '%$searchValue%') ";
        }

        // Order the query results
        $sql .= "ORDER BY firstname";
    } else {
        // If no search criteria, fetch all polling units
        $sql = "SELECT * FROM users  WHERE role='officer' ORDER BY firstname";
    }

    // echo "hhh:" . $sql;


    $result = $conn->query($sql);
    while($officer = $result->fetch_assoc()) {
        array_push($officers, $officer);  
    }


    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'officers' => $officers,
        'message' => 'officers record fetched successfully',
    ]);
