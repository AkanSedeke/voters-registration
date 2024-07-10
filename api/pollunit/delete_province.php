<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    // Include Connect.php
    include_once '../utils/connect.php';

    $id = $_GET['id'];

    $sql = "DELETE FROM provinces WHERE id=$id";
    $result = $conn->query($sql);
    
    header("HTTP/1 200");
    echo json_encode([
        'success' => true,
        'message' => 'Province deleted successfully',
    ]);