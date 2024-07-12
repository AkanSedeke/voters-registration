<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';
    
    try {
        include_once "../utils/AuthMiddleware.php";

        $userId = $auth->user['id']; // Get the authorized user

        $fetch_sql = "SELECT * FROM voters WHERE user_id='$userId'";
        $result = $conn->query($fetch_sql);

        if ($result->num_rows > 0) {
            $voter = $result->fetch_assoc();
            $voter['province'] = fetchProvince($voter['province_id'], $conn);
            $voter['polling_unit'] = fetchPollUnit($voter['polling_unit_id'], $conn);
            header("HTTP/1 200");
            echo json_encode([
                'success' => true,
                'voter' => $voter,
                'message' => 'voter records fetched successfully',
            ]);
        } else {
            header("HTTP/1 404");
            echo json_encode([
                'success' => false,
                'message' => "Voting credentials/record not found."
            ]);
        }
    } catch (\Throwable $th) {
        header("HTTP/1 " . (!is_null($th->getCode()) ? $th->getCode() : '500'));
        echo json_encode([
            'success' => false,
            'message' => $th->getMessage()
        ]);
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