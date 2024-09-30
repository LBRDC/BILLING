<?php
    /*
    Fetch Admin Accounts
    SELECT `admin_id`, `admin_username`, `admin_fname`, `admin_lname`, `admin_pos`, `admin_password`, `admin_super`, `admin_created` FROM `admin_user` WHERE 1
    */

    $stmt1 = $conn->prepare("SELECT * FROM admin_editlog ORDER BY log_id DESC");
    $stmt1->execute();

    $log_count = $stmt1->rowCount();
?>

<!-- #START# manage-admin.php -->
                <!-- ### ADMIN PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-note icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Sytem Edit Logs
                                    <div class="page-title-subheading">
                                        View Edit Logs
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                    <li class="breadcrumb-item">Management</li>
                                    <li class="breadcrumb-item">Admin</li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Logs</li>
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
                                            <div class="widget-heading"><?php echo htmlspecialchars($log_count); ?></div>
                                            <div class="widget-subheading">Log Count</div>
                                        </div>
                                        <!--<div class="widget-content-right">
                                            <div>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddUser" data-toggle="tooltip" data-placement="bottom" title="Add User">
                                                    <i class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i>
                                                </a>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Filter Options 
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
                    </div>-->
                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">System Accounts</div>
                                    <div class="table-responsive">
                                        <table class="mb-2 mt-2 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Page</th>
                                                <th>Action</th>
                                                <th>User</th>
                                                <th>Timestamp</th>
                                                <!--<th data-dt-order="disable">Action</th>-->
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Username</th>
                                                <th>Superuser</th>
                                                <th data-dt-order="disable">Action</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                            <?php 
                                            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                $log_id = isset($row['log_id']) ? $row['log_id'] : 'null';
                                                $log_page = isset($row['log_page']) ? $row['log_page'] : 'null';
                                                $log_action = isset($row['log_action']) ? $row['log_action'] : 'null';
                                                $log_user = isset($row['log_user']) ? $row['log_user'] : 'null';
                                                $log_timestamp = isset($row['log_timestamp']) ? $row['log_timestamp'] : 'null';

                                            ?>
                                            <tr id="<?php echo htmlspecialchars($log_id); ?>">
                                                <td><?php echo htmlspecialchars($log_id); ?></td>
                                                <td><?php echo htmlspecialchars($log_page); ?></td>
                                                <td><?php echo htmlspecialchars($log_action); ?></td>
                                                <td><?php echo htmlspecialchars($log_user); ?></td>
                                                <td><?php echo htmlspecialchars($log_timestamp); ?></td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# ADMIN PAGE -->
<!-- #END# manage-admin.php -->
