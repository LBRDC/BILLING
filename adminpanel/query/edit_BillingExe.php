<?php 
session_start();
include("../../conn.php");

$response = array("res" => "", "msg" => "");

$edit_BillId = isset($_POST['edit_BillId'])? $_POST['edit_BillId'] : '';
$edit_BillCategory = isset($_POST['edit_BillCategory'])? $_POST['edit_BillCategory'] : '';
$edit_BillProject = isset($_POST['edit_BillProject'])? $_POST['edit_BillProject'] : '';
$edit_BillEmployee = isset($_POST['edit_BillEmployee'])? $_POST['edit_BillEmployee'] : '';
$edit_BillPeriodFrom = isset($_POST['edit_BillPeriodFrom'])? $_POST['edit_BillPeriodFrom'] : '';
$edit_BillPeriodTo = isset($_POST['edit_BillPeriodTo'])? $_POST['edit_BillPeriodTo'] : '';
$edit_BillAmount = isset($_POST['edit_BillAmount'])? $_POST['edit_BillAmount'] : '';
$edit_BillDateReceived = isset($_POST['edit_BillDateReceived'])? ($_POST['edit_BillDateReceived'] === '' || $_POST['edit_BillDateReceived'] === '0000-00-00'? NULL : $_POST['edit_BillDateReceived']) : NULL;
$edit_BillTotalBilled = isset($_POST['edit_BillTotalBilled'])? $_POST['edit_BillTotalBilled'] : '';
$edit_BillAmountCollect = isset($_POST['edit_BillAmountCollect'])? $_POST['edit_BillAmountCollect'] : '';
$edit_BillDateDue = isset($_POST['edit_BillDateDue'])? ($_POST['edit_BillDateDue'] === '' || $_POST['edit_BillDateDue'] === '0000-00-00'? NULL : $_POST['edit_BillDateDue']) : NULL;
$edit_BillDateCollect = isset($_POST['edit_BillDateCollect'])? ($_POST['edit_BillDateCollect'] === '' || $_POST['edit_BillDateCollect'] === '0000-00-00'? NULL : $_POST['edit_BillDateCollect']) : NULL;
$edit_BillRemarks = isset($_POST['edit_BillRemarks'])? $_POST['edit_BillRemarks'] : '';

// Check if all required variables contain values
if($edit_BillId == '' || $edit_BillCategory == '' || $edit_BillProject == '' || $edit_BillPeriodFrom == '' || $edit_BillPeriodTo == '' || $edit_BillAmount == '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    $stmt1 = $conn->prepare("SELECT * FROM billing_tbl WHERE bill_id = :edit_BillId");
    $stmt1->bindParam(':edit_BillId', $edit_BillId);
    $stmt1->execute();

    if($stmt1->rowCount() <= 0){
        $response["res"] = "norecord";
        throw new Exception("Project {$edit_BillId} not found.");
    }

    //INSERT INTO billing_tbl (bill_category, bill_prj_id, bill_emp_id, bill_period, bill_amount, bill_date_received, bill_total_billed, bill_partial_billed, bill_partial_collected, bill_date_due, bill_date_collected, bill_amount_collected) VALUES (:edit_BillCategory, :edit_BillProject, :edit_BillEmployee, :edit_Prj_Period, :edit_BillAmount, :edit_BillDateReceived, :edit_BillTotalBilled, :edit_BillPartial, :edit_BillPartialCollect, :edit_BillDateDue, :edit_BillDateCollect, :edit_BillAmountCollect)
    $stmt2 = $conn->prepare("UPDATE billing_tbl 
                            SET bill_category = :edit_BillCategory, 
                                bill_prj_id = :edit_BillProject, 
                                bill_emp_id = :edit_BillEmployee, 
                                bill_periodfrom = :edit_BillPeriodFrom, 
                                bill_periodto = :edit_BillPeriodTo, 
                                bill_amount = :edit_BillAmount, 
                                bill_date_received = :edit_BillDateReceived, 
                                bill_total_billed = :edit_BillTotalBilled, 
                                bill_date_due = :edit_BillDateDue, 
                                bill_date_collected = :edit_BillDateCollect, 
                                bill_amount_collected = :edit_BillAmountCollect, 
                                bill_remarks = :edit_BillRemarks 
                            WHERE bill_id = :edit_BillId");
    $stmt2->bindParam(':edit_BillCategory', $edit_BillCategory);
    $stmt2->bindParam(':edit_BillProject', $edit_BillProject); 
    $stmt2->bindParam(':edit_BillEmployee', $edit_BillEmployee);
    $stmt2->bindParam(':edit_BillPeriodFrom', $edit_BillPeriodFrom);
    $stmt2->bindParam(':edit_BillPeriodTo', $edit_BillPeriodTo);
    $stmt2->bindParam(':edit_BillAmount', $edit_BillAmount);
    $stmt2->bindParam(':edit_BillDateReceived', $edit_BillDateReceived);
    $stmt2->bindParam(':edit_BillTotalBilled', $edit_BillTotalBilled);
    $stmt2->bindParam(':edit_BillDateDue', $edit_BillDateDue);
    $stmt2->bindParam(':edit_BillDateCollect', $edit_BillDateCollect);
    $stmt2->bindParam(':edit_BillAmountCollect', $edit_BillAmountCollect);
    $stmt2->bindParam(':edit_BillRemarks', $edit_BillRemarks);
    $stmt2->bindParam(':edit_BillId', $edit_BillId);
    
    // Execute the statement
    if(!$stmt2->execute()) {
        $response["res"] = "failed";
        throw new Exception("Failed to update billing.");
    }


    //Log
    $log_page = "billing";
    $log_action = "Edit Billing" . "-" . $edit_BillId;

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