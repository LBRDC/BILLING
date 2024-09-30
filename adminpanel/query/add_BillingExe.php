<?php 
session_start();
include("../../conn.php");

$response = array("res" => "", "msg" => "");

$add_BillCategory = isset($_POST['add_BillCategory'])? $_POST['add_BillCategory'] : '';
$add_BillProject = isset($_POST['add_BillProject'])? $_POST['add_BillProject'] : '';
$add_BillEmployee = isset($_POST['add_BillEmployee'])? $_POST['add_BillEmployee'] : '';
$add_BillPeriodFrom = isset($_POST['add_BillPeriodFrom'])? $_POST['add_BillPeriodFrom'] : '';
$add_BillPeriodTo = isset($_POST['add_BillPeriodTo'])? $_POST['add_BillPeriodTo'] : '';
$add_BillAmount = isset($_POST['add_BillAmount'])? $_POST['add_BillAmount'] : '';
$add_BillDateReceived = isset($_POST['add_BillDateReceived'])? ($_POST['add_BillDateReceived'] === '' || $_POST['add_BillDateReceived'] === '0000-00-00'? NULL : $_POST['add_BillDateReceived']) : NULL;
$add_BillTotalBilled = isset($_POST['add_BillTotalBilled'])? $_POST['add_BillTotalBilled'] : '';
$add_BillAmountCollect = isset($_POST['add_BillAmountCollect'])? $_POST['add_BillAmountCollect'] : '';
$add_BillDateDue = isset($_POST['add_BillDateDue'])? ($_POST['add_BillDateDue'] === '' || $_POST['add_BillDateDue'] === '0000-00-00'? NULL : $_POST['add_BillDateDue']) : NULL;
$add_BillDateCollect = isset($_POST['add_BillDateCollect'])? ($_POST['add_BillDateCollect'] === '' || $_POST['add_BillDateCollect'] === '0000-00-00'? NULL : $_POST['add_BillDateCollect']) : NULL;
$add_BillRemarks = isset($_POST['add_BillRemarks'])? $_POST['add_BillRemarks'] : '';
//$add_BillPartial = isset($_POST['add_BillPartial'])? $_POST['add_BillPartial'] : '';
//$add_BillPartialCollect = isset($_POST['add_BillPartialCollect'])? $_POST['add_BillPartialCollect'] : '';

// Check if all required variables contain values
if($add_BillCategory == '' || $add_BillProject == '' || $add_BillPeriodFrom == '' || $add_BillPeriodTo == '' || $add_BillAmount == '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    //$stmt1 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_fname = :add_EmpFname AND emp_lname = :add_EmpLname");
    //$stmt1->bindParam(':add_EmpFname', $add_EmpFname);
    //$stmt1->bindParam(':add_EmpLname', $add_EmpLname);
    //$stmt1->execute();

    //if($stmt1->rowCount() > 0){
    //    $response["res"] = "exists";
    //    throw new Exception("Employee already exists.");
    //}

    $stmt2 = $conn->prepare("INSERT INTO billing_tbl (bill_category, bill_prj_id, bill_emp_id, bill_periodfrom, bill_periodto, bill_amount, bill_date_received, bill_total_billed, bill_date_due, bill_date_collected, bill_amount_collected, bill_remarks) VALUES (:add_BillCategory, :add_BillProject, :add_BillEmployee, :add_BillPeriodFrom, :add_BillPeriodTo, :add_BillAmount, :add_BillDateReceived, :add_BillTotalBilled, :add_BillDateDue, :add_BillDateCollect, :add_BillAmountCollect, :add_BillRemarks)");
    $stmt2->bindParam(':add_BillCategory', $add_BillCategory);
    $stmt2->bindParam(':add_BillProject', $add_BillProject);
    $stmt2->bindParam(':add_BillEmployee', $add_BillEmployee);
    $stmt2->bindParam(':add_BillPeriodFrom', $add_BillPeriodFrom);
    $stmt2->bindParam(':add_BillPeriodTo', $add_BillPeriodTo);
    $stmt2->bindParam(':add_BillAmount', $add_BillAmount);
    $stmt2->bindParam(':add_BillDateReceived', $add_BillDateReceived);
    $stmt2->bindParam(':add_BillTotalBilled', $add_BillTotalBilled);
    $stmt2->bindParam(':add_BillAmountCollect', $add_BillAmountCollect);
    $stmt2->bindParam(':add_BillDateDue', $add_BillDateDue);
    $stmt2->bindParam(':add_BillDateCollect', $add_BillDateCollect);
    $stmt2->bindParam(':add_BillRemarks', $add_BillRemarks);
    
    //$stmt2->bindParam(':add_BillPartial', $add_BillPartial);
    //$stmt2->bindParam(':add_BillPartialCollect', $add_BillPartialCollect);
    
    // Execute the statement
    if(!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to insert billing.");
    }

    // Get the ID of the newly inserted billing record
    $lastInsertedBillingId = $conn->lastInsertId();

    //Log
    $log_page = "billing";
    $log_action = "Add Billing" . "-" . $lastInsertedBillingId;

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
    echo json_encode($response);
} catch (Exception $e) {
    // An error occurred; rollback the transaction
    $conn->rollBack();
    $response["msg"] = $e->getMessage();
    echo json_encode($response);
}

exit();