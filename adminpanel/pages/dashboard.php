<?php
    //Pending Counts
    $stmt1 = $conn->prepare("SELECT * FROM billing_tbl WHERE NOT bill_status = 3");
    $stmt1->execute();

    //Pending Billings
    $stmt2 = $conn->prepare("SELECT bill_id FROM billing_tbl");
    $stmt2->execute();

    //Pending Table
    $stmt3 = $conn->prepare("SELECT * FROM billing_tbl WHERE NOT bill_status = 3 ORDER BY bill_id DESC");
    $stmt3->execute();

    //Pending Count
    @$pending_count = 0;
    //Pending Amount
    @$pending_amount = 0;
    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $bill_id = $row1['bill_id']?? '';
        $bill_amount = $row1['bill_amount']?? '';
        $total_billed = $row1['bill_total_billed']?? '';
        $date_due = $row1['bill_date_due']?? '';
        $amount_collected = $row1['bill_amount_collected']?? '';

        $amount_remaining = $total_billed - $amount_collected;

        $percent = 0;
        if ($total_billed == 0) {
            //Add Count
            $pending_count++;
            //Add Pending
            $pending_amount += $amount_remaining;
        } else {
            $percent = ($amount_collected / $total_billed) * 100;

            $today = date('Y-m-d');
            $isOverdue = strtotime($date_due) < strtotime($today);

            if ($percent >= 100) {
            } elseif ($isOverdue && $percent < 100) {
                //Add Count
                $pending_count++;
                //Add Pending
                $pending_amount += $amount_remaining;
            } elseif (!$isOverdue && $percent < 100) {
                if ($amount_collected >= $partial_billed) {
                    //Add Count
                    $pending_count++;
                    //Add Pending
                    $pending_amount += $amount_remaining;
                } else {
                    //Add Count
                    $pending_count++;
                    //Add Pending
                    $pending_amount += $amount_remaining;
                }
            } else {
            }
        }
    }
?>

<!-- #START# dashboard.php -->
                <!-- ### DASHBOARD PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-home icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>LBRDC Billing Management
                                    <div class="page-title-subheading">
                                        Welcome!
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <!-- Date and Time -->
                            <div class="col-xl-12 col-md-12 mb-4 align-items-center">
                                <div class="card card-bg" style="min-height: 180px;">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentDate"></div>
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentTime"></div>
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentDay"></div>
                                                <script type="text/javascript">
                                                    function updateDateTime() {
                                                        const now = new Date();
                                                        const date = now.toLocaleDateString();
                                                        const timeOptions = { hour: '2-digit', minute: '2-digit' };
                                                        const time = now.toLocaleTimeString(undefined, timeOptions);

                                                        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                                        const day = days[now.getDay()];

                                                        document.getElementById('currentDate').textContent = date;
                                                        document.getElementById('currentTime').textContent = time;
                                                        document.getElementById('currentDay').textContent = day;
                                                    }

                                                    updateDateTime();
                                                    setInterval(updateDateTime, 5000);
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- #END# Date and Time -->
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="row">
                                <!-- Total Projects -->
                                <div class="col-md-6 col-xl-6">
                                    <div class="card mb-3 widget-content bg-midnight-bloom">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total Projects</div>
                                                <div class="widget-subheading">Pending</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white">
                                                    <span><?php echo htmlspecialchars($pending_count); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- #END# Total Projects -->
                                <!-- Total Bill Amount -->
                                <div class="col-md-6 col-xl-6">
                                    <div class="card mb-3 widget-content bg-premium-dark">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Unpaid Amount</div>
                                                <div class="widget-subheading">Remaining</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-warning"><span>₱<?php echo htmlspecialchars(number_format($pending_amount, 2)); ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- #END# Total Bill Amount -->
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">Pending Bills</div>
                                    <div class="table-responsive">
                                        <table class="mb-0 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Project</th>
                                                    <th>Employee</th>
                                                    <th data-dt-order="disable">Period Covered</th>
                                                    <th>Amount Collected</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                while ($row2 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                    $bill_id = $row2['bill_id']?? '';
                                                    $bill_category = $row2['bill_category']?? '';
                                                    $project_id = $row2['bill_prj_id']?? '';
                                                    $employee_id = $row2['bill_emp_id']?? '';
                                                    $bill_periodfrom = $row2['bill_periodfrom']?? '';
                                                    $bill_periodto = $row2['bill_periodto']?? '';
                                                    $bill_amount = $row2['bill_amount']?? '';
                                                    $date_received = $row2['bill_date_received']?? '';
                                                    $total_billed = $row2['bill_total_billed']?? '';
                                                    $date_due = $row2['bill_date_due']?? '';
                                                    $date_collected = $row2['bill_date_collected']?? '';
                                                    $amount_collected = $row2['bill_amount_collected']?? '';
                                                    $bill_remarks = $row2['bill_remarks']?? '';
                                                    $date_disp = formatDateRange($bill_periodfrom, $bill_periodto);
                                                    $category_disp = ($bill_category == 'main')? 'MAIN' : (($bill_category == 'ad-overtime')? 'ADJUSTMENTS-OVERTIME' : 'ADJUSTMENTS (RETRO)');

                                                    $stmt4 = $conn->prepare("SELECT project_name FROM project_tbl WHERE project_id = :project_id");
                                                    $stmt4->bindParam(':project_id', $project_id);

                                                    if ($stmt4->execute()) {
                                                        $row3 = $stmt4->fetch(PDO::FETCH_ASSOC);
                                                        $project_name = $row3['project_name'];
                                                    }

                                                    $stmt5 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_id = :employee_id");
                                                    $stmt5->bindParam(':employee_id', $employee_id);
                                                    $stmt5->execute();

                                                    if ($stmt5->rowCount() > 0) {
                                                        $row4 = $stmt5->fetch(PDO::FETCH_ASSOC);
                                                        $emp_fname = $row4['emp_fname'];
                                                        $emp_mname = $row4['emp_mname'];
                                                        $emp_lname = $row4['emp_lname'];
                                                        $emp_sfname = $row4['emp_sfname'];
                                                        $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                                        $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
                                                        $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                                        $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                                        $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                                    } else {
                                                        $emp_name = '';
                                                    }

                                                    $percent = 0;
                                                    if ($total_billed == 0) {
                                                        $status = '<span class="mb-2 mr-2 badge badge-pill badge-secondary">Pending</span>';
                                                    } else {
                                                        $percent = ($amount_collected / $total_billed) * 100;
                                                        $today = date('Y-m-d');
                                                        $isOverdue = strtotime($date_due) < strtotime($today);
                                                        if ($percent >= 100) {
                                                            $status = '<span class="mb-2 mr-2 badge badge-pill badge-success">Fully Paid</span>';
                                                        } elseif ($isOverdue && $percent < 100) {
                                                            $status = '<span class="mb-2 mr-2 badge badge-pill badge-danger">Overdue</span>';
                                                        } elseif (!$isOverdue && $percent < 100) {
                                                            if ($amount_collected >= $partial_billed) {
                                                                $status = '<span class="mb-2 mr-2 badge badge-pill badge-warning">Partial Paid</span>';
                                                            } else {
                                                                $status = '<span class="mb-2 mr-2 badge badge-pill badge-primary">Pending</span>';
                                                            }
                                                        } else {
                                                            $status = '<span class="mb-2 mr-2 badge badge-pill badge-info">NaN</span>';
                                                        }
                                                    }

                                                    $collected_disp = number_format($amount_collected, 2) ." (". number_format($percent). "%)";

                                                    if ($total_billed == 0 || $percent < 100) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($bill_id); ?></td>
                                                    <td><?php echo htmlspecialchars($project_name); ?></td>
                                                    <td><?php echo htmlspecialchars($emp_name); ?></td>
                                                    <td><?php echo htmlspecialchars($date_disp); ?></td>
                                                    <td><?php echo htmlspecialchars($collected_disp); ?></td>
                                                    <td><?php echo $status; ?></td>
                                                </tr>
                                                <?php 
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# DASHBOARD PAGE -->
<!-- #END# dashboard.php -->

<?php 
function formatDateRange($dateFrom, $dateTo) {
    // Check if either $dateFrom or $dateTo is null
    if ($dateFrom === null || $dateTo === null) {
        return 'Invalid input: null value detected';
    }

    // Validate input format
    if (!preg_match('/\d{4}-\d{2}-\d{2}/', $dateFrom) ||!preg_match('/\d{4}-\d{2}-\d{2}/', $dateTo)) {
        return 'null';
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
        // Dates are in the same month, extract month, day from, day to, and year
        $monthFrom = $dateTimeFrom->format('F'); 
        $dayFrom = $dateTimeFrom->format('j'); 
        $dayTo = $dateTimeTo->format('j');
        $year = $dateTimeFrom->format('Y'); 

        // Check for zero values
        if ($dayFrom == '0' || $dayTo == '0' || $year == '0000') {
            return 'null';
        } else {
            // Output format: [month] [dayfrom]-[dayto], [year]
            return sprintf('%s %s-%s, %s', $monthFrom, $dayFrom, $dayTo, $year);
        }
    } else {
        // Dates are not in the same month, set placeholders for month and year
        $formattedDateFrom = $dateTimeFrom->format('F j, Y'); 
        $formattedDateTo = $dateTimeTo->format('F j, Y'); 
        return sprintf('%s - %s', $formattedDateFrom, $formattedDateTo);
    }
}
?>