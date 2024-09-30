<!-- #START# footer.php -->
<!-- MAIN FOOTER -->
<div class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer__inner justify-content-center">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <div class="col-md-12">
                        <span>copyright &copy; 2024 - developed by
                            <b><a href="https://lbpresources.com" target="_blank">LBP Resources and Development
                                    Corp.</a></b>
                        </span>
                    </div>
                    <!--<div class="col-md-12">
                                        <a href="javascript:void(0);" class="text-monospace justify-content-center" data-toggle="modal" data-target="#mdlSystemInfo">
                                            <u>v0.3.0-alpha</u>
                                        </a>
                                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div> <!-- #END# MAIN FOOTER -->
</div> <!-- END app-main__inner div -->
</div> <!-- END app-main div -->
</div> <!-- END app-container div -->

<!-- SCRIPTS -->
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/main.min.js"></script>
<script type="text/javascript" src="../../js/sweetalert.js"></script>
<script type="text/javascript" src="../../js/select2.min.js"></script>
<script type="text/javascript" src="../../js/pdfmake.min.js"></script>
<script type="text/javascript" src="../../js/vfs_fonts.js"></script>
<script type="text/javascript" src="../../js/datatables.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="./js/session.js"></script>
<script type="text/javascript" src="./js/admin-ajax.js"></script>
<script type="text/javascript" src="./js/admin-myjs.js"></script>
<?php
if (!isset($page)) {
    /* Dashboard */
    echo '<script src="./js/pgjs/dashboard-js.js"></script>';
} else {
    switch ($page) {
        case 'manage-project':
            echo '<script src="./js/pgjs/project-js.js"></script>';
            break;
        case 'manage-employee':
            echo '<script src="./js/pgjs/xlsx.full.min.js"></script>';
            echo '<script src="./js/pgjs/employee-js.js"></script>';
            break;
        case 'manage-billing':
            echo '<script src="./js/pgjs/billing-js.js"></script>';
            break;
        case 'report-billing':
            echo '<script src="./js/pgjs/report-bill-js.js"></script>';
            break;
        case 'manage-admin':
            echo '<script src="./js/pgjs/admin-js.js"></script>';
            break;
        case 'manage-admin-log':
            echo '<script src="./js/pgjs/editlog-js.js"></script>';
            break;
        default:
            break;
    }
}
?>
</body>

</html>