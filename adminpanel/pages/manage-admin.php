<?php
    /*
    Fetch Admin Accounts
    SELECT `admin_id`, `admin_username`, `admin_fname`, `admin_lname`, `admin_pos`, `admin_password`, `admin_super`, `admin_created` FROM `admin_user` WHERE 1
    */

    $stmt1 = $conn->prepare("SELECT * FROM admin_user");
    $stmt1->execute();

    $user_count = $stmt1->rowCount();
?>

<!-- #START# manage-admin.php -->
                <!-- ### ADMIN PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-key icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Account Management
                                    <div class="page-title-subheading">
                                        Manage System Accounts
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item active" aria-current="page">Admin</li>
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
                                            <div class="widget-heading"><?php echo htmlspecialchars($user_count); ?></div>
                                            <div class="widget-subheading">Active Accounts</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddUser" data-toggle="tooltip" data-placement="bottom" title="Add User">
                                                    <i class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i>
                                                </a>
                                            </div>
                                        </div>
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
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Username</th>
                                                <th>Superuser</th>
                                                <th data-dt-order="disable">Action</th>
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
                                                $admin_Id = isset($row['admin_id']) ? $row['admin_id'] : 'null';
                                                $admin_fname = isset($row['admin_fname']) ? $row['admin_fname'] : 'null';
                                                $admin_lname = isset($row['admin_lname']) ? $row['admin_lname'] : 'null';
                                                $admin_pos = isset($row['admin_pos']) ? $row['admin_pos'] : 'null';
                                                $admin_username = isset($row['admin_username']) ? $row['admin_username'] : 'null';
                                                $admin_password = isset($row['admin_password']) ? $row['admin_password'] : '';
                                                $admin_super = isset($row['admin_super']) ? $row['admin_super'] : 'null';
                                                $admin_status = isset($row['admin_status']) ? $row['admin_status'] : 'null';
                                                $superuser = $admin_super == 1 ? 'Yes' : 'No';

                                            ?>
                                            <tr id="<?php echo htmlspecialchars($admin_Id); ?>">
                                                <td>
                                                <?php 
                                                    echo htmlspecialchars($admin_fname) . " ";
                                                    echo htmlspecialchars($admin_lname);
                                                ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($admin_pos); ?></td>
                                                <td><?php echo htmlspecialchars($admin_username); ?></td>
                                                <td><?php echo htmlspecialchars($superuser); ?></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-info m-1" id="view-btn" data-toggle="modal" data-target="#mdlViewUser" data-toggle="tooltip" data-placement="bottom" title="View"
                                                    data-view-fname = "<?php echo htmlspecialchars($admin_fname); ?>" 
                                                    data-view-lname = "<?php echo htmlspecialchars($admin_lname); ?>" 
                                                    data-view-position = "<?php echo htmlspecialchars($admin_pos); ?>" 
                                                    data-view-Super = "<?php echo htmlspecialchars($admin_super); ?>"
                                                    data-view-username = "<?php echo htmlspecialchars($admin_username); ?>"
                                                    data-view-pass = "<?php echo htmlspecialchars($admin_password); ?>"
                                                    data-view-status = "<?php echo htmlspecialchars($admin_status); ?>">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                    <?php if($admin_Id != 1) { ?>
                                                    <a href="javascript:void(0);" class="btn btn-warning m-1" id="edit-btn" data-toggle="modal" data-target="#mdlEditUser" data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                    data-edit-id = "<?php echo htmlspecialchars($admin_Id); ?>"
                                                    data-edit-fname = "<?php echo htmlspecialchars($admin_fname); ?>" 
                                                    data-edit-lname = "<?php echo htmlspecialchars($admin_lname); ?>" 
                                                    data-edit-position = "<?php echo htmlspecialchars($admin_pos); ?>" 
                                                    data-edit-Super = "<?php echo htmlspecialchars($admin_super); ?>"
                                                    data-edit-username = "<?php echo htmlspecialchars($admin_username); ?>"
                                                    data-edit-pass = "<?php echo htmlspecialchars($admin_password); ?>"
                                                    data-edit-status = "<?php echo htmlspecialchars($admin_status); ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-danger m-1" id="delete-btn" data-toggle="modal" data-target="#mdlDeleteUser" data-toggle="tooltip" data-placement="bottom" title="Delete" 
                                                    data-delete-id = "<?php echo htmlspecialchars($admin_Id); ?>"
                                                    data-delete-username = "<?php echo htmlspecialchars($admin_username); ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <?php } ?>
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
                </div> <!-- #END# ADMIN PAGE -->
<!-- #END# manage-admin.php -->
