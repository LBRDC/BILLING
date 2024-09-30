<?php 
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$disable_EmpId = isset($_POST['disable_EmpId'])? $_POST['disable_EmpId'] : '';
$disable_EmpName = isset($_POST['disable_EmpName'])? $_POST['disable_EmpName'] : '';
$disable_EmpStatus = isset($_POST['disable_EmpStatus'])? $_POST['disable_EmpStatus'] : '';

// Check if all required variables contain values
if($disable_EmpId === '' || $disable_EmpName === '' || $disable_EmpStatus === '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_id = :disable_EmpId");
    $stmt1->bindParam(':disable_EmpId', $disable_EmpId);
    $stmt1->execute();

    // Check if the employee already exists
    if($stmt1->rowCount() == 0){
        $response["res"] = "norecord";
        throw new Exception("{$disable_EmpName} not found.");
    }
    
    // If Status is 1, set it to 0 before updating
    if ($disable_EmpStatus == 1) {
        $disable_EmpStatus = 0;
    }

    $stmt3 = $conn->prepare("UPDATE employee_tbl SET emp_status = :disable_EmpStatus WHERE emp_id = :disable_EmpId");
    $stmt3->bindParam(':disable_EmpStatus', $disable_EmpStatus);
    $stmt3->bindParam(':disable_EmpId', $disable_EmpId);
    
    if(!$stmt3->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to disable employee.");
    }

    //Log
    $log_page = "employee";
    $log_action = "Disabled Employee" . "-" . $disable_EmpId;

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
    $response["msg"] = $disable_EmpName;
    
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