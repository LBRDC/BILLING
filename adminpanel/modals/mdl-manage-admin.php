
<!-- ADD USER MODAL -->
<div class="modal fade" id="mdlAddUser" tabindex="-1" role="dialog" aria-labelledby="mdlAddUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddUserLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserFrm" name="addUserFrm" method="post" >
            <div class="modal-body">
                <div class="">
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">User Information</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="add_UserFname">First Name<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserFname" id="add_UserFname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-d-12 mb-1">
                            <div class="form-row">
                                <label for="add_UserLname">Last Name<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserLname" id="add_UserLname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-sm-6 mb-1">
                            <div class="form-row">
                                <label for="add_UserPosition">Position<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserPosition" id="add_UserPosition" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <!-- <div class="col-lg-6 col-sm-6 mb-1">
                            <div class="form-row">
                               
                            </div>
                        </div> -->
                         <div class="col-lg-6 col-sm-6 mb-1">
                                <label>Options</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="add_UserSuper" value="yes">
                                    <label class="custom-control-label" for="add_UserSuper">Superuser</label>
                                </div>

                                <div class="">
                                <label for="userRole">Roles</label>
                                <select class="form-select" id="add_UserRole" name="add_UserRole">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                </select>
                                </div>
                        </div>
                    </div>
               
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Login Credentials</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_UserName">Username<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserName" id="add_UserName" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_UserPass">Password<span class="text-danger">*</span></label>
                                <input type="password" name="add_UserPass" id="add_UserPass" class="form-control" placeholder="" autocomplete="off" requried>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit"  class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# ADD USER MODAL -->


<!-- VIEW USER MODAL -->
<div class="modal fade" id="mdlViewUser" tabindex="-1" role="dialog" aria-labelledby="mdlViewUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlViewUserLabel">View "<span class="font-weight-bold text-info">USER</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">User Information</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="view_UserFname">First Name</label>
                                <input type="text" name="view_UserFname" id="view_UserFname" class="form-control" placeholder="" autocomplete="off" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="view_UserLname">Last Name</label>
                                <input type="text" name="view_UserLname" id="view_UserLname" class="form-control" placeholder="" autocomplete="off" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="view_UserPosition">Position</label>
                                <input type="text" name="view_UserPosition" id="view_UserPosition" class="form-control" placeholder="" autocomplete="off" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-1">
                            <label>Options</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="view_UserSuper" value="yes" disabled>
                                <label class="custom-control-label" for="view_UserSuper">Superuser</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col-lg-6 col-md-12">
                            <label for="view_UserStatus">Status</label>
                            <select class="form-control" name="view_UserStatus" id="view_UserStatus" disabled>
                                <option value="">Select...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Login Credentials</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="view_UserName">Username</label>
                                <input type="text" name="view_UserName" id="view_UserName" class="form-control" placeholder="" autocomplete="off" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="view_UserPass">Password</label>
                                <input type="password" name="view_UserPass" id="view_UserPass" class="form-control" placeholder="" autocomplete="off" requried readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> <!-- #END# VIEW USER MODAL -->


<!-- EDIT USER MODAL -->
<div class="modal fade" id="mdlEditUser" tabindex="-1" role="dialog" aria-labelledby="mdlEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEditUserLabel">Edit "<span class="font-weight-bold text-warning">USER</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editUserFrm" name="editUserFrm" method="post">
            <div class="modal-body">
                <div class="">
                    <input type="text" name="edit_UserId" id="edit_UserId" value="" hidden readonly required>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">User Information</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="edit_UserFname">First Name<span class="text-danger">*</span></label>
                                <input type="text" name="edit_UserFname" id="edit_UserFname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="edit_UserLname">Last Name<span class="text-danger">*</span></label>
                                <input type="text" name="edit_UserLname" id="edit_UserLname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="edit_UserPosition">Position<span class="text-danger">*</span></label>
                                <input type="text" name="edit_UserPosition" id="edit_UserPosition" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-1">
                                <label>Options</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="edit_UserSuper" value="yes">
                                    <label class="custom-control-label" for="edit_UserSuper">Superuser</label>
                                </div>
                        </div>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col-lg-6 col-md-12">
                            <label for="edit_UserStatus">Status<span class="text-danger">*</span></label>
                            <select class="form-control" name="edit_UserStatus" id="edit_UserStatus">
                                <option value="">Select...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Login Credentials</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="edit_UserName">Username<span class="text-danger">*</span></label>
                                <input type="text" name="edit_UserName" id="edit_UserName" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="edit_UserPass">Password<span class="text-danger">*</span></label>
                                <input type="password" name="edit_UserPass" id="edit_UserPass" class="form-control" placeholder="" autocomplete="off" requried>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# EDIT USER MODAL -->


<!-- DELETE USER MODAL -->
<div class="modal fade" id="mdlDeleteUser" tabindex="-1" role="dialog" aria-labelledby="mdlDeleteUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDeleteUserLabel">DELETE "<span class="font-weight-bold text-danger">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteUserFrm" name="deleteUserFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12">
                    <input type="text" name="delete_UserId" id="delete_UserId" value="" hidden required>
                    <input type="text" name="delete_Username" id="delete_Username" value="" hidden required>
                    <div class="form-row justify-content-center mb-2">
                        Are you sure you want to DELETE&nbsp;<span class="text-danger font-weight-bold"></span>?
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
</div> <!-- #END# DELETE USER MODAL -->