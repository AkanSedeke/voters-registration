<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    
    $province = $_POST['province'];
    

    if (!provinceExists($province, $conn)) {
        $insert_sql = "INSERT INTO provinces(province) VALUES ('$province')";
        $insert = $conn->query($insert_sql);
        
        try {
            if ($insert) {
                header("HTTP/1 200");
                echo json_encode([
                    'success' => true,
                    'message' => 'Province added successfully',
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
            'message' => "Provinced already exists."
        ]);
    }

    function provinceExists($province, $conn) {
        $sql = "SELECT * FROM provinces WHERE province = '$province'";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }

?>