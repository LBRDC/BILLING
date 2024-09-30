document.addEventListener('DOMContentLoaded', function() {
    var table = $('.dt-sort').DataTable({
        //lengthChange: false,
        //pageLength:   5, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [],
        responsive: true,
    });
});

document.querySelectorAll('#view-btn').forEach(function(viewBtn) {
    viewBtn.addEventListener('click', function() {
        var viewFName = this.getAttribute('data-view-fname');
        var viewLName = this.getAttribute('data-view-lname');
        var viewPosition = this.getAttribute('data-view-position');
        var viewSuper = this.getAttribute('data-view-super');
        var viewUserName = this.getAttribute('data-view-username');
        var viewPass = this.getAttribute('data-view-pass');
        var viewStatus = this.getAttribute('data-view-status');

        document.getElementById('view_UserFname').value = viewFName;
        document.getElementById('view_UserLname').value = viewLName;
        document.getElementById('view_UserPosition').value = viewPosition;
        document.getElementById('view_UserSuper').checked = viewSuper === '1';
        document.getElementById('view_UserName').value = viewUserName;
        document.getElementById('view_UserPass').value = viewPass;
        document.getElementById('view_UserStatus').value = viewStatus;

        var modalTitle = document.querySelector('#mdlViewUser .modal-title span');
        modalTitle.textContent = viewUserName;
    });
});


document.querySelectorAll('#edit-btn').forEach(function(editBtn) {
    editBtn.addEventListener('click', function() {
        var editId = this.getAttribute('data-edit-id');
        var editFName = this.getAttribute('data-edit-fname');
        var editLName = this.getAttribute('data-edit-lname');
        var editPosition = this.getAttribute('data-edit-position');
        var editSuper = this.getAttribute('data-edit-super');
        var editUserName = this.getAttribute('data-edit-username');
        var editPass = this.getAttribute('data-edit-pass');
        var editStatus = this.getAttribute('data-edit-status');

        document.getElementById('edit_UserId').value = editId;
        document.getElementById('edit_UserFname').value = editFName;
        document.getElementById('edit_UserLname').value = editLName;
        document.getElementById('edit_UserPosition').value = editPosition;
        document.getElementById('edit_UserSuper').checked = editSuper === '1';
        document.getElementById('edit_UserName').value = editUserName;
        document.getElementById('edit_UserPass').value = editPass;
        document.getElementById('edit_UserStatus').value = editStatus;

        var modalTitle = document.querySelector('#mdlEditUser .modal-title span');
        modalTitle.textContent = editUserName;
    });
});


document.querySelectorAll('#delete-btn').forEach(function(deleteBtn) {
    deleteBtn.addEventListener('click', function() {
        var deleteId = this.getAttribute('data-delete-id');
        var deleteUserName = this.getAttribute('data-delete-username');

        document.getElementById('delete_UserId').value = deleteId;
        document.getElementById('delete_Username').value = deleteUserName;

        var modalTitle = document.querySelector('#mdlDeleteUser .modal-title span');
        modalTitle.textContent = deleteUserName;

        var modalBodyName = document.querySelector('#mdlDeleteUser .modal-body span.font-weight-bold');
        modalBodyName.textContent = deleteUserName;
    });
});
