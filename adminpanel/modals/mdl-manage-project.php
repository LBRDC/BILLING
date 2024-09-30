
<!-- ADD PROJECT MODAL -->
<div class="modal fade" id="mdlAddProject" tabindex="-1" role="dialog" aria-labelledby="mdlAddProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddProjectLabel">Add Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectFrm" name="addProjectFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-row mb-2">
                        <label for="add_PrjName">Name<span class="text-danger">*</span></label>
                        <input type="text" name="add_PrjName" id="add_PrjName" class="form-control" placeholder="" autocomplete="off" required>
                    </div>
                    <div class="form-row mb-2">
                        <label for="add_PrjDesc">Description</label>
                        <textarea class="form-control" name="add_PrjDesc" id="add_PrjDesc" rows="2"></textarea>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-12 col-lg-6 mb-2">
                            <label for="add_PrjContactNo">Contact No</label>
                            <input type="text" name="add_PrjContactNo" id="add_PrjContactNo" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <label for="add_PrjEmail">Contact Email</label>
                            <input type="email" name="add_PrjEmail" id="add_PrjEmail" class="form-control" placeholder="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <label for="add_PrjAddress">Address</label>
                        <textarea class="form-control" name="add_PrjAddress" id="add_PrjAddress" rows="2"></textarea>
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
</div> <!-- #END# ADD PROJECT MODAL -->


<!-- VIEW PROJECT MODAL -->
<div class="modal fade" id="mdlViewProject" tabindex="-1" role="dialog" aria-labelledby="mdlViewProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlViewProjectLabel">View <span class="text-info font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-row mb-2">
                        <label for="view_PrjName">Name</label>
                        <input type="text" name="view_PrjName" id="view_PrjName" class="form-control" placeholder="" autocomplete="off" value="" disabled>
                    </div>
                    <div class="form-row mb-2">
                        <label for="view_PrjDesc">Description</label>
                        <textarea class="form-control" name="view_PrjDesc" id="view_PrjDesc" rows="2" disabled></textarea>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-12 col-lg-6 mb-2">
                            <label for="view_PrjContactNo">Contact No</label>
                            <input type="text" name="view_PrjContactNo" id="view_PrjContactNo" class="form-control" placeholder="" autocomplete="off" disabled>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <label for="view_PrjEmail">Contact Email</label>
                            <input type="email" name="view_PrjEmail" id="view_PrjEmail" class="form-control" placeholder="" autocomplete="off" disabled>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <label for="view_PrjAddress">Address</label>
                        <textarea class="form-control" name="view_PrjAddress" id="view_PrjAddress" rows="2" disabled></textarea>
                    </div>
                    <div class="form-row mb-2 justify-content-center">
                        <div class="col-md-6">
                            <label for="view_PrjStatus">Status</label>
                            <select class="form-control" name="view_PrjStatus" id="view_PrjStatus" disabled>
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
            </div>
        </div>
    </div>
</div> <!-- #END# VIEW PROJECT MODAL -->


<!-- EDIT PROJECT MODAL -->
<div class="modal fade" id="mdlEditProject" tabindex="-1" role="dialog" aria-labelledby="mdlEditProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEditProjectLabel">Edit <span class="text-warning font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProjectFrm" name="editProjectFrm" method="post">
            <div class="modal-body">
                <input type="text" name="edit_PrjId" id="edit_PrjId" hidden required>
                <div class="col-md-12">
                    <div class="form-row mb-2">
                        <label for="edit_PrjName">Name<span class="text-danger">*</span></label>
                        <input type="text" name="edit_PrjName" id="edit_PrjName" class="form-control" placeholder="" autocomplete="off" required>
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PrjDesc">Description</label>
                        <textarea class="form-control" name="edit_PrjDesc" id="edit_PrjDesc" rows="2"></textarea>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-12 col-lg-6 mb-2">
                            <label for="edit_PrjContactNo">Contact No</label>
                            <input type="text" name="edit_PrjContactNo" id="edit_PrjContactNo" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <label for="edit_PrjEmail">Contact Email</label>
                            <input type="email" name="edit_PrjEmail" id="edit_PrjEmail" class="form-control" placeholder="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PrjAddress">Address</label>
                        <textarea class="form-control" name="edit_PrjAddress" id="edit_PrjAddress" rows="2"></textarea>
                    </div>
                    <div class="form-row mb-2 justify-content-center">
                        <div class="col-md-6">
                            <label for="edit_PrjStatus">Status<span class="text-danger">*</span></label>
                            <select class="form-control" name="edit_PrjStatus" id="edit_PrjStatus" required>
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
</div> <!-- #END# EDIT PROJECT MODAL -->


<!-- DISABLE PROJECT MODAL -->
<div class="modal fade" id="mdlDisableProject" tabindex="-1" role="dialog" aria-labelledby="mdlDisableProjectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDisableProjectLabel">Disable <span class="text-danger font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="disableProjectFrm" name="disableProjectFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12">
                    <input type="text" name="disable_PrjId" id="disable_PrjId" value="" hidden required>
                    <input type="text" name="disable_PrjName" id="disable_PrjName" value="" hidden required>
                    <input type="text" name="disable_PrjStatus" id="disable_PrjStatus" value="" hidden required>
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
</div> <!-- #END# DISABLE PROJECT MODAL -->


<!-- ENABLE PROJECT MODAL -->
<div class="modal fade" id="mdlEnableProject" tabindex="-1" role="dialog" aria-labelledby="mdlEnableProjectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEnableProjectLabel">Enable <span class="text-success font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="enableProjectFrm" name="enableProjectFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12">
                    <input type="text" name="enable_PrjId" id="enable_PrjId" value="" hidden required>
                    <input type="text" name="enable_PrjName" id="enable_PrjName" value="" hidden required>
                    <input type="text" name="enable_PrjStatus" id="enable_PrjStatus" value="" hidden required>
                    <div class="form-row mb-2">
                        Are you sure you want to ENABLE&nbsp;<span class=" text-success font-weight-bold">NAME</span>?
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
</div> <!-- #END# ENABLE PROJECT MODAL -->
