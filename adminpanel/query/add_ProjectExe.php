<?php 
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$add_PrjName = isset($_POST['add_PrjName'])? $_POST['add_PrjName'] : '';
$add_PrjDesc = isset($_POST['add_PrjDesc'])? $_POST['add_PrjDesc'] : '';
$add_PrjContactNo = isset($_POST['add_PrjContactNo'])? $_POST['add_PrjContactNo'] : '';
$add_PrjEmail = isset($_POST['add_PrjEmail'])? $_POST['add_PrjEmail'] : '';
$add_PrjAddress = isset($_POST['add_PrjAddress'])? $_POST['add_PrjAddress'] : '';
$add_Status = 1;
$add_Created = date("Y-m-d");

// Check if all required variables contain values
if(empty($add_PrjName)) {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM project_tbl WHERE project_name = :add_PrjName");
    $stmt1->bindParam(':add_PrjName', $add_PrjName);
    $stmt1->execute();

    // Check if the project name already exists
    if($stmt1->rowCount() > 0){
        $response["res"] = "exists";
        throw new Exception("{$add_PrjName} already exists.");
    }

    // Prepare and execute the second statement to insert the new project
    $stmt2 = $conn->prepare("INSERT INTO project_tbl (project_name, project_description, project_contactno, project_email, project_address, project_status, project_created) VALUES (:add_PrjName, :add_PrjDesc, :add_PrjContactNo, :add_PrjEmail, :add_PrjAddress, :add_Status, :add_Created)");
    $stmt2->bindParam(':add_PrjName', $add_PrjName);
    $stmt2->bindParam(':add_PrjDesc', $add_PrjDesc);
    $stmt2->bindParam(':add_PrjContactNo', $add_PrjContactNo);
    $stmt2->bindParam(':add_PrjEmail', $add_PrjEmail);
    $stmt2->bindParam(':add_PrjAddress', $add_PrjAddress);
    $stmt2->bindParam(':add_Status', $add_Status);
    $stmt2->bindParam(':add_Created', $add_Created);

    // Execute the statement
    if(!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to insert project.");
    }

    // Get the ID of the newly inserted billing record
    $lastInsertedProjectId = $conn->lastInsertId();

    //Log
    $log_page = "project";
    $log_action = "Add Project" . "-" . $lastInsertedProjectId;

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

    // Commit the transaction
    $conn->commit();

    $response["res"] = "success";
    $response["msg"] = $add_PrjName;
    echo json_encode($response);
} catch (Exception $e) {
    // An error occurred; rollback the transaction
    $conn->rollBack();
    $response["msg"] = $e->getMessage();
    echo json_encode($response);
}

exit();