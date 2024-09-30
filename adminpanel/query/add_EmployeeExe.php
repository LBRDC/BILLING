<?php
session_start();
include("../../conn.php");

// Initialize response array
$response = array("res" => "", "msg" => "");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$add_EmpFname = isset($_POST['add_EmpFname']) ? $_POST['add_EmpFname'] : '';
$add_EmpMname = isset($_POST['add_EmpMname']) ? $_POST['add_EmpMname'] : '';
$add_EmpLname = isset($_POST['add_EmpLname']) ? $_POST['add_EmpLname'] : '';
$add_Region = isset($_POST['add_region']) ? $_POST['add_region'] : '';
// $add_EmpSfname = isset($_POST['add_EmpSfname'])? $_POST['add_EmpSfname'] : '';
$add_Status = 1;
$add_Created = date("Y-m-d");
// Check if all required variables contain values
if ($add_EmpFname == '' || $add_EmpLname == '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}



try {
    // Begin transaction
    $conn->beginTransaction();

    // Prepare and execute the first statement
    $stmt1 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_fname = :add_EmpFname AND emp_lname = :add_EmpLname");
    $stmt1->bindParam(':add_EmpFname', $add_EmpFname);
    $stmt1->bindParam(':add_EmpLname', $add_EmpLname);
    $stmt1->execute();

    // Check if the project name already exists
    if ($stmt1->rowCount() > 0) {
        $response["res"] = "exists";
        throw new Exception("Employee already exists.");
    }


    // Prepare and execute the second statement to insert the new project
    $stmt2 = $conn->prepare("INSERT INTO employee_tbl (emp_fname, emp_mname, emp_lname, emp_status, emp_created,region) VALUES (:add_EmpFname, :add_EmpMname, :add_EmpLname, :add_Status, :add_Created, :region)");
    // $stmt2 = $conn->prepare("INSERT INTO employee_tbl (emp_fname, emp_mname, emp_lname, emp_sfname, emp_status, emp_created) VALUES (:add_EmpFname, :add_EmpMname, :add_EmpLname, :add_EmpSfname, :add_Status, :add_Created)");
    $stmt2->bindParam(':add_EmpFname', $add_EmpFname);
    $stmt2->bindParam(':add_EmpMname', $add_EmpMname);
    $stmt2->bindParam(':add_EmpLname', $add_EmpLname);
    $stmt2->bindParam(':region', $add_Region);
    // $stmt2->bindParam(':add_EmpSfname', $add_EmpSfname);
    $stmt2->bindParam(':add_Status', $add_Status);
    $stmt2->bindParam(':add_Created', $add_Created);

    // Execute the statement
    if (!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to insert employee.");
    }

    // Get the ID of the newly inserted billing record
    $lastInsertedEmployeeId = $conn->lastInsertId();

    //Log
    $log_page = "employee";
    $log_action = "Add Employee" . "-" . $lastInsertedEmployeeId;

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

    // Commit the transaction
    $conn->commit();

    $response["res"] = "success";
    $response["msg"] = $add_EmpFname . " " . $add_EmpLname;
    echo json_encode($response);
} catch (Exception $e) {
    // An error occurred; rollback the transaction
    $conn->rollBack();
    $response["msg"] = $e->getMessage();
    echo json_encode($response);
}

exit();