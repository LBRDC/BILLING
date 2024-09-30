<?php
session_start();
include("../../conn.php");
$response = array("res" => "", "msg" => "", "length" => "");
$add_Status = 1;
$add_Created = date("Y-m-d");
// $json_data = file_get_contents('php://input');
// $data = json_decode($json_data, true);
// $curr_emp = $employees;
// $employees = $data['Employees'];
$employees = json_decode($_POST['Employees']);
if (empty($employees)) {
    $response['res'] = "Empty File";
    $response['msg'] = "Please provide a valid file.";
    echo json_encode($response);
    exit();
}


try {
    //Begin Transaction
    $conn->beginTransaction();
    $myArr = [];
    foreach ($employees as $key => $val) {
        $curr_Region = getRegionID($conn, $val->region);
        if (!checkDuplicate($conn, $val->emp_Id)) {
            $stmt = $conn->prepare("insert into employee_tbl (emp_number, emp_fname, emp_mname, emp_lname, region, assignment, emp_position, emp_status, emp_created) values(:emp_number, :fname, :mname, :lname, :region, :assignment, :position, :emp_status, :emp_created)");
            $stmt->bindParam(':emp_number', $val->emp_Id);
            $stmt->bindParam(':fname', $val->firstName);
            $stmt->bindParam(':mname', $val->middleName);
            $stmt->bindParam(':lname', $val->lastName);
            $stmt->bindParam(':region', $curr_Region);
            $stmt->bindParam(':assignment', $val->assignment);
            $stmt->bindParam(':position', $val->position);
            $stmt->bindParam(':emp_status', $add_Status);
            $stmt->bindParam(':emp_created', $add_Created);
            $stmt->execute();
        }
    }
    $conn->commit();
    $response['res'] = "success";
    $response['msg'] = $myArr;
    echo json_encode($response);
    exit();
} catch (Exception $e) {
    $conn->rollBack();
    $response['res'] = "fail";
    $response['msg'] = $e->getMessage();
    echo json_encode($response);
    exit();
}


// Get the ID of region base on the given value
function getRegionID($con, $regionName)
{
    $stmt = $con->prepare("select id from region where region='$regionName'");
    $stmt->execute();
    $samp = strval($stmt->fetch(PDO::FETCH_ASSOC)['id']);
    return isset($samp) ? $samp : null;
}


//  Check if the employee ID already exist in the database

function checkDuplicate($con, $emp_number)
{
    $stmt = $con->prepare("select * from employee_tbl where emp_number='$emp_number'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}