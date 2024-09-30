// Script for DataTable
/*$(document).ready(function () {
    var table = $('.dt-sort').DataTable({
        //lengthChange: false,
        //pageLength:   5, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [],
    });
});*/

//$.fn.select2.defaults.set("theme", "bootstrap4");

// 9/24/25 User Role prevent editing Billing

$(document).on("change", "#add_Region", function (event) {
  $("#add_employee_Salary").val(event.target.value);
  const id = $(this).find(":selected").data("id");
  $("#add_hidden_id").val(id);
});

$(document).on("change", "#edit_Region", function (event) {
  $("#edit_employee_Salary").val(event.target.value);
  const id = $(this).find(":selected").data("id");
  $("#edit_hidden_id").val(id);
});
  
// 9/24/25 END
