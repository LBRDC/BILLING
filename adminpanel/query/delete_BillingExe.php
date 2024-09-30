<?php 
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$delete_BillingId = isset($_POST['delete_BillingId'])? $_POST['delete_BillingId'] : '';

// Check if all required variables contain values
if(empty($delete_BillingId)) {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM billing_tbl WHERE bill_id = :delete_BillingId");
    $stmt1->bindParam(':delete_BillingId', $delete_BillingId);
    $stmt1->execute();

    if($stmt1->rowCount() <= 0){
        $response["res"] = "norecord";
        throw new Exception("Billing {$delete_BillingId} does not exists.");
    }

    // Prepare and execute the second statement to insert the new project
    $stmt2 = $conn->prepare("UPDATE billing_tbl SET bill_status = 3 WHERE bill_id = :delete_BillingId");
    $stmt2->bindParam(':delete_BillingId', $delete_BillingId);

    // Execute the statement
    if(!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to insert project.");
    }

    //Log
    $log_page = "billing";
    $log_action = "Delete Billing" . "-" . $delete_BillingId;

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
    $response["msg"] = $delete_BillingId;

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