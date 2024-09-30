<?php 
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");
// Use $_POST directly instead of extract($_POST) for better security and clarity
$add_UserFname = isset($_POST['add_UserFname']) ? $_POST['add_UserFname'] : '';
$add_UserLname = isset($_POST['add_UserLname']) ? $_POST['add_UserLname'] : '';
$add_UserPosition = isset($_POST['add_UserPosition']) ? $_POST['add_UserPosition'] : '';
$add_UserSuper = isset($_POST['add_UserSuper']) ? $_POST['add_UserSuper'] : '';
$add_UserName = isset($_POST['add_UserName']) ? $_POST['add_UserName'] : '';
$add_UserPass = isset($_POST['add_UserPass']) ? $_POST['add_UserPass'] : '';
$add_UserRole = isset($_POST['add_UserRole']) ? $_POST['add_UserRole'] : '';
$add_UserStatus = 0;

if(empty($add_UserFname) || empty($add_UserLname) || empty($add_UserName) || empty($add_UserPass)) {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM admin_user WHERE admin_username = :add_UserName");
    $stmt1->bindParam(':add_UserName', $add_UserName);
    $stmt1->execute();

    if($stmt1->rowCount() > 0){
        $response["res"] = "exists";
        throw new Exception("{$add_UserName} already exists.");
    }

    // Prepare and execute the second statement to insert the new project
    $stmt2 = $conn->prepare("INSERT INTO admin_user (admin_fname, admin_lname, admin_pos, admin_username, admin_password, admin_super, admin_status, roles) VALUES (:add_UserFname, :add_UserLname, :add_UserPosition, :add_UserName, :add_UserPass, :add_UserSuper, :add_UserStatus, :add_Roles)");
    $stmt2->bindParam(':add_UserFname', $add_UserFname);
    $stmt2->bindParam(':add_UserLname', $add_UserLname);
    $stmt2->bindParam(':add_UserPosition', $add_UserPosition);
    $stmt2->bindParam(':add_UserName', $add_UserName);
    $stmt2->bindParam(':add_UserPass', $add_UserPass);
    $stmt2->bindParam(':add_UserSuper', $add_UserSuper);
    $stmt2->bindParam(':add_UserStatus', $add_UserStatus);
    $stmt2->bindParam(':add_Roles', $add_UserRole);

    // Execute the statement
    if(!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to insert employee.");
    }

    // Get the ID of the newly inserted billing record
    $lastInsertedAdminId = $conn->lastInsertId();

    //Log
    $log_page = "project";
    $log_action = "Add Project" . "-" . $lastInsertedAdminId;

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
    $response["msg"] = $add_UserName;
    
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