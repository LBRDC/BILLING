<?php
// Fetch all projects
$stmtmdl1 = $conn->prepare("SELECT * FROM project_tbl ORDER BY project_id ASC");
$stmtmdl1->execute();

// Separate active and inactive projects
$activeProjects = [];
$inactiveProjects = [];

$resultmdl1 = $stmtmdl1->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultmdl1 as $row) {
    if ($row['project_status'] == 1) {
        $activeProjects[] = $row;
    } else {
        $inactiveProjects[] = $row;
    }
}

// Fetch all employees
$stmtmdl2 = $conn->prepare("SELECT * FROM employee_tbl ORDER BY emp_id ASC");
$stmtmdl2->execute();

// Separate active and inactive employees
$activeEmployees = [];
$inactiveEmployees = [];

$resultmdl2 = $stmtmdl2->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultmdl2 as $row) {
    if ($row['emp_status'] == 1) {
        $activeEmployees[] = $row;
    } else {
        $inactiveEmployees[] = $row;
    }
}
?>

<!-- ADD BILLING MODAL -->
<div class="modal fade" id="mdlAddBilling" tabindex="-1" role="dialog" aria-labelledby="mdlAddBillingLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddBillingLabel">Add Billing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addBillingFrm" name="addBillingFrm" method="post">
            <div class="modal-body">
                <div class="scroll-area-lg">
                    <div class="scrollbar-container ps--active-y">
                        <div class="col-md-12">
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-6">
                                    <label for="add_BillCategory">Category<span class="text-danger">*</span></label>
                                    <select class="form-control" name="add_BillCategory" id="add_BillCategory" required>
                                        <option value="">Select...</option>
                                        <option value="main">Main</option>
                                        <option value="ad-overtime">ADJUSTMENTS-OVERTIME</option>
                                        <option value="ad-retro">ADJUSTMENTS (RETRO)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-10">
                                    <label for="add_BillProject">Project<span class="text-danger">*</span></label>
                                    <select class="form-control" name="add_BillProject" id="add_BillProject" required>
                                        <option value="">Select...</option>
                                        <?php if (!empty($activeProjects)): ?>
                                            <optgroup label="Active Projects">
                                                <?php foreach ($activeProjects as $row): ?>
                                                    <option value="<?= htmlspecialchars($row['project_id']) ?>"><?= htmlspecialchars($row['project_name']) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Active Projects">
                                                <option value="" disabled="disabled">No active projects available</option>
                                            </optgroup>
                                        <?php endif; ?>

                                        <?php if (!empty($inactiveProjects)): ?>
                                            <optgroup label="Inactive Projects">
                                                <?php foreach ($inactiveProjects as $row): ?>
                                                    <option value="<?= htmlspecialchars($row['project_id']) ?>"><?= htmlspecialchars($row['project_name']) ?>(inactive)</option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Inactive Projects">
                                                <option value="" disabled="disabled">No inactive projects available</option>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-10">
                                    <label for="add_BillEmployee">Employee</label>
                                    <select class="form-control" name="add_BillEmployee" id="add_BillEmployee">
                                        <option value="">Select...</option>
                                        <?php if (!empty($activeEmployees)): ?>
                                            <optgroup label="Active Employees">
                                                <?php foreach ($activeEmployees as $row): 
                                                    $emp_fname = $row['emp_fname'];
                                                    $emp_mname = $row['emp_mname'];
                                                    $emp_lname = $row['emp_lname'];
                                                    $emp_sfname = $row['emp_sfname'];

                                                    $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                                    $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
                                                    $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                                    $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                                    $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                                    ?>
                                                    <option value="<?= htmlspecialchars($row['emp_id']) ?>"><?= htmlspecialchars($emp_name) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Active Employees">
                                                <option value="" disabled="disabled">No active employees available</option>
                                            </optgroup>
                                        <?php endif; ?>

                                        <?php if (!empty($inactiveEmployees)): ?>
                                            <optgroup label="Inactive Employees">
                                                <?php foreach ($inactiveEmployees as $row): 
                                                    $emp_fname = $row['emp_fname'];
                                                    $emp_mname = $row['emp_mname'];
                                                    $emp_lname = $row['emp_lname'];
                                                    $emp_sfname = $row['emp_sfname'];

                                                    $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                                    $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
                                                    $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                                    $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                                    $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                                    ?>
                                                    <option value="<?= htmlspecialchars($row['emp_id']) ?>"><?= htmlspecialchars($emp_name) ?>(inactive)</option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Inactive Employees">
                                                <option value="" disabled="disabled">No inactive employees available</option>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-12">
                                    Period Covered<span class="text-danger">*</span>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-lg-5 col-md-12 mb-2" id="datepick_From">
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="add_BillPeriodFrom" id="add_BillPeriodFrom" placeholder="mm/dd/yyyy" value="" required>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 mb-2 d-flex align-items-center justify-content-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-5 col-md-12 mb-2" id="datepick_To">
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="add_BillPeriodTo" id="add_BillPeriodTo" placeholder="mm/dd/yyyy" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="add_BillAmount">Amount<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="add_BillAmount" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2" id="ad_datepick_Received">
                                    <label for="add_BillDateReceived">Date Received SOA by LBP</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="add_BillDateReceived" id="add_BillDateReceived" placeholder="mm/dd/yyyy" value="">
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2">
                                <label for="add_BillTotalBilled">Total Amount Billed</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="add_BillTotalBilled" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <!--<div class="col-md-12 col-lg-6 mb-2">
                                    <label for="add_BillPartial">Partial Billed</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="add_BillPartial" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>-->
                                <!--<div class="col-md-12 col-lg-6 mb-2">
                                    <label for="add_BillPartialCollect">Partial Collected</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="add_BillPartialCollect" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>-->
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="add_BillAmountCollect">Amount Collected</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="add_BillAmountCollect" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-animated bg-primary progress-bar-striped font-weight-bold" id="add_Progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="add_BillDateDue">Date Due</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="add_BillDateDue" id="add_BillDateDue" placeholder="mm/dd/yyyy" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2" id="datepick_Collect">
                                    <label for="add_BillDateCollect">Date Collected</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="add_BillDateCollect" id="add_BillDateCollect" placeholder="mm/dd/yyyy" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-10 mb-2">
                                    <label for="add_BillRemarks">Remarks</label>
                                    <textarea class="form-control" name="add_BillRemarks" id="add_BillRemarks" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# ADD BILLING MODAL -->


<!-- VIEW BILLING MODAL -->
<div class="modal fade" id="mdlViewBilling" tabindex="-1" role="dialog" aria-labelledby="mdlViewBillingLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlViewBillingLabel">View Billing "<span id="view-Title" class="font-weight-bold text-info">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="scroll-area-lg">
                    <div class="scrollbar-container ps--active-y">
                        <div class="col-md-12">
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-6">
                                    <label for="view_BillCategory">Category</label>
                                    <select class="form-control" name="view_BillCategory" id="view_BillCategory" disabled>
                                        <option value="">Select...</option>
                                        <option value="main">Main</option>
                                        <option value="ad-overtime">ADJUSTMENTS-OVERTIME</option>
                                        <option value="ad-retro">ADJUSTMENTS (RETRO)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-10">
                                    <label for="view_BillProject">Project</label>
                                    <select class="form-control" name="view_BillProject" id="view_BillProject" disabled>
                                        <option value="">Select...</option>
                                        <?php if (!empty($activeProjects)): ?>
                                            <optgroup label="Active Projects">
                                                <?php foreach ($activeProjects as $row): ?>
                                                    <option value="<?= htmlspecialchars($row['project_id']) ?>"><?= htmlspecialchars($row['project_name']) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Active Projects">
                                                <option value="" disabled="disabled">No active projects available</option>
                                            </optgroup>
                                        <?php endif; ?>

                                        <?php if (!empty($inactiveProjects)): ?>
                                            <optgroup label="Inactive Projects">
                                                <?php foreach ($inactiveProjects as $row): ?>
                                                    <option value="<?= htmlspecialchars($row['project_id']) ?>"><?= htmlspecialchars($row['project_name']) ?>(inactive)</option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Inactive Projects">
                                                <option value="" disabled="disabled">No inactive projects available</option>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-10">
                                    <label for="view_BillEmployee">Employee</label>
                                    <select class="form-control" name="view_BillEmployee" id="view_BillEmployee" disabled>
                                        <option value="">Select...</option>
                                        <?php if (!empty($activeEmployees)): ?>
                                            <optgroup label="Active Employees">
                                                <?php foreach ($activeEmployees as $row): 
                                                    $emp_fname = $row['emp_fname'];
                                                    $emp_mname = $row['emp_mname'];
                                                    $emp_lname = $row['emp_lname'];
                                                    $emp_sfname = $row['emp_sfname'];

                                                    $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                                    $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
                                                    $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                                    $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                                    $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                                    ?>
                                                    <option value="<?= htmlspecialchars($row['emp_id']) ?>"><?= htmlspecialchars($emp_name) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Active Employees">
                                                <option value="" disabled="disabled">No active employees available</option>
                                            </optgroup>
                                        <?php endif; ?>

                                        <?php if (!empty($inactiveEmployees)): ?>
                                            <optgroup label="Inactive Employees">
                                                <?php foreach ($inactiveEmployees as $row): 
                                                    $emp_fname = $row['emp_fname'];
                                                    $emp_mname = $row['emp_mname'];
                                                    $emp_lname = $row['emp_lname'];
                                                    $emp_sfname = $row['emp_sfname'];

                                                    $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                                    $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
                                                    $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                                    $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                                    $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                                    ?>
                                                    <option value="<?= htmlspecialchars($row['emp_id']) ?>"><?= htmlspecialchars($emp_name) ?>(inactive)</option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Inactive Employees">
                                                <option value="" disabled="disabled">No inactive employees available</option>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-12">
                                    Period Covered
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-lg-5 col-md-12 mb-2">
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="view_BillPeriodFrom" id="view_BillPeriodFrom" placeholder="mm/dd/yyyy" value="" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 mb-2 d-flex align-items-center justify-content-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-5 col-md-12 mb-2">
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="view_BillPeriodTo" id="view_BillPeriodTo" placeholder="mm/dd/yyyy" value="" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillAmount">Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="view_BillAmount" aria-describedby="inputGroupPrepend" placeholder="0.00" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillDateReceived">Date Received SOA by LBP</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="view_BillDateReceived" id="view_BillDateReceived" placeholder="mm/dd/yyyy" value="" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillTotalBilled">Total Amount Billed</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="view_BillTotalBilled" aria-describedby="inputGroupPrepend" placeholder="0.00" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <!--<div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillPartial">Partial Billed</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="view_BillPartial" aria-describedby="inputGroupPrepend" placeholder="0.00" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillPartialCollect">Partial Collected</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="view_BillPartialCollect" aria-describedby="inputGroupPrepend" placeholder="0.00" disabled>
                                    </div>
                                </div>-->
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillAmountCollect">Amount Collected</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="view_BillAmountCollect" aria-describedby="inputGroupPrepend" placeholder="0.00" disabled>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-animated bg-primary progress-bar-striped font-weight-bold" id="view_Progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillDateDue">Date Due</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="view_BillDateDue" id="view_BillDateDue" placeholder="mm/dd/yyyy" value="" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="view_BillDateCollect">Date Collected</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="view_BillDateCollect" id="view_BillDateCollect" placeholder="mm/dd/yyyy" value="" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-10 mb-2">
                                    <label for="view_BillRemarks">Remarks</label>
                                    <textarea class="form-control" name="view_BillRemarks" id="view_BillRemarks" rows="2" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# VIEW BILLING MODAL -->


<!-- EDIT BILLING MODAL -->
<div class="modal fade" id="mdlEditBilling" tabindex="-1" role="dialog" aria-labelledby="mdlEditBillingLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEditBillingLabel">Edit Billing "<span class="font-weight-bold text-warning">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBillingFrm" name="editBillingFrm" method="post">
            <div class="modal-body">
                <div class="scroll-area-lg">
                    <div class="scrollbar-container ps--active-y">
                        <div class="col-md-12">
                            <input type="text" name="edit_BillId" id="edit_BillId" hidden required>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-6">
                                    <label for="edit_BillCategory">Category<span class="text-danger">*</span></label>
                                    <select class="form-control" name="edit_BillCategory" id="edit_BillCategory" required>
                                        <option value="">Select...</option>
                                        <option value="main">Main</option>
                                        <option value="ad-overtime">ADJUSTMENTS-OVERTIME</option>
                                        <option value="ad-retro">ADJUSTMENTS (RETRO)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-10">
                                    <label for="edit_BillProject">Project<span class="text-danger">*</span></label>
                                    <select class="form-control" name="edit_BillProject" id="edit_BillProject" required>
                                        <option value="">Select...</option>
                                        <?php if (!empty($activeProjects)): ?>
                                            <optgroup label="Active Projects">
                                                <?php foreach ($activeProjects as $row): ?>
                                                    <option value="<?= htmlspecialchars($row['project_id']) ?>"><?= htmlspecialchars($row['project_name']) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Active Projects">
                                                <option value="" disabled="disabled">No active projects available</option>
                                            </optgroup>
                                        <?php endif; ?>

                                        <?php if (!empty($inactiveProjects)): ?>
                                            <optgroup label="Inactive Projects">
                                                <?php foreach ($inactiveProjects as $row): ?>
                                                    <option value="<?= htmlspecialchars($row['project_id']) ?>"><?= htmlspecialchars($row['project_name']) ?>(inactive)</option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Inactive Projects">
                                                <option value="" disabled="disabled">No inactive projects available</option>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-10">
                                    <label for="edit_BillEmployee">Employee</label>
                                    <select class="form-control" name="edit_BillEmployee" id="edit_BillEmployee">
                                        <option value="">Select...</option>
                                        <?php if (!empty($activeEmployees)): ?>
                                            <optgroup label="Active Employees">
                                                <?php foreach ($activeEmployees as $row): 
                                                    $emp_fname = $row['emp_fname'];
                                                    $emp_mname = $row['emp_mname'];
                                                    $emp_lname = $row['emp_lname'];
                                                    $emp_sfname = $row['emp_sfname'];

                                                    $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                                    $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
                                                    $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                                    $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                                    $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                                    ?>
                                                    <option value="<?= htmlspecialchars($row['emp_id']) ?>"><?= htmlspecialchars($emp_name) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Active Employees">
                                                <option value="" disabled="disabled">No active employees available</option>
                                            </optgroup>
                                        <?php endif; ?>

                                        <?php if (!empty($inactiveEmployees)): ?>
                                            <optgroup label="Inactive Employees">
                                                <?php foreach ($inactiveEmployees as $row): 
                                                    $emp_fname = $row['emp_fname'];
                                                    $emp_mname = $row['emp_mname'];
                                                    $emp_lname = $row['emp_lname'];
                                                    $emp_sfname = $row['emp_sfname'];

                                                    $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                                    $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : '_ ';
                                                    $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                                    $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                                    $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                                    ?>
                                                    <option value="<?= htmlspecialchars($row['emp_id']) ?>"><?= htmlspecialchars($emp_name) ?>(inactive)</option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php else: ?>
                                            <optgroup label="Inactive Employees">
                                                <option value="" disabled="disabled">No inactive employees available</option>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-12">
                                    Period Covered<span class="text-danger">*</span>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-lg-5 col-md-12 mb-2" id="datepick_From">
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="edit_BillPeriodFrom" id="edit_BillPeriodFrom" placeholder="mm/dd/yyyy" value="" required>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 mb-2 d-flex align-items-center justify-content-center">
                                    <span>to</span>
                                </div>
                                <div class="col-lg-5 col-md-12 mb-2" id="datepick_To">
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="edit_BillPeriodTo" id="edit_BillPeriodTo" placeholder="mm/dd/yyyy" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="edit_BillAmount">Amount<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="edit_BillAmount" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2" id="ed_datepick_Received">
                                    <label for="edit_BillDateReceived">Date Received SOA by LBP</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="edit_BillDateReceived" id="edit_BillDateReceived" placeholder="mm/dd/yyyy" value="">
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2">
                                <label for="edit_BillTotalBilled">Total Amount Billed</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="edit_BillTotalBilled" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <!--<div class="col-md-12 col-lg-6 mb-2">
                                    <label for="edit_BillPartial">Partial Billed</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="edit_BillPartial" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="edit_BillPartialCollect">Partial Collected</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="edit_BillPartialCollect" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                </div>-->
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="edit_BillAmountCollect">Amount Collected</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control input-currency" id="edit_BillAmountCollect" aria-describedby="inputGroupPrepend" placeholder="0.00">
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-animated bg-primary progress-bar-striped font-weight-bold" id="edit_Progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-6 mb-2">
                                    <label for="edit_BillDateDue">Date Due</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="edit_BillDateDue" id="edit_BillDateDue" placeholder="mm/dd/yyyy" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-2" id="datepick_Collect">
                                    <label for="edit_BillDateCollect">Date Collected</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="edit_BillDateCollect" id="edit_BillDateCollect" placeholder="mm/dd/yyyy" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 justify-content-center">
                                <div class="col-md-12 col-lg-10 mb-2">
                                    <label for="edit_BillRemarks">Remarks</label>
                                    <textarea class="form-control" name="edit_BillRemarks" id="edit_BillRemarks" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Save</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# EDIT BILLING MODAL -->


<!-- DELETE BILLING MODAL -->
<div class="modal fade" id="mdlDeleteBilling" tabindex="-1" role="dialog" aria-labelledby="mdlDeleteBilling" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDeleteBillingLabel">DELETE BILL "<span class="font-weight-bold text-danger">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteBillingFrm" name="deleteBillingFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12">
                    <input type="text" name="delete_BillingId" id="delete_BillingId" value="" hidden required>
                    <div class="form-row justify-content-center mb-2">
                        Are you sure you want to DELETE Bill&nbsp;<span class="text-danger font-weight-bold"></span>?
                    </div>
                    <div class="form-row justify-content-center mb-2">
                        <span class="font-weight-bold">This action is irreversible!</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">DELETE</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# DELETE BILLING MODAL -->
