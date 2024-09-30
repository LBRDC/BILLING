<?php
    $stmt1 = $conn->prepare("SELECT * FROM project_tbl ORDER BY project_id DESC");
    $selCluster = $stmt1->execute();

    $prj_status = 1;
    $stmt2 = $conn->prepare("SELECT * FROM project_tbl WHERE project_status = :prj_status");
    $stmt2->bindParam(':prj_status', $prj_status);
    $stmt2->execute();
?>

<!-- #START# manage-project.php -->
                <!-- ### Project PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-culture icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Project Management
                                    <div class="page-title-subheading">
                                        Manage Projects
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item active" aria-current="page">Project</li>
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
                                            <div class="widget-subheading">Active Projects</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddProject" data-toggle="tooltip" data-placement="bottom" title="Add Project">
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
                                    <div class="card-title">Projects</div>
                                    <div class="table-responsive">
                                        <table class="mb-2 mt-2 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Project Name</th>
                                                <th data-dt-order="disable">Description</th>
                                                <th>Date Created</th>
                                                <th>Status</th>
                                                <th data-dt-order="disable">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                    $prj_id = $row['project_id'];
                                                    $prj_name = $row['project_name'];
                                                    $prj_desc = $row['project_description'];
                                                    $prj_contactno = $row['project_contactno'];
                                                    $prj_email = $row['project_email'];
                                                    $prj_address = $row['project_address'];
                                                    $prj_status = $row['project_status'];
                                                    $prj_created = $row['project_created'];

                                                    $statusText = ($prj_status == 1) ? 'Active' : (($prj_status == 3) ? 'Disabled' : 'Inactive');
                                                ?>

                                                <tr id="row<?php echo htmlspecialchars($prj_id); ?>">
                                                    <td><?php echo htmlspecialchars($prj_id); ?></td>
                                                    <td><?php echo htmlspecialchars($prj_name); ?></td>
                                                    <td><?php echo htmlspecialchars($prj_desc); ?></td>
                                                    <td><?php echo htmlspecialchars($prj_created); ?></td>
                                                    <td><?php echo htmlspecialchars($statusText); ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="btn btn-info m-1" id="view-btn" data-toggle="modal" data-target="#mdlViewProject" data-placement="bottom" title="View" 
                                                        data-view-id="<?php echo htmlspecialchars($prj_id); ?>" 
                                                        data-view-name="<?php echo htmlspecialchars($prj_name); ?>" 
                                                        data-view-desc="<?php echo htmlspecialchars($prj_desc); ?>" 
                                                        data-view-contactno="<?php echo htmlspecialchars($prj_contactno); ?>" 
                                                        data-view-email="<?php echo htmlspecialchars($prj_email); ?>" 
                                                        data-view-address="<?php echo htmlspecialchars($prj_address); ?>" 
                                                        data-view-status="<?php echo htmlspecialchars($prj_status); ?>">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="btn btn-warning m-1" id="edit-btn" data-toggle="modal" data-target="#mdlEditProject" data-placement="bottom" title="Edit" 
                                                        data-edit-id="<?php echo htmlspecialchars($prj_id); ?>" 
                                                        data-edit-name="<?php echo htmlspecialchars($prj_name); ?>" 
                                                        data-edit-desc="<?php echo htmlspecialchars($prj_desc); ?>" 
                                                        data-edit-contactno="<?php echo htmlspecialchars($prj_contactno); ?>" 
                                                        data-edit-email="<?php echo htmlspecialchars($prj_email); ?>" 
                                                        data-edit-address="<?php echo htmlspecialchars($prj_address); ?>" 
                                                        data-edit-status="<?php echo htmlspecialchars($prj_status); ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <?php if ($prj_status == 1) { ?>
                                                        <a href="javascript:void(0);" class="btn btn-danger m-1" id="disable-btn" data-toggle="modal" data-target="#mdlDisableProject" data-placement="bottom" title="Disable" 
                                                        data-disable-id="<?php echo htmlspecialchars($prj_id); ?>" 
                                                        data-disable-name="<?php echo htmlspecialchars($prj_name); ?>" 
                                                        data-disable-status="<?php echo htmlspecialchars($prj_status); ?>">
                                                            <i class="fas fa-times-circle"></i>
                                                        </a>
                                                        <?php } else if ($prj_status == 0) { ?>
                                                        <a href="javascript:void(0);" class="btn btn-success m-1" id="enable-btn" data-toggle="modal" data-target="#mdlEnableProject" data-toggle="tooltip" data-placement="bottom" title="Enable" 
                                                        data-enable-id="<?php echo htmlspecialchars($prj_id); ?>" 
                                                        data-enable-name="<?php echo htmlspecialchars($prj_name); ?>" 
                                                        data-enable-status="<?php echo htmlspecialchars($prj_status); ?>">
                                                            <i class="fas fa-check-circle"></i>
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
                </div> <!-- #END# Project PAGE -->
<!-- #END# manage-prject.php -->
