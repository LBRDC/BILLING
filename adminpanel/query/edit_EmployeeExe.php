<?php
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");
// Use $_POST directly instead of extract($_POST) for better security and clarity
$edit_EmpId = isset($_POST['edit_EmpId']) ? $_POST['edit_EmpId'] : '';
$edit_EmpFname = isset($_POST['edit_EmpFname']) ? $_POST['edit_EmpFname'] : '';
$edit_EmpMname = isset($_POST['edit_EmpMname']) ? $_POST['edit_EmpMname'] : '';
$edit_EmpLname = isset($_POST['edit_EmpLname']) ? $_POST['edit_EmpLname'] : '';
// $edit_EmpSfname = isset($_POST['edit_EmpSfname'])? $_POST['edit_EmpSfname'] : '';
$edit_EmpStatus = isset($_POST['edit_EmpStatus']) ? $_POST['edit_EmpStatus'] : '';
$edit_Region = isset($_POST['edit_Region']) ? $_POST['edit_Region'] : '';
// Check if all required variables contain values
if ($edit_EmpFname == '' || $edit_EmpLname == '' || $edit_EmpStatus == '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_id = :edit_EmpId");
    $stmt1->bindParam(':edit_EmpId', $edit_EmpId);
    $stmt1->execute();

    // Check if the project already exists
    if ($stmt1->rowCount() == 0) {
        $response["res"] = "norecord";
        throw new Exception("Employee {$edit_EmpId} not found.");
    }

    // If the ID exists, proceed with checking if the name exists excluding the current record
    $stmt2 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_fname = :edit_EmpFname AND emp_mname = :edit_EmpMname AND emp_lname = :edit_EmpLname AND emp_id != :edit_EmpId");
    $stmt2->bindParam(':edit_EmpFname', $edit_EmpFname);
    $stmt2->bindParam(':edit_EmpMname', $edit_EmpMname);
    $stmt2->bindParam(':edit_EmpLname', $edit_EmpLname);
    $stmt2->bindParam(':edit_EmpId', $edit_EmpId);
    $stmt2->execute();

    if ($stmt2->rowCount() > 0) {
        $response["res"] = "exists";
        throw new Exception("Employee name already exists.");
    }

    // Prepare and execute the second statement to insert the new project
    // $stmt2 = $conn->prepare("UPDATE employee_tbl SET emp_fname = :edit_EmpFname, emp_mname = :edit_EmpMname, emp_lname = :edit_EmpLname, emp_sfname = :edit_EmpSfname, emp_status = :edit_EmpStatus WHERE emp_id = :edit_EmpId");
    $stmt2 = $conn->prepare("UPDATE employee_tbl SET emp_fname = :edit_EmpFname, emp_mname = :edit_EmpMname, emp_lname = :edit_EmpLname,  emp_status = :edit_EmpStatus, region = :edit_Region WHERE emp_id = :edit_EmpId");
    $stmt2->bindParam(':edit_EmpFname', $edit_EmpFname);
    $stmt2->bindParam(':edit_EmpMname', $edit_EmpMname);
    $stmt2->bindParam(':edit_EmpLname', $edit_EmpLname);
    // $stmt2->bindParam(':edit_EmpSfname', $edit_EmpSfname);
    $stmt2->bindParam(':edit_EmpStatus', $edit_EmpStatus);
    $stmt2->bindParam(':edit_Region', $edit_Region);
    $stmt2->bindParam(':edit_EmpId', $edit_EmpId);

    // Execute the statement
    if (!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to update employee.");
    }


    //Log
    $log_page = "employee";
    $log_action = "Edit Employee" . "-" . $edit_EmpId;

    if (isset($_SESSION['user']['admin_fname']) && isset($_SESSION['user']['admin_lname'])) {
        $fname = $_SESSION['user']['admin_fname'];
        $lname = $_SESSION['user']['admin_lname'];
        $log_user = $fname . ' ' . $lname;
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
    if (!$stmt3->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to insert log.");
    }

    $response["res"] = "success";
    $response["msg"] = $edit_EmpFname . " " . $edit_EmpLname;

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
