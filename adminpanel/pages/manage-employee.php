<?php
// $stmt1 = $conn->prepare("SELECT * FROM employee_tbl ORDER BY emp_id DESC");
$stmt1 = $conn->prepare("SELECT A.emp_id, A.emp_fname, A.emp_mname, A.emp_lname, A.emp_sfname, A.emp_status, A.emp_created, B.id, B.region, B.rate  FROM employee_tbl as A INNER JOIN region as B ON B.id = A.region");
$selEmp = $stmt1->execute();

$emp_status = 1;
$stmt2 = $conn->prepare("SELECT * FROM employee_tbl WHERE emp_status = :emp_status");
$stmt2->bindParam(':emp_status', $emp_status);
$stmt2->execute();

// 9/24/24
$stmt3 = $conn->prepare("SELECT * FROM region");
$stmt3->execute();
// END

?>

<!-- #START# manage-employee.php -->
<!-- ### EMPLOYEE PAGE ### -->
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-grow-early"></i>
                </div>
                <div>Employee Management
                    <div class="page-title-subheading">
                        Manage Employees
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                    <li class="breadcrumb-item">Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Employee</li>
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
                            <div class="widget-heading"><?php echo $stmt2->rowCount(); ?></div>
                            <div class="widget-subheading">Active Employees</div>
                        </div>
                        <div class="widget-content-right">
                            <div>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddEmployee"
                                    data-toggle="tooltip" data-placement="bottom" title="Add Employee">
                                    <i class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2 col-xl-4">
            <div class="card mb-3 widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-subheading">Import Excel file</div>
                        </div>
                        <div class="widget-content-right">
                            <div>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlImport"
                                    data-toggle="tooltip" data-placement="bottom" title="Add Employee">
                                    <i class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i>
                                </a>
                                <!-- <button type="button" id="importBtn" class="importBtn"> <i
                                        class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i></button>
                                <input type="file" id="importFile" hidden
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /> -->
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
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
                    <div class="card-title">Employees</div>
                    <div class="table-responsive">
                        <table class="mb-2 mt-2 table table-hover dt-sort" id="tableList" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th data-dt-order="disable">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                    $emp_id = $row['emp_id'];
                                    $emp_fname = $row['emp_fname'];
                                    $emp_mname = $row['emp_mname'];
                                    $emp_lname = $row['emp_lname'];
                                    $emp_sfname = $row['emp_sfname'];
                                    $emp_status = $row['emp_status'];
                                    $emp_created = $row['emp_created'];
                                    $emp_region = $row['region'];
                                    $emp_rate = $row['rate'];
                                    $emp_regionID = $row['id'];

                                    $statusText = ($emp_status == 1) ? 'Active' : (($emp_status == 3) ? 'Disabled' : 'Inactive');

                                    $disp_fname = $emp_fname != '' ? $emp_fname : 'null';
                                    $disp_mname = $emp_mname != '' ? substr($emp_mname, 0, 1) . ". " : ' ';
                                    $disp_lname = $emp_lname != '' ? $emp_lname : 'null';
                                    // $disp_sfname = $emp_sfname != '' ? $emp_sfname : '';
                                    // $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;
                                    $emp_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname
                                        ?>

                                    <tr id="row<?php echo htmlspecialchars($emp_id); ?>">
                                        <td><?php echo htmlspecialchars($emp_id); ?></td>
                                        <td><?php echo htmlspecialchars($emp_name); ?></td>
                                        <td><?php echo htmlspecialchars($statusText); ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-warning m-1" id="edit-btn"
                                                data-toggle="modal" data-target="#mdlEditEmployee" data-placement="bottom"
                                                title="Edit" data-edit-id="<?php echo htmlspecialchars($emp_id); ?>"
                                                data-edit-fname="<?php echo htmlspecialchars($emp_fname); ?>"
                                                data-edit-mname="<?php echo htmlspecialchars($emp_mname); ?>"
                                                data-edit-lname="<?php echo htmlspecialchars($emp_lname); ?>"
                                                data-edit-sfname="<?php echo htmlspecialchars($emp_sfname); ?>"
                                                data-edit-status="<?php echo htmlspecialchars($emp_status); ?>"
                                                data-edit-display="<?php echo htmlspecialchars($emp_name); ?>"
                                                data-edit-region="<?php echo htmlspecialchars($emp_region); ?>"
                                                data-edit-regionID="<?php echo htmlspecialchars($emp_regionID); ?>"
                                                data-edit-salary="<?php echo htmlspecialchars($emp_rate); ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($emp_status == 1) { ?>
                                                <a href="javascript:void(0);" class="btn btn-danger m-1" id="disable-btn"
                                                    data-toggle="modal" data-target="#mdlDisableEmployee"
                                                    data-placement="bottom" title="Disable"
                                                    data-disable-id="<?php echo htmlspecialchars($emp_id); ?>"
                                                    data-disable-name="<?php echo htmlspecialchars($emp_name); ?>"
                                                    data-disable-status="<?php echo htmlspecialchars($emp_status); ?>">
                                                    <i class="fas fa-times-circle"></i>
                                                </a>
                                            <?php } else if ($emp_status == 0) { ?>
                                                    <a href="javascript:void(0);" class="btn btn-success m-1" id="enable-btn"
                                                        data-toggle="modal" data-target="#mdlEnableEmployee" data-toggle="tooltip"
                                                        data-placement="bottom" title="Enable"
                                                        data-enable-id="<?php echo htmlspecialchars($emp_id); ?>"
                                                        data-enable-name="<?php echo htmlspecialchars($emp_name); ?>"
                                                        data-enable-status="<?php echo htmlspecialchars($emp_status); ?>">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #END# EMPLOYEE PAGE -->
<!-- #END# manage-employee.php -->