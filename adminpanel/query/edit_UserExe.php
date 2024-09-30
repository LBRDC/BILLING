<?php 
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

$edit_UserId = isset($_POST['edit_UserId']) ? $_POST['edit_UserId'] : '';
$edit_UserFname = isset($_POST['edit_UserFname']) ? $_POST['edit_UserFname'] : '';
$edit_UserLname = isset($_POST['edit_UserLname']) ? $_POST['edit_UserLname'] : '';
$edit_UserPosition = isset($_POST['edit_UserPosition']) ? $_POST['edit_UserPosition'] : '';
$edit_UserSuper = isset($_POST['edit_UserSuper']) ? $_POST['edit_UserSuper'] : '';
$edit_UserName = isset($_POST['edit_UserName']) ? $_POST['edit_UserName'] : '';
$edit_UserPass = isset($_POST['edit_UserPass']) ? $_POST['edit_UserPass'] : '';
$edit_UserStatus = isset($_POST['edit_UserStatus']) ? $_POST['edit_UserStatus'] : '';

if($edit_UserId == '' || $edit_UserFname == '' || $edit_UserLname == '' || $edit_UserName == '' || $edit_UserPass == '' || $edit_UserStatus == '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM admin_user WHERE admin_username = :edit_UserName AND NOT admin_id = :edit_UserId");
    $stmt1->bindParam(':edit_UserName', $edit_UserName);
    $stmt1->bindParam(':edit_UserId', $edit_UserId);
    $stmt1->execute();
        
    if($stmt1->rowCount() > 0){
        $response["res"] = "exists";
        throw new Exception("{$edit_UserName} already exists.");
    }

    // Prepare and execute the second statement
    $stmt2 = $conn->prepare("UPDATE admin_user SET admin_fname = :edit_UserFname, admin_lname = :edit_UserLname, admin_pos = :edit_UserPosition, admin_username = :edit_UserName, admin_password = :edit_UserPass, admin_super = :edit_UserSuper, admin_status = :edit_UserStatus WHERE admin_id = :edit_UserId");
    $stmt2->bindParam(':edit_UserFname', $edit_UserFname);
    $stmt2->bindParam(':edit_UserLname', $edit_UserLname);
    $stmt2->bindParam(':edit_UserPosition', $edit_UserPosition);
    $stmt2->bindParam(':edit_UserName', $edit_UserName);
    $stmt2->bindParam(':edit_UserPass', $edit_UserPass);
    $stmt2->bindParam(':edit_UserSuper', $edit_UserSuper);
    $stmt2->bindParam(':edit_UserStatus', $edit_UserStatus);
    $stmt2->bindParam(':edit_UserId', $edit_UserId); 
        
    // Execute the statement
    if(!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to edit user.");
    }

    //Log
    $log_page = "admin";
    $log_action = "Edit User" . "-" . $edit_UserId;

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
    $response["msg"] = $edit_UserId;

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