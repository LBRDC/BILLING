<?php
    $stmt1 = $conn->prepare("SELECT * FROM billing_tbl WHERE NOT bill_status = 3 ORDER BY bill_id DESC");
    $selBill = $stmt1->execute();

    //$bill_status = 1;
    $stmt2 = $conn->prepare("SELECT bill_id FROM billing_tbl");
    $stmt2->execute();
?>

<!-- #START# manage-billing.php -->
                <!-- ### Billing PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-news-paper icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Billing Management
                                    <div class="page-title-subheading">
                                        Manage Billings
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item active" aria-current="page">Billings</li>
                            </ol>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"><?php echo htmlspecialchars($stmt2->rowCount()); ?></div>
                                            <div class="widget-subheading">Active Billings</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div>
                                                <a href="javascript:void(0)" data-toggle="modal" id="add_billing" data-target="#mdlAddBilling" data-toggle="tooltip" data-placement="bottom" title="Add Billing">
                                                    <i class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Filter Options -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">Filter Options</div>
                                    <div class="row">
                                        <div class="col-md-3 mr-2 mb-2">
                                            <label for="filter_status">Status</label>
                                            <select class="form-control" name="filter_status" id="filter_status">
                                                <option value="">Select...</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Fully Paid">Fully Paid</option>
                                                <option value="Overdue">Overdue</option>
                                            </select>
                                        </div> 
                                        <div class="col-md-3 d-flex align-items-end mb-2">
                                            <button class="btn btn-lg btn-primary mr-2" id="filter-btn">Filter</button>
                                            <button class="btn btn-lg btn-secondary" id="reset-btn">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">Billings</div>
                                    <div class="table-responsive">
                                        <table class="mb-2 mt-2 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Category</th>
                                                <th>Project Name</th>
                                                <th>Employee</th>
                                                <th>Period Covered</th>
                                                <th>Amount</th>
                                                <th>Date Due</th>
                                                <th>Date Collected</th>
                                                <th>Amount Collected</th>
                                                <th>Status</th>
                                                <th data-dt-order="disable">Remarks</th>
                                                <th data-dt-order="disable">Action</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category</th>
                                                <th>Project Name</th>
                                                <th>Employee</th>
                                                <th>Period Covered</th>
                                                <th>Amount</th>
                                                <th>Partial Bill</th>
                                                <th>Date Due</th>
                                                <th>Date Collected</th>
                                                <th>Amount Collected</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                                <?php
                                                function formatDateRange($dateFrom, $dateTo) {
                                                    // Check if either $dateFrom or $dateTo is null
                                                    if ($dateFrom === null || $dateTo === null) {
                                                        return 'Invalid input: null value detected';
                                                    }
                                                
                                                    // Validate input format
                                                    if (!preg_match('/\d{4}-\d{2}-\d{2}/', $dateFrom) ||!preg_match('/\d{4}-\d{2}-\d{2}/', $dateTo)) {
                                                        return 'null'; // Input format is incorrect
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
                                                        $monthFrom = $dateTimeFrom->format('F'); // Full textual representation of a month
                                                        $dayFrom = $dateTimeFrom->format('j'); // Day of the month without leading zeros
                                                        $dayTo = $dateTimeTo->format('j');
                                                        $year = $dateTimeFrom->format('Y'); // A full numeric representation of a year, 4 digits
                                                
                                                        // Check for zero values
                                                        if ($dayFrom == '0' || $dayTo == '0' || $year == '0000') {
                                                            return 'null'; // Zero values found
                                                        } else {
                                                            // Output format: [month] [dayfrom]-[dayto], [year]
                                                            return sprintf('%s %s-%s, %s', $monthFrom, $dayFrom, $dayTo, $year);
                                                        }
                                                    } else {
                                                        // Dates are not in the same month, set placeholders for month and year
                                                        // Format both dates individually
                                                        $formattedDateFrom = $dateTimeFrom->format('F j, Y'); // Month Day, Year
                                                        $formattedDateTo = $dateTimeTo->format('F j, Y'); // Month Day, Year
                                                        return sprintf('%s - %s', $formattedDateFrom, $formattedDateTo);
                                                    }
                                                }
                                                
                                                
                                                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                    $bill_id = $row['bill_id']?? '';
                                                    $bill_category = $row['bill_category']?? '';
                                                    $project_id = $row['bill_prj_id']?? '';
                                                    $employee_id = $row['bill_emp_id']?? '';
                                                    $bill_periodfrom = $row['bill_periodfrom']?? '';
                                                    $bill_periodto = $row['bill_periodto']?? '';
                                                    $bill_amount = $row['bill_amount']?? '';
                                                    $date_received = $row['bill_date_received']?? '';
                                                    $total_billed = $row['bill_total_billed']?? '';
                                                    //$partial_billed = $row['bill_partial_billed']?? '';
                                                    //$partial_collected = $row['bill_partial_collected']?? '';
                                                    $date_due = $row['bill_date_due']?? '';
                                                    $date_collected = $row['bill_date_collected']?? '';
                                                    $amount_collected = $row['bill_amount_collected']?? '';
                                                    $bill_remarks = $row['bill_remarks']?? '';

                                                    $date_disp = formatDateRange($bill_periodfrom, $bill_periodto);
                                                    $category_disp = ($bill_category == 'main')? 'MAIN' : (($bill_category == 'ad-overtime')? 'ADJUSTMENTS-OVERTIME' : 'ADJUSTMENTS (RETRO)');

                                                    $stmt3 = $conn->prepare("SELECT project_name FROM project_tbl WHERE project_id = :project_id");
                                                    $stmt3->bindParam(':project_id', $project_id);

                                                    if ($stmt3->execute()) {
                                                        $row2 = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                        $project_name = $row2['project_name'];
                                                    }

                                                    $stmt4 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_id = :employee_id");
                                                    $stmt4->bindParam(':employee_id', $employee_id);
                                                    $stmt4->execute();

                                                    if ($stmt4->rowCount() > 0) {
                                                        $row3 = $stmt4->fetch(PDO::FETCH_ASSOC);
                                                        $emp_fname = $row3['emp_fname'];
                                                        $emp_mname = $row3['emp_mname'];
                                                        $emp_lname = $row3['emp_lname'];
                                                        $emp_sfname = $row3['emp_sfname'];

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

                                                        /*
                                                            pending (less than 100% collected and not overdue)
                                                            overdue (less than 100% collected and is overdue)
                                                            fully paid (equal to or greater than 100% collected)
                                                            partial paid (collected amount is greater than or equal to partial bill but less than 100%)
                                                        */

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
                                                ?>

                                                <tr id="row<?php echo htmlspecialchars($bill_id); ?>">
                                                    <td><?php echo htmlspecialchars($bill_id); ?></td>
                                                    <td><?php echo htmlspecialchars($category_disp); ?></td>
                                                    <td><?php echo htmlspecialchars($project_name); ?></td>
                                                    <td><?php echo htmlspecialchars($emp_name); ?></td>
                                                    <td><?php echo htmlspecialchars($date_disp); ?></td>
                                                    <td><?php echo htmlspecialchars(number_format($bill_amount, 2)); ?></td>
                                                    <td><?php echo htmlspecialchars($date_due); ?></td>
                                                    <td><?php echo htmlspecialchars($date_collected); ?></td>
                                                    <td><?php echo htmlspecialchars($collected_disp); ?></td>
                                                    <td><?php echo $status; ?></td>
                                                    <td><?php echo htmlspecialchars($bill_remarks); ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="btn btn-info m-1 view-btn" id="view-btn" data-toggle="modal" data-target="#mdlViewBilling" data-placement="bottom" title="View" 
                                                        data-view-id="<?php echo htmlspecialchars($bill_id); ?>"
                                                        data-view-category="<?php echo htmlspecialchars($bill_category); ?>" 
                                                        data-view-project="<?php echo htmlspecialchars($project_id); ?>" 
                                                        data-view-employee="<?php echo htmlspecialchars($employee_id); ?>" 
                                                        data-view-periodfrom="<?php echo htmlspecialchars($bill_periodfrom); ?>" 
                                                        data-view-periodto="<?php echo htmlspecialchars($bill_periodto); ?>" 
                                                        data-view-amount="<?php echo htmlspecialchars($bill_amount); ?>" 
                                                        data-view-daterec="<?php echo htmlspecialchars($date_received); ?>" 
                                                        data-view-totalbill="<?php echo htmlspecialchars($total_billed); ?>" 
                                                        data-view-amountcollect="<?php echo htmlspecialchars($amount_collected); ?>" 
                                                        data-view-datedue="<?php echo htmlspecialchars($date_due); ?>" 
                                                        data-view-datecollected="<?php echo htmlspecialchars($date_collected); ?>"
                                                        data-view-remarks="<?php echo htmlspecialchars($bill_remarks); ?>">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                     <?php if($_SESSION['user']['user_role'] == "admin")  {?>
                                                        <a href="javascript:void(0);" class="btn btn-warning m-1" id="edit-btn" data-toggle="modal" data-target="#mdlEditBilling" data-placement="bottom" title="Edit" 
                                                        data-edit-id="<?php echo htmlspecialchars($bill_id); ?>"
                                                        data-edit-category="<?php echo htmlspecialchars($bill_category); ?>" 
                                                        data-edit-project="<?php echo htmlspecialchars($project_id); ?>" 
                                                        data-edit-employee="<?php echo htmlspecialchars($employee_id); ?>" 
                                                        data-edit-periodfrom="<?php echo htmlspecialchars($bill_periodfrom); ?>" 
                                                        data-edit-periodto="<?php echo htmlspecialchars($bill_periodto); ?>"
                                                        data-edit-amount="<?php echo htmlspecialchars($bill_amount); ?>" 
                                                        data-edit-daterec="<?php echo htmlspecialchars($date_received); ?>" 
                                                        data-edit-totalbill="<?php echo htmlspecialchars($total_billed); ?>" 
                                                        data-edit-amountcollect="<?php echo htmlspecialchars($amount_collected); ?>" 
                                                        data-edit-datedue="<?php echo htmlspecialchars($date_due); ?>" 
                                                        data-edit-datecollected="<?php echo htmlspecialchars($date_collected); ?>"
                                                        data-edit-remarks="<?php echo htmlspecialchars($bill_remarks); ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger m-1" id="delete-btn" data-toggle="modal" data-target="#mdlDeleteBilling" data-toggle="tooltip" data-placement="bottom" title="Delete" 
                                                            data-delete-id="<?php echo htmlspecialchars($bill_id); ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# Billing PAGE -->
<!-- #END# manage-billing.php -->
