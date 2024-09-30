<?php 
session_start();
include("../../conn.php");

extract($_POST);

// $stmt = $conn->prepare("SELECT * FROM admin_user WHERE admin_username = :ad_username AND admin_password = :ad_password AND admin_status = 1");
$stmt = $conn->prepare("SELECT * FROM admin_user WHERE admin_username = :ad_username AND admin_password = :ad_password ");
$stmt->bindParam(':ad_username', $username);
$stmt->bindParam(':ad_password', $pass);

// Execute the statement and check if it was successful
if ($stmt->execute()) {
    $admin_Acc = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the fetch operation was successful
    if ($admin_Acc) {
        $_SESSION['user'] = array(
            'admin_fname' => $admin_Acc['admin_fname'],
            'admin_lname' => $admin_Acc['admin_lname'],
            'admin_pos' => $admin_Acc['admin_pos'],
            'admin_super' => $admin_Acc['admin_super'],
            'user_role' => $admin_Acc['roles']
        );
        $res = array("res" => "success");
    } else {
        $res = array("res" => "failed");
    }
} else {
    // Handle the error, for example, by logging it or displaying a message
    $res = array("res" => "failed");
}

echo json_encode($res);