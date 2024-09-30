<?php 
include("../../conn.php");

@$response = array("res" => "", "msg" => "", "data" => "");

$fetch_datefrom = isset($_POST['fetch_datefrom']) ? $_POST['fetch_datefrom'] : '';
$fetch_dateto = isset($_POST['fetch_dateto']) ? $_POST['fetch_dateto'] : '';

// Check if all required variables contain values
if($fetch_datefrom == '' || $fetch_dateto == '') {
    $response["res"] = "incomplete";
    echo json_encode($response);
    exit();
}

try {
    // Begin transaction
    $conn->beginTransaction();

    /*
    bill_id, bill_category, bill_prj_id, bill_emp_id, bill_period, 
    bill_periodfrom, bill_periodto, bill_amount, bill_date_received, 
    bill_total_billed, bill_partial_billed, bill_partial_collected, 
    bill_date_due, bill_date_collected, bill_amount_collected, 
    bill_status, bill_userlog, bill_timestamp
    */
    $stmt1 = $conn->prepare("SELECT * FROM billing_tbl WHERE NOT bill_status = 3 AND ((bill_periodfrom >= :fetch_datefrom AND bill_periodfrom <= :fetch_dateto)) ORDER BY DATE_FORMAT(bill_periodfrom, '%Y-%m-%d') ASC, bill_category DESC, bill_prj_id ASC");
    $stmt1->bindParam(':fetch_datefrom', $fetch_datefrom);
    $stmt1->bindParam(':fetch_dateto', $fetch_dateto);

    // Fetch Data
    if(!$stmt1->execute()) {
        throw new Exception("Failed to insert billing.");
    }

    $rows = $stmt1->fetchAll(PDO::FETCH_ASSOC); 

    $data = [];
    $lastEntryFlag = false;
    $currentMonth = ''; 
    $currentMonthTotalAmount = 0; 
    $currentMonthTotalBilled = 0;
    //Month-Year from - Month-Year to
    $currentMonthRange = getMonthYearRange($fetch_datefrom, $fetch_dateto);

    foreach ($rows as $index => $row) {
        $extractedMonth = date('m', strtotime($row['bill_periodfrom']));
        if ($currentMonth == "") {
            $currentMonth = $extractedMonth;
        }

        if ($extractedMonth == $currentMonth) {
            $currentMonthTotalAmount += $row['bill_amount'];
            $currentMonthTotalBilled += $row['bill_total_billed'];
            $rowData = [
                'formattedcategory' => formatCategory($row['bill_category'])?? '',
                'formattedproject' => formatProject($row['bill_prj_id'], $conn)?? '',
                'formattedemployee' => formatEmployee($row['bill_emp_id'], $conn)?? '',
                'formattedperiod' => formatDateRange($row['bill_periodfrom'], $row['bill_periodto'])?? '',
                'bill_amount' => formatCurrency($row['bill_amount'])?? '',
                'bill_total_billed' => formatCurrency($row['bill_total_billed'])?? '',
                'bill_date_received' => $row['bill_date_received']?? '',
                'bill_date_due' => $row['bill_date_due']?? '',
                'bill_date_collected' => $row['bill_date_collected']?? '',
                'bill_amount_collected' => formatCurrency($row['bill_amount_collected'])?? '',
                'bill_remarks' => $row['bill_remarks']?? '',
                'bill_total_period' => '', 
                'bill_unbilled' => ''
            ];
        } else {
            $rowData = [
                'formattedcategory' => '',
                'formattedproject' => '',
                'formattedemployee' => '',
                'formattedperiod' => '',
                'bill_amount' => '',
                'bill_total_billed' => '',
                'bill_date_received' => '',
                'bill_date_due' => '',
                'bill_date_collected' => '',
                'bill_amount_collected' => '',
                'bill_remarks' => ''
            ];
            $rowData['bill_total_period'] = formatCurrency($currentMonthTotalAmount);
            $total_unbilled = $currentMonthTotalAmount - $currentMonthTotalBilled;
            $rowData['bill_unbilled'] = formatCurrency($total_unbilled);

            //reset
            $currentMonth = $extractedMonth;
            $lastEntryFlag = false; 
            $currentMonthTotalAmount = 0; 
            $currentMonthTotalBilled = 0; 
        }

        /*
            extract month
            if month is same, add to total period
            else month is different, insert blank row and display the total period for month
            reset data 
            compute next month...

            if it's the last entry, display the total period for the current month 

            
        $extractedMonth = date('m', strtotime($row['bill_periodfrom']));
        if ($currentMonth == "") {
            $currentMonth = $extractedMonth;
        }

        if ($extractedMonth == $currentMonth) {
            $currentMonthTotalAmount += $row['bill_amount'];
            $rowData = [
                'formattedcategory' => formatCategory($row['bill_category'])?? '',
                'formattedproject' => formatProject($row['bill_prj_id'], $conn)?? '',
                'formattedemployee' => formatEmployee($row['bill_emp_id'], $conn)?? '',
                'formattedperiod' => formatDateRange($row['bill_periodfrom'], $row['bill_periodto'])?? '',
                'bill_amount' => formatCurrency($row['bill_amount'])?? '',
                'bill_total_billed' => formatCurrency($row['bill_total_billed'])?? '',
                'bill_date_received' => $row['bill_date_received']?? '',
                'bill_date_due' => $row['bill_date_due']?? '',
                'bill_date_collected' => $row['bill_date_collected']?? '',
                'bill_amount_collected' => formatCurrency($row['bill_amount_collected'])?? '',
                'bill_remarks' => $row['bill_remarks']?? '',
                'bill_total_period' => '', // This will be calculated later
                'bill_unbilled' => ''
            ];
        } else {
            $rowData = [
                'formattedcategory' => '',
                'formattedproject' => '',
                'formattedemployee' => '',
                'formattedperiod' => '',
                'bill_amount' => '',
                'bill_total_billed' => '',
                'bill_date_received' => '',
                'bill_date_due' => '',
                'bill_date_collected' => '',
                'bill_amount_collected' => '',
                'bill_remarks' => '',
                'bill_unbilled' => ''
            ];
            $rowData['bill_total_period'] = formatCurrency($currentMonthTotalAmount);

            //reset
            $currentMonth = $extractedMonth;
            $lastEntryFlag = false; // Flag to check if it's the last entry for the month
            $currentMonthTotalAmount = 0; // Initialize total amount for the current month
        }
        */

        $data[] = $rowData;
    }

    // After the loop, set the total for the last month if applicable
    if ($currentMonthTotalAmount > 0) { 
        $data[count($data) - 1]['bill_total_period'] = formatCurrency($currentMonthTotalAmount);
    }

    $response["data"] = $data;
    $response["title"] = $currentMonthRange;

    // Commit transaction
    $conn->commit();

    $response["res"] = "success";
    echo json_encode($response);
} catch (Exception $e) {
    $response["res"] = "failed";
    $conn->rollBack();
    $response["msg"] = $e->getMessage();
    echo json_encode($response);
}

exit();




function formatDateRange($dateFrom, $dateTo) {
    if ($dateFrom === null || $dateTo === null) {
        throw new Exception("Date is null value.");
    }

    // Validate input format
    if (!preg_match('/\d{4}-\d{2}-\d{2}/', $dateFrom) ||!preg_match('/\d{4}-\d{2}-\d{2}/', $dateTo)) {
        throw new Exception("Date is null value.");
    }

    // Convert date strings to DateTime objects
    $dateTimeFrom = new DateTime($dateFrom);
    $dateTimeTo = new DateTime($dateTo);

    // Initialize variables for month, day from, day to, and year
    $monthFrom = '';
    $dayFrom = '';
    $dayTo = '';
    $year = '';

    // Check if the dates are in the same month
    if ($dateTimeFrom->format('m') == $dateTimeTo->format('m')) {
        $monthFrom = $dateTimeFrom->format('F');
        $dayFrom = $dateTimeFrom->format('j');
        $dayTo = $dateTimeTo->format('j');
        $year = $dateTimeFrom->format('Y');

        // Check for zero values
        if ($dayFrom == '0' || $dayTo == '0' || $year == '0000') {
            throw new Exception("Date is zero value.");
        } else {
            return sprintf('%s %s-%s, %s', $monthFrom, $dayFrom, $dayTo, $year);
        }
    } else {
        $formattedDateFrom = $dateTimeFrom->format('F j, Y'); 
        $formattedDateTo = $dateTimeTo->format('F j, Y'); 
        return sprintf('%s - %s', $formattedDateFrom, $formattedDateTo);
    }
}

function formatCategory($cat_id){
    $category_disp = ($cat_id == 'main') ? '' : (($cat_id == 'ad-overtime') ? 'ADJUSTMENTS-OVERTIME' : 'ADJUSTMENTS (RETRO)');
    return $category_disp;
}

function formatProject($prj_id, $dbconn){
    $stmtf1 = $dbconn->prepare("SELECT project_name FROM project_tbl WHERE project_id = :prj_id");
    $stmtf1->bindParam(':prj_id', $prj_id);

    if ($stmtf1->execute()) {
        $row = $stmtf1->fetch(PDO::FETCH_ASSOC);
        $project_name = $row['project_name'];
    }

    return $project_name;
}

function formatEmployee($emp_id, $dbconn){
    $stmtf1 = $dbconn->prepare("SELECT * FROM employee_tbl WHERE emp_id = :emp_id");
    $stmtf1->bindParam(':emp_id', $emp_id);
    $stmtf1->execute();

    if ($stmtf1->rowCount() > 0) {
        $row = $stmtf1->fetch(PDO::FETCH_ASSOC);
        $emp_fname = $row['emp_fname'];
        $emp_mname = $row['emp_mname'];
        $emp_lname = $row['emp_lname'];
        $emp_sfname = $row['emp_sfname'];

        $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
        $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
        $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
        $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
        $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
    } else {
        $emp_name = '';
    }

    return $emp_name;
}

function formatCurrency($amount){
    return number_format($amount, 2);
}

function getMonthYearRange($dateFrom, $dateTo) {
    $dateTimeFrom = new DateTime($dateFrom);
    $dateTimeTo = new DateTime($dateTo);

    $monthFrom = $dateTimeFrom->format('F');
    $yearFrom = $dateTimeFrom->format('Y');

    $monthTo = $dateTimeTo->format('F');
    $yearTo = $dateTimeTo->format('Y');

    return "$monthFrom-$yearFrom to $monthTo-$yearTo";
}