<?php
    /*$stmt1 = $conn->prepare("SELECT * FROM project_tbl ORDER BY project_created DESC");
    $selCluster = $stmt1->execute();

    $prj_status = 1;
    $stmt2 = $conn->prepare("SELECT * FROM project_tbl WHERE project_status = :prj_status");
    $stmt2->bindParam(':prj_status', $prj_status);
    $stmt2->execute();*/

    /*
        accept input periodfrom - periodto

        display data sort by period/month


        fetch data
        process data
        where category = main


    */
?>

<!-- #START# report-billing.php -->
                <!-- ### Report Bill PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-note2 icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Billing Report
                                    <div class="page-title-subheading">
                                        View Billing Report
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Report</li>
                                <li class="breadcrumb-item active" aria-current="page">Billing</li>
                            </ol>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"><?php //echo $stmt2->rowCount(); ?></div>
                                            <div class="widget-subheading">Billings</div>
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
                    </div>-->
                    <!-- Fetch Report -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <form id="fetchBillFrm" name="fetchBillFrm" method="post">
                                <div class="card-body">
                                    <div class="card-title">Period</div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-4 mr-1 mb-2" id="datepick_From">
                                            <label for="fetch_datefrom">From</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="" id="fetch_datefrom" placeholder="mm/dd/yyyy" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 mr-1 mb-2" id="datepick_To">
                                            <label for="fetch_dateto">To</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="" id="fetch_dateto" placeholder="mm/dd/yyyy" required>
                                            </div>
                                        </div>
                                        <!--<div class="col-lg-2 col-md-4 mr-1 mb-2">
                                            <label for="fetch_datefrom">From</label>
                                            <input type="date" class="form-control" name="fetch_datefrom" id="fetch_datefrom" required>
                                        </div> 
                                        <div class="col-lg-2 col-md-4 mr-1 mb-2">
                                            <label for="fetch_dateto">To</label>
                                            <input type="date" class="form-control" name="fetch_dateto" id="fetch_dateto" required>
                                        </div>-->
                                        <div class="col-md-1 d-flex align-items-end mb-2">
                                            <button type="submit" class="btn btn-lg btn-primary mr-2" id="fetch-btn">Fetch</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE -->
                    <div class="row d-none" id="billTable">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title" id="tableTitle">MONTHFROM - MONTHTO</div>
                                    <div class="table-responsive">
                                        <table class="mb-2 mt-2 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Category</th>
                                                <th>Project Name</th>
                                                <th>Employee Name</th>
                                                <th>Period Covered</th>
                                                <th>Amount</th>
                                                <th>Total Amount per Period</th>
                                                <th>Total Amount Billed</th>
                                                <th>Date Received SOA by LBP</th>
                                                <th>Unbilled Portion</th>
                                                <th>Date Due</th>
                                                <th>Date Collected</th>
                                                <th>Amount Collected</th>
                                                <th>Remarks</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Project Name</th>
                                                <th>Period Covered</th>
                                                <th>Amount</th>
                                                <th>Total Amount per Period</th>
                                                <th>Date Received SOA by LBP</th>
                                                <th>Total Amount Billed</th>
                                                <th>Partial Billing</th>
                                                <th>Date Due</th>
                                                <th>Date Collected</th>
                                                <th>Amount Collected</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# Report Bill PAGE -->
<!-- #END# report-billing.php -->
