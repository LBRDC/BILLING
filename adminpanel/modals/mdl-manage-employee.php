<!-- ADD EMPLOYEE MODAL -->
<div class="modal fade" id="mdlAddEmployee" tabindex="-1" role="dialog" aria-labelledby="mdlAddEmployeeLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddEmployeeLabel">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEmployeeFrm" name="addEmployeeFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="add_EmpFname">First Name<span class="text-danger">*</span></label>
                                    <input type="text" name="add_EmpFname" id="add_EmpFname" class="form-control"
                                        placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="add_EmpMname">Middle Name</label>
                                    <input type="text" name="add_EmpMname" id="add_EmpMname" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="add_EmpLname">Last Name<span class="text-danger">*</span></label>
                                    <input type="text" name="add_EmpLname" id="add_EmpLname" class="form-control"
                                        placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-row">
                                    <label for="add_Region">Region<span class="text-danger">*</span></label>

                                    <select class="form-control" name="add_Region" id="add_Region" style="width: 100%">
                                        <option value="">Select...</option>
                                        <?php while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)): ?>
                                            <option value="<?= $row['rate'] ?> " data-id="<?= $row['id'] ?>">
                                                <?= $row['region'] ?>
                                            </option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="employee_Salary">Salary</label>
                                    <input type="text" name="add_employee_Salary" id="add_employee_Salary"
                                        class="form-control" readonly required>
                                </div>
                            </div>
                            <input type="text" id="add_hidden_id" hidden required />
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
</div> <!-- #END# ADD EMPLOYEE MODAL -->


<!-- EDIT EMPLOYEE MODAL -->
<div class="modal fade" id="mdlEditEmployee" tabindex="-1" role="dialog" aria-labelledby="mdlEditEmployeeLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEditEmployeeLabel">Edit <span
                        class="text-warning font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEmployeeFrm" name="editEmployeeFrm" method="post">
                <div class="modal-body">
                    <input type="text" name="edit_EmpId" id="edit_EmpId" class="form-control" readonly hidden required>
                    <div class="col-md-12">
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="edit_EmpFname">First Name<span class="text-danger">*</span></label>
                                    <input type="text" name="edit_EmpFname" id="edit_EmpFname" class="form-control"
                                        placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="edit_EmpMname">Middle Name</label>
                                    <input type="text" name="edit_EmpMname" id="edit_EmpMname" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="edit_EmpLname">Last Name<span class="text-danger">*</span></label>
                                    <input type="text" name="edit_EmpLname" id="edit_EmpLname" class="form-control"
                                        placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <?php
                                $stmt5 = $conn->prepare("SELECT * FROM region");
                                $stmt5->execute();
                                ?>
                                <div class="form-row">
                                    <label for="edit_Region">Region<span class="text-danger">*</span></label>

                                    <select class="form-control" name="edit_Region" id="edit_Region"
                                        style="width: 100%">
                                        <option value="">Select...</option>
                                        <?php while ($row = $stmt5->fetch(mode: PDO::FETCH_ASSOC)): ?>
                                            <option value="<?= $row['rate'] ?>" data-id="<?= $row['id'] ?>">
                                                <?= $row['region'] ?>
                                            </option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-12 mb-1">
                                <div class="form-row">
                                    <label for="edit_employee_Salary">Salary</label>
                                    <input type="text" name="edit_employee_Salary" id="edit_employee_Salary"
                                        class="form-control" readonly required>
                                </div>
                            </div>
                            <input type="text" id="edit_hidden_id" required hidden />
                        </div>
                        <div class="form-row mb-2 justify-content-center">
                            <div class="col-md-3">
                                <label for="edit_EmpStatus">Status<span class="text-danger">*</span></label>
                                <select class="form-control" name="edit_EmpStatus" id="edit_EmpStatus" required>
                                    <option value="">Select...</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
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
</div> <!-- #END# EDIT EMPLOYEE MODAL -->


<!-- DISABLE EMPLOYEE MODAL -->
<div class="modal fade" id="mdlDisableEmployee" tabindex="-1" role="dialog" aria-labelledby="mdlDisableEmployeeLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDisableEmployeeLabel">Disable <span
                        class="text-danger font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="disableEmployeeFrm" name="disableEmployeeFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="disable_EmpId" id="disable_EmpId" value="" hidden required>
                        <input type="text" name="disable_EmpName" id="disable_EmpName" value="" hidden required>
                        <input type="text" name="disable_EmpStatus" id="disable_EmpStatus" value="" hidden required>
                        <div class="form-row mb-2">
                            Are you sure you want to DISABLE&nbsp;<span class=" text-danger font-weight-bold"></span>?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">DISABLE</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- #END# DISABLE EMPLOYEE MODAL -->


<!-- ENABLE EMPLOYEE MODAL -->
<div class="modal fade" id="mdlEnableEmployee" tabindex="-1" role="dialog" aria-labelledby="mdlEnableEmployeeLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEnableEmployeeLabel">Enable <span
                        class="text-success font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="enableEmployeeFrm" name="enableEmployeeFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="enable_EmpId" id="enable_EmpId" value="" hidden required>
                        <input type="text" name="enable_EmpName" id="enable_EmpName" value="" hidden required>
                        <input type="text" name="enable_EmpStatus" id="enable_EmpStatus" value="" hidden required>
                        <div class="form-row mb-2">
                            Are you sure you want to ENABLE&nbsp;<span class=" text-success font-weight-bold"></span>?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">ENABLE</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- #END# ENABLE EMPLOYEE MODAL -->


<!-- IMPORT EXCEL MODAL -->
<div class="modal fade" id="mdlImport" tabindex="-1" role="dialog" aria-labelledby="mdlImportfile" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <span class="text-success font-weight-bold">Upload
                        Excel</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="importfileFrm" name="importFile" method="post">
                <div class="modal-body">
                    <div class="mdl-importfile">
                        <div class="form-row">
                            <label for="sheetName">Name of Sheet<span class="text-danger">*</span></label>
                            <input type="text" name="sheetName" id="sheetName" class="form-control" placeholder=""
                                autocomplete="off" required style="width:100%" value="Janitorial Field Units">
                        </div>

                        <div class="form-row">
                            <label for="startingRow">Excel File<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="importFile">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- #END# IMPORT EXCEL MODAL -->