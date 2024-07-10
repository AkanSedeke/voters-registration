<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    
    $pollunit_id = $_POST['pollunit_id'];
    $address = $_POST['address'];
    $province_id = $_POST['province_id'];
    

    if (!pollUnitExists($pollunit_id, $conn)) {
        $insert_sql = "INSERT INTO polling_units(province_id, punit_code, punit_address) 
                        VALUES ('$province_id','$pollunit_id','$address')";
        $insert = $conn->query($insert_sql);
        
        try {
            if ($insert) {
                header("HTTP/1 200");
                echo json_encode([
                    'success' => true,
                    'message' => 'Polling Unit added successfully',
                ]);
            } else {
                header("HTTP/1 500");
                echo json_encode([
                    'success' => false,
                    'message' => "An unexpected error occured."
                ]);
            }
        } catch (\Throwable $th) {
            header("HTTP/1 500");
            echo json_encode([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }else{
        header("HTTP/1 422");
        echo json_encode([
            'success' => false,
            'message' => "Polling Unit already exists."
        ]);
    }

    function pollUnitExists($unit_code, $conn) {
        $sql = "SELECT * FROM polling_units WHERE punit_code = '$unit_code'";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }

?>