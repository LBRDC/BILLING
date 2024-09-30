<?php 
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$enable_PrjId = isset($_POST['enable_PrjId'])? $_POST['enable_PrjId'] : '';
$enable_PrjName = isset($_POST['enable_PrjName'])? $_POST['enable_PrjName'] : '';
$enable_PrjStatus = isset($_POST['enable_PrjStatus'])? $_POST['enable_PrjStatus'] : '';

// Check if all required variables contain values
if($enable_PrjId === '' || $enable_PrjName === '' || $enable_PrjStatus === '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM project_tbl WHERE project_id = :enable_PrjId");
    $stmt1->bindParam(':enable_PrjId', $enable_PrjId);
    $stmt1->execute();

    // Check if the project already exists
    if($stmt1->rowCount() == 0){
        $response["res"] = "norecord";
        throw new Exception("Project {$enable_PrjName} not found.");
    }
    
    // If Status is 1, set it to 0 before updating
    if ($enable_PrjStatus == 0) {
        $enable_PrjStatus = 1;
    }

    //INSERT INTO `project_tbl`(`project_id`, `project_category`, `project_name`, `project_description`, `project_contactno`, `project_email`, `project_address`, `project_status`, `project_created`, `project_timestamp`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
    $stmt3 = $conn->prepare("UPDATE project_tbl SET project_status = :enable_PrjStatus WHERE project_id = :enable_PrjId");
    $stmt3->bindParam(':enable_PrjStatus', $enable_PrjStatus);
    $stmt3->bindParam(':enable_PrjId', $enable_PrjId);
    
    if(!$stmt3->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to enable project.");
    }

    //Log
    $log_page = "project";
    $log_action = "Enabled Project" . "-" . $enable_PrjId;

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
    $response["msg"] = $enable_PrjName;
    
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