<?php 
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$edit_PrjId = isset($_POST['edit_PrjId'])? $_POST['edit_PrjId'] : '';
$edit_PrjName = isset($_POST['edit_PrjName'])? $_POST['edit_PrjName'] : '';
$edit_PrjDesc = isset($_POST['edit_PrjDesc'])? $_POST['edit_PrjDesc'] : '';
$edit_PrjContactNo = isset($_POST['edit_PrjContactNo'])? $_POST['edit_PrjContactNo'] : '';
$edit_PrjEmail = isset($_POST['edit_PrjEmail'])? $_POST['edit_PrjEmail'] : '';
$edit_PrjAddress = isset($_POST['edit_PrjAddress'])? $_POST['edit_PrjAddress'] : '';
$edit_PrjStatus = isset($_POST['edit_PrjStatus'])? $_POST['edit_PrjStatus'] : '';

// Check if all required variables contain values
if($edit_PrjId === '' || $edit_PrjName === '' || $edit_PrjStatus === '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM project_tbl WHERE project_id = :edit_PrjId");
    $stmt1->bindParam(':edit_PrjId', $edit_PrjId);
    $stmt1->execute();

    // Check if the project already exists
    if($stmt1->rowCount() <= 0){
        $response["res"] = "norecord";
        throw new Exception("Project {$edit_PrjName} not found.");
    }

    // If the ID exists, proceed with checking if the name exists excluding the current record
    $stmt2 = $conn->prepare("SELECT * FROM project_tbl WHERE project_name = :edit_PrjName AND project_id != :edit_PrjId");
    $stmt2->bindParam(':edit_PrjName', $edit_PrjName);
    $stmt2->bindParam(':edit_PrjId', $edit_PrjId);
    $stmt2->execute();

    if($stmt2->rowCount() > 0){
        $response["res"] = "exists";
        throw new Exception("{$edit_PrjName} already exists.");
    }

    //INSERT INTO `project_tbl`(`project_id`, `project_category`, `project_name`, `project_description`, `project_contactno`, `project_email`, `project_address`, `project_status`, `project_created`, `project_timestamp`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
    $stmt3 = $conn->prepare("UPDATE project_tbl SET project_name = :edit_PrjName, project_description = :edit_PrjDesc, project_contactno = :edit_PrjContactNo, project_email = :edit_PrjEmail, project_address = :edit_PrjAddress, project_status = :edit_PrjStatus WHERE project_id = :edit_PrjId");
    $stmt3->bindParam(':edit_PrjName', $edit_PrjName);
    $stmt3->bindParam(':edit_PrjDesc', $edit_PrjDesc);
    $stmt3->bindParam(':edit_PrjContactNo', $edit_PrjContactNo);
    $stmt3->bindParam(':edit_PrjEmail', $edit_PrjEmail);
    $stmt3->bindParam(':edit_PrjAddress', $edit_PrjAddress);
    $stmt3->bindParam(':edit_PrjStatus', $edit_PrjStatus);
    $stmt3->bindParam(':edit_PrjId', $edit_PrjId);
    
    if(!$stmt3->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to update project.");
    }


    //Log
    $log_page = "project";
    $log_action = "Edit Project" . "-" . $edit_PrjId;

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
    $response["msg"] = $edit_PrjName;

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