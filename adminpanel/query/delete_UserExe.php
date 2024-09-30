<?php 
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$delete_UserId = isset($_POST['delete_UserId']) ? $_POST['delete_UserId'] : '';

if(empty($delete_UserId)) {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM admin_user WHERE admin_id = :delete_UserId");
    $stmt1->bindParam(':delete_UserId', $delete_UserId);
    $stmt1->execute();
    
    if($stmt1->rowCount() == 0){
        $response["res"] = "norecord";
        throw new Exception("{$delete_UserId} does not exists.");
    }

    // Prepare and execute the second statement to insert the new project
    $stmt2 = $conn->prepare("DELETE FROM admin_user WHERE admin_id = :delete_UserId");
    $stmt2->bindParam(':delete_UserId', $delete_UserId);
    
    // Execute the statement
    if(!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to delete user.");
    }

    //Log
    $log_page = "admin";
    $log_action = "Delete User" . "-" . $delete_UserId;

    if (isset($_SESSION['user']['admin_fname']) && isset($_SESSION['user']['admin_lname'])) {
        $fname = $_SESSION['user']['admin_fname'];
        $lname = $_SESSION['user']['admin_lname'];
        $log_user = $fname.' '.$lname;
    } else {
        //$log_user = 'ERR';
        $response["res"] = "failed";
        throw new Exception("Failed to find user.");
    }

    $stmt3 = $conn->prepare("INSERT INTO admin_editlog (log_page, log_action, log_user) VALUES (:log_page, :log_action, :log_user)");
    $stmt3->bindParam(':log_page', $log_page);
    $stmt3->bindParam(':log_action', $log_action);
    $stmt3->bindParam(':log_user', $log_user);

    // Execute the statement
    if(!$stmt3->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to insert log.");
    }
    
    $response["res"] = "success";
    $response["msg"] = $delete_UserId;

    // Commit the transaction
    $conn->commit();

    echo json_encode($response);
} catch (Exception $e) {
    // An error occurred; rollback the transaction
    $conn->rollBack();
    $response["msg"] = $e->getMessage();
    echo json_encode($response);
}

exit();