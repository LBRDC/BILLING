var table;
document.addEventListener('DOMContentLoaded', function() {
    table = $('.dt-sort').DataTable({
        //lengthChange: false,
        pageLength:   1000, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [],
        responsive: true,
        columnDefs: [
            {
                targets: '_all', // Apply to all columns
                render: function(data, type, row) {
                    return '<div style="text-align:left">' + data + '</div>'; // Center align data in body cells
                }
            },
            {
                targets: 'header', // Target header cells specifically
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).css('text-align', 'left'); // Align header text to the left
                }
            }
        ],
        layout: {
            topStart: 'buttons'
        },
        buttons: [
            { extend: 'excel', className: 'btn-success' }
        ]
    });

    //datepicker
    $('#datepick_From .input-group.date').datepicker({
        format: "yyyy-mm-dd",
        startView: 1,
        todayBtn: "linked",
        clearBtn: true,
        orientation: "bottom auto",
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true
    });
    $('#datepick_To .input-group.date').datepicker({
        format: "yyyy-mm-dd",
        startView: 1,
        todayBtn: "linked",
        clearBtn: true,
        orientation: "bottom auto",
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true
    });
});


// report-bill FETCH 
$(document).on("submit","#fetchBillFrm" , function(event) {
    event.preventDefault();

    //hide card if d-none exist
    if (!document.getElementById('billTable').classList.contains('d-none')) {
        hideCard();
    }

    var formData = {
        'fetch_datefrom': $('#fetch_datefrom').val(),
        'fetch_dateto': $('#fetch_dateto').val()
    };

    //console.log(formData); //DEBUG
    
    var isValid;
    if (formData['fetch_datefrom'] === '' || formData['fetch_dateto'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in the required fields.",
        });
        return;
    }

    console.log("INPUT VALIDATED " + isValid); //DEBUG
    console.log(formData); //DEBUG

    $.ajax({
        url: 'query/fetch_ReportBill.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                //Datatables Add Rows response.data
                /* TABLE COLUMN
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
                */

                // Assuming 'table' is your DataTable instance
                // Clear existing rows before adding new ones
                table.clear().draw();

                /*
                    For each employee in project list below project

                */
                $.each(response.data, function(index, item) {
                    // Prepare the row data
                    var row = [
                        item.formattedcategory, // Category
                        item.formattedproject, // Project
                        item.formattedemployee, // Employee
                        item.formattedperiod, // Period Covered
                        item.bill_amount, // Amount
                        item.bill_total_period, // Total Amount per Period
                        item.bill_total_billed, // Total Amount Billed
                        item.bill_date_received, // Date Received SOA by LBP
                        item.bill_unbilled, // Unbilled Portion
                        item.bill_date_due, // Date Due
                        item.bill_date_collected, // Date Collected
                        item.bill_amount_collected, // Amount Collected
                        item.bill_remarks // Remarks
                    ];

                    // Add the row to the DataTable
                    table.row.add(row).draw(false);
                });

                //Update Card Title
                $("#tableTitle").text(response.title);
                //Show Card
                showCard();
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response.msg,
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while adding Project. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "Please fill in all fields.",
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "System error occurred.",
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});


function showCard() {
    document.getElementById('billTable').classList.remove('d-none');
}

function hideCard() {
    document.getElementById('billTable').classList.add('d-none');
}