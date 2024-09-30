/* ######## Function ######## */
function updateProgressBar(totalBilledElementId, collectedElementId, progressBarSelector) {
    var totalBilled = parseFloat(document.getElementById(totalBilledElementId).value.replace(/,/g, ''));
    var collected = parseFloat(document.getElementById(collectedElementId).value.replace(/,/g, ''));
    var progressBar = document.querySelector(progressBarSelector);
    
    progressBar.classList.remove('bg-warning', 'bg-success', 'bg-primary');
    
    if (isNaN(totalBilled) || isNaN(collected)) {
        progressBar.style.width = '0%';
        progressBar.setAttribute('aria-valuenow', 0);
        progressBar.textContent = '0%';
        return; 
    }
    
    var percent = 0;
    if (totalBilled != 0) {
        percentageCollected = (collected / totalBilled) * 100;
        var percent = percentageCollected.toFixed(2);
    }
    
    progressBar.style.width = percent + '%';
    progressBar.setAttribute('aria-valuenow', percent);
    progressBar.textContent = percent + '%';
    
    if (percent >= 100) {
        progressBar.style.width = '100%';
        progressBar.setAttribute('aria-valuenow', 100);
        progressBar.textContent = '100%';
        progressBar.classList.add('bg-success');
    } else {
        progressBar.classList.add('bg-primary');
    }
}

function updateDue (dateDue, dateDueId) {
    if (!dateDue ||!dateDue.date) {
        //console.log("Invalid dateDue object: ", dateDue);
        return;
    }

    // Create a new Date object from the timestamp
    var selectedDate = new Date(dateDue.date.valueOf());

    // Calculate the due date as 60 days after the received date
    var dueDate = new Date(selectedDate.getTime());
    dueDate.setDate(selectedDate.getDate() + 60);

    // Format the due date as MM/DD/YYYY
    var formattedDate = ('0' + (dueDate.getMonth() + 1)).slice(-2) + '/' + // Ensure month is two digits
                        ('0' + dueDate.getDate()).slice(-2) + '/' + // Ensure day is two digits
                        dueDate.getFullYear(); // Year is automatically four digits

    // Update the #add_BillDateDue input with the formatted due date
    $(dateDueId).val(formattedDate);
}

function attachViewModalListeners() {
    document.querySelectorAll('#view-btn').forEach(function(viewBtn) {
        viewBtn.addEventListener('click', function(e) {
            const formatDate = (dateString) => {
                if (!dateString) {
                    return '';
                }
                const date = new Date(dateString);
                const month = ("0" + (date.getMonth() + 1)).slice(-2); // Months are zero indexed, so we add 1 and pad with leading zeros
                const day = ("0" + date.getDate()).slice(-2);
                const year = date.getFullYear();
                return `${month}/${day}/${year}`;
            };

            var modalInputField = document.querySelectorAll('#mdlViewBilling .input-currency');
            
            var viewId = this.getAttribute('data-view-id');
            var viewCategory = this.getAttribute('data-view-category');
            var viewProject = this.getAttribute('data-view-project');
            var viewEmployee = this.getAttribute('data-view-employee');
            var viewPeriodFrom = this.getAttribute('data-view-periodfrom');
            var viewPeriodTo = this.getAttribute('data-view-periodto');
            var viewAmount = this.getAttribute('data-view-amount');
            var viewDateReceived = this.getAttribute('data-view-daterec');
            var viewTotalBill = this.getAttribute('data-view-totalbill');
            var viewAmountCollect = this.getAttribute('data-view-amountcollect');
            var viewDateDue = this.getAttribute('data-view-datedue');
            var viewDateCollect = this.getAttribute('data-view-datecollected');
            var viewRemarks = this.getAttribute('data-view-remarks');

            var viewDateReceivedFormatted = formatDate(viewDateReceived);
            var viewDateDueFormatted = formatDate(viewDateDue);
            var viewDateCollectFormatted = formatDate(viewDateCollect);
            var viewPeriodFromFormatted = formatDate(viewPeriodFrom);
            var viewPeriodToFormatted = formatDate(viewPeriodTo);

            document.getElementById('view_BillCategory').value = viewCategory;
            document.getElementById('view_BillProject').value = viewProject;
            document.getElementById('view_BillEmployee').value = viewEmployee;
            document.getElementById('view_BillPeriodFrom').value = viewPeriodFromFormatted;
            document.getElementById('view_BillPeriodTo').value = viewPeriodToFormatted;
            document.getElementById('view_BillAmount').value = viewAmount;
            document.getElementById('view_BillDateReceived').value = viewDateReceivedFormatted;
            document.getElementById('view_BillTotalBilled').value = viewTotalBill;
            document.getElementById('view_BillAmountCollect').value = viewAmountCollect;
            document.getElementById('view_BillDateDue').value = viewDateDueFormatted;
            document.getElementById('view_BillDateCollect').value = viewDateCollectFormatted;
            document.getElementById('view_BillRemarks').value = viewRemarks;

            $('#view_BillCategory').trigger('change');
            $('#view_BillProject').trigger('change');
            $('#view_BillEmployee').trigger('change');

            modalInputField.forEach(function(inputField) {
                const parts = inputField.value.split('.');
                const value = parts[0].replace(/\D/g, '');
                const decimal = parts.length > 1? parts[1] : '00';

                let formattedValue = new Intl.NumberFormat('en-EN').format(value);

                if (!isNaN(decimal)) {
                    formattedValue = `${formattedValue}.${decimal}`;
                }

                inputField.value = formattedValue;
            });

            var modalTitle = document.querySelector('#mdlViewBilling .modal-title span');
            modalTitle.textContent = viewId;

            updateProgressBar('view_BillTotalBilled', 'view_BillAmountCollect', '#view_Progress');
        });
    });  
}

function attachDeleteModalListeners() {
    document.querySelectorAll('#delete-btn').forEach(function(deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            var deleteId = this.getAttribute('data-delete-id');
    
            document.getElementById('delete_BillingId').value = deleteId;
    
            var modalTitle = document.querySelector('#mdlDeleteBilling .modal-title span');
            modalTitle.textContent = deleteId;
    
            var modalBodyName = document.querySelector('#mdlDeleteBilling .modal-body span');
            modalBodyName.textContent = deleteId;
        });
    });
}

function attachEditModalListeners() {
    document.querySelectorAll('#edit-btn').forEach(function(editBtn) {
        editBtn.addEventListener('click', function(e) {
            const formatDate = (dateString) => {
                if (!dateString) {
                    return '';
                }
                const date = new Date(dateString);
                const month = ("0" + (date.getMonth() + 1)).slice(-2);
                const day = ("0" + date.getDate()).slice(-2);
                const year = date.getFullYear();
                return `${month}/${day}/${year}`;
            };
            const setDateOnDatePicker = (datepickerId, dateString) => {
                $(`#${datepickerId}`).datepicker('setDate', dateString);
            };
            
            var modalInputField = document.querySelectorAll('#mdlEditBilling .input-currency');
            
            var edId = this.getAttribute('data-edit-id');
            var edCategory = this.getAttribute('data-edit-category');
            var edProject = this.getAttribute('data-edit-project');
            var edEmployee = this.getAttribute('data-edit-employee');
            var edPeriodfrom = this.getAttribute('data-edit-periodfrom');
            var edPeriodto = this.getAttribute('data-edit-periodto');
            var edAmount = this.getAttribute('data-edit-amount');
            var edDateReceived = this.getAttribute('data-edit-daterec');
            var edTotalBill = this.getAttribute('data-edit-totalbill');
            var edAmountCollect = this.getAttribute('data-edit-amountcollect');
            var edDateDue = this.getAttribute('data-edit-datedue');
            var edDateCollect = this.getAttribute('data-edit-datecollected');
            var edRemarks = this.getAttribute('data-edit-remarks');

            var edPeriodFromFormatted = formatDate(edPeriodfrom);
            var edPeriodToFormatted = formatDate(edPeriodto);
            var edDateReceivedFormatted = formatDate(edDateReceived);
            var edDateDueFormatted = formatDate(edDateDue);
            var edDateCollectFormatted = formatDate(edDateCollect);

            document.getElementById('edit_BillId').value = edId;
            document.getElementById('edit_BillCategory').value = edCategory;
            document.getElementById('edit_BillProject').value = edProject;
            document.getElementById('edit_BillEmployee').value = edEmployee;
            document.getElementById('edit_BillAmount').value = edAmount;
            document.getElementById('edit_BillTotalBilled').value = edTotalBill;
            document.getElementById('edit_BillAmountCollect').value = edAmountCollect;
            document.getElementById('edit_BillDateDue').value = edDateDueFormatted;
            document.getElementById('edit_BillRemarks').value = edRemarks;

            setDateOnDatePicker('edit_BillPeriodFrom', edPeriodFromFormatted);
            setDateOnDatePicker('edit_BillPeriodTo', edPeriodToFormatted);
            setDateOnDatePicker('edit_BillDateReceived', edDateReceivedFormatted);
            setDateOnDatePicker('edit_BillDateCollect', edDateCollectFormatted);

            $('#edit_BillCategory').trigger('change');
            $('#edit_BillProject').trigger('change');
            $('#edit_BillEmployee').trigger('change');

            modalInputField.forEach(function(inputField) {
                const parts = inputField.value.split('.');
                const value = parts[0].replace(/\D/g, '');
                const decimal = parts.length > 1? parts[1] : '00';

                let formattedValue = new Intl.NumberFormat('en-EN').format(value);

                // Prevent non-numeric decimal
                if (!isNaN(decimal)) {
                    formattedValue = `${formattedValue}.${decimal}`;
                }

                inputField.value = formattedValue;
            });

            var modalTitle = document.querySelector('#mdlEditBilling .modal-title span');
            modalTitle.textContent = edId;

            updateProgressBar('edit_BillTotalBilled', 'edit_BillAmountCollect', '#edit_Progress');

            document.getElementById('edit_BillDateReceived').addEventListener('change', function() {
                DateAutoFill('edit_BillDateReceived', 'edit_BillDateDue');
            });
            
            $('#ed_datepick_Received .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                orientation: "bottom auto",
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                //console.log(e.date);
                updateDue(e, '#edit_BillDateDue');
            });

            document.getElementById('edit_BillTotalBilled').addEventListener('input', function() {
                updateProgressBar('edit_BillTotalBilled', 'edit_BillAmountCollect', '#edit_Progress');
            });
        });
    });
}
/* ######## END Function ######## */


document.addEventListener('DOMContentLoaded', function() {
    var table = $('.dt-sort').DataTable({
        //lengthChange: false,
        //pageLength:   5, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [], // Initialize without any predefined ordering
        responsive: true,
        columnDefs: [
            {
                targets: '_all', // Apply to all columns
                render: function(data, type, row) {
                    return '<div style="text-align:center">' + data + '</div>'; // Center align data in body cells
                }
            },
            {
                targets: 'header', // Target header cells specifically
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).css('text-align', 'left'); // Align header text to the left
                }
            }
        ],
        drawCallback: function(settings) {
            attachViewModalListeners();
            attachEditModalListeners();
            attachDeleteModalListeners();
        }
    });
    
    $('#filter-btn').click(function() {
        var filterStatus = $('#filter_status').val().toLowerCase();

        // Clear any existing filters and redraw the table
        table.draw();

        if (filterStatus!== '') {
            // Apply filter based on selected status
            table.column(9).search('' + filterStatus + '', false, false).draw(); // Adjust column index as needed
        } else {
            // If "Select..." is selected, reset the table to show all records
            table.columns().search('').draw();
        table.search('').draw();
        }
    });

    $('#reset-btn').click(function() {
        $('#filter_status').val('');
        table.columns().search('').draw();
        table.search('').draw();
    });

    
    /* ######## Select2 ######## */
    $('#add_BillEmployee').select2({
        dropdownParent: $('#mdlAddBilling'),
        theme: 'bootstrap4'
    });
    $('#add_BillProject').select2({
        dropdownParent: $('#mdlAddBilling'),
        theme: 'bootstrap4'
    });
    $('#view_BillEmployee').select2({
        dropdownParent: $('#mdlViewBilling'),
        theme: 'bootstrap4',
        placeholder: '...'
    });
    $('#view_BillProject').select2({
        dropdownParent: $('#mdlViewBilling'),
        theme: 'bootstrap4',
        placeholder: '...'
    });
    $('#edit_BillEmployee').select2({
        dropdownParent: $('#mdlEditBilling'),
        theme: 'bootstrap4',
        placeholder: 'Select...'
    });
    $('#edit_BillProject').select2({
        dropdownParent: $('#mdlEditBilling'),
        theme: 'bootstrap4',
        placeholder: 'Select...'
    });
    /* ######## END Select2 ######## */

    /* ######## Datepicker ######## */
    $('#datepick_From .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    });
    $('#datepick_To .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    });
    $('#ad_datepick_Received .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    }).on('changeDate', function(e) {
        updateDue(e, '#add_BillDateDue');
    });
    $('#datepick_Collect .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    });
    /*$('#ed_datepick_From .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    });
    $('#ed_datepick_To .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    });*/
    /* ######## END Datepicker ######## */
    
    document.getElementById('addBillingFrm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            return false;
        }
    });
    document.getElementById('editBillingFrm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            return false;
        }
    });
    document.getElementById('deleteBillingFrm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            return false;
        }
    });

    document.querySelectorAll('.input-currency').forEach(function(inCurr) {
        inCurr.addEventListener('blur', function(e) {
            if (e.target.value.trim()!== '') {
                const parts = e.target.value.split('.');
                const value = parts[0].replace(/\D/g, '');
                const decimal = parts.length > 1? parts[1] : '00'; 
                
                let newValue = new Intl.NumberFormat('en-EN').format(value); 
                
                // Append decimal if exists and numeric
                if (!isNaN(decimal)) {
                    newValue = `${newValue}.${decimal}`;
                }
                
                // Update the input value with the formatted string
                e.target.value = newValue;
            } else {
                e.target.value = '';
            }
        });
    
        inCurr.addEventListener('keydown', function(e) {
            if (e.keyCode === 13 && e.target.value.trim()!== '') {
                const parts = e.target.value.split('.');
                const value = parts[0].replace(/\D/g, '');
                const decimal = parts.length > 1? parts[1] : '00';
                
                let newValue = new Intl.NumberFormat('en-EN').format(value);
                
                // Append the decimal part if it exists and is numeric
                if (!isNaN(decimal)) {
                    newValue = `${newValue}.${decimal}`;
                }
                
                e.target.value = newValue;
            } else if (e.target.value.trim() === '') {
                e.target.value = '';
            }
        });
    });


    /* ######## MODAL ADD ######## */
    document.getElementById('add_BillTotalBilled').addEventListener('input', function() {
        updateProgressBar('add_BillTotalBilled', 'add_BillAmountCollect', '#add_Progress');
    });

    document.getElementById('add_BillAmountCollect').addEventListener('input', function() {
        updateProgressBar('add_BillTotalBilled', 'add_BillAmountCollect', '#add_Progress');
    });

    document.getElementById('add_BillDateReceived').addEventListener('change', function() {
        DateAutoFill('add_BillDateReceived', 'add_BillDateDue');
    });
    /* ######## END MODAL ADD ######## */


    /* ######## MODAL VIEW ######## */
    attachViewModalListeners();
    /* ######## END MODAL VIEW ######## */


    /* ######## MODAL EDIT ######## */
    attachEditModalListeners();
    /* ######## END MODAL EDIT ######## */

    
    /* ######## MODAL DELETE ######## */
    attachDeleteModalListeners();
    /* ######## END MODAL DELETE ######## */
});