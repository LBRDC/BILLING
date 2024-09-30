document.addEventListener('DOMContentLoaded', function() {
    var table = $('.dt-sort').DataTable({
        //lengthChange: false,
        //pageLength:   1, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [],
        responsive: true,
    });


    $('#filter-btn').click(function() {
        var filterStatus = $('#filter_status').val().toLowerCase();

        table.columns().search('').draw();

        if (filterStatus !== '') {
            table.column(4).search(function(value, index) {
                return filterStatus === '2' ? true : filterStatus === '1' ? value.toLowerCase() === 'active' : filterStatus === '0' ? value.toLowerCase() === 'inactive' : true;
            }).draw();
        }

        table.search('').draw();
    });


    $('#reset-btn').click(function() {
        $('#filter_status').val('');
        table.columns().search('').draw();
        table.search('').draw();
    });
});

document.querySelectorAll('#view-btn').forEach(function(viewBtn) {
    viewBtn.addEventListener('click', function() {
        //var prjId = this.getAttribute('data-view-id');
        var vw_prjName = this.getAttribute('data-view-name');
        var vw_prjDesc = this.getAttribute('data-view-desc');
        var vw_prjContact = this.getAttribute('data-view-contactno');
        var vw_prjEmail = this.getAttribute('data-view-email');
        var vw_prjAddress = this.getAttribute('data-view-address');
        var vw_prjStatus = this.getAttribute('data-view-status');

        document.getElementById('view_PrjName').value = vw_prjName;
        document.getElementById('view_PrjDesc').value = vw_prjDesc;
        document.getElementById('view_PrjContactNo').value = vw_prjContact;
        document.getElementById('view_PrjEmail').value = vw_prjEmail;
        document.getElementById('view_PrjAddress').value = vw_prjAddress;
        document.getElementById('view_PrjStatus').value = vw_prjStatus;

        var modalTitle = document.querySelector('#mdlViewProject .modal-title span');
        modalTitle.textContent = vw_prjName;
    });
});


document.querySelectorAll('#edit-btn').forEach(function(editBtn) {
    editBtn.addEventListener('click', function() {
        var ed_prjId = this.getAttribute('data-edit-id');
        var ed_prjName = this.getAttribute('data-edit-name');
        var ed_prjDesc = this.getAttribute('data-edit-desc');
        var ed_prjContact = this.getAttribute('data-edit-contactno');
        var ed_prjEmail = this.getAttribute('data-edit-email');
        var ed_prjAddress = this.getAttribute('data-edit-address');
        var ed_prjStatus = this.getAttribute('data-edit-status');

        document.getElementById('edit_PrjId').value = ed_prjId;
        document.getElementById('edit_PrjName').value = ed_prjName;
        document.getElementById('edit_PrjDesc').value = ed_prjDesc;
        document.getElementById('edit_PrjContactNo').value = ed_prjContact;
        document.getElementById('edit_PrjEmail').value = ed_prjEmail;
        document.getElementById('edit_PrjAddress').value = ed_prjAddress;
        document.getElementById('edit_PrjStatus').value = ed_prjStatus;

        var modalTitle = document.querySelector('#mdlEditProject .modal-title span');
        modalTitle.textContent = ed_prjName;
    });
});


document.querySelectorAll('#disable-btn').forEach(function(disableBtn) {
    disableBtn.addEventListener('click', function() {
        var dis_PrjId = this.getAttribute('data-disable-id');
        var dis_PrjName = this.getAttribute('data-disable-name');
        var dis_PrjStatus = this.getAttribute('data-disable-status');

        document.getElementById('disable_PrjId').value = dis_PrjId;
        document.getElementById('disable_PrjName').value = dis_PrjName;
        document.getElementById('disable_PrjStatus').value = dis_PrjStatus;

        var modalTitle = document.querySelector('#mdlDisableProject .modal-title span');
        modalTitle.textContent = dis_PrjName;

        var modalBodyName = document.querySelector('#mdlDisableProject .modal-body span.font-weight-bold');
        modalBodyName.textContent = dis_PrjName;
    });
});


document.querySelectorAll('#enable-btn').forEach(function(enableBtn) {
    enableBtn.addEventListener('click', function() {
        var en_PrjId = this.getAttribute('data-enable-id');
        var en_PrjName = this.getAttribute('data-enable-name');
        var en_PrjStatus = this.getAttribute('data-enable-status');

        document.getElementById('enable_PrjId').value = en_PrjId;
        document.getElementById('enable_PrjName').value = en_PrjName;
        document.getElementById('enable_PrjStatus').value = en_PrjStatus;

        var modalTitle = document.querySelector('#mdlEnableProject .modal-title span');
        modalTitle.textContent = en_PrjName;

        var modalBodyName = document.querySelector('#mdlEnableProject .modal-body span.font-weight-bold');
        modalBodyName.textContent = en_PrjName;
    });
});