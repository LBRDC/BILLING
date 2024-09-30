document.addEventListener("DOMContentLoaded", function () {
  var table = $(".dt-sort").DataTable({
    //lengthChange: false,
    //pageLength:   1, // Set the default number of entries to display per page
    //ordering: false, // Disable sorting
    //searching: false, // Disable searching
    //info: false,
    //pagingType: 'simple',
    order: [],
    responsive: true,
  });

  
  // $(".dt-search").children("input").on("input", ()=>{
  //   const value = $(".dt-search").children("#dt-search-0").val()
  //   console.log(value);
  // })



  $("#filter-btn").click(function () {
    var filterStatus = $("#filter_status").val().toLowerCase();

    table.columns().search("").draw();

    if (filterStatus !== "") {
      table
        .column(2)
        .search(function (value, index) {
          return filterStatus === "2"
            ? true
            : filterStatus === "1"
            ? value.toLowerCase() === "active"
            : filterStatus === "0"
            ? value.toLowerCase() === "inactive"
            : true;
        })
        .draw();
    }

    table.search("").draw();
  });

  $("#reset-btn").click(function () {
    $("#filter_status").val("");
    table.columns().search("").draw();
    table.search("").draw();
  });
});

document.querySelectorAll("#edit-btn").forEach(function (editBtn) {
  editBtn.addEventListener("click", function () {
    var ed_empId = this.getAttribute("data-edit-id");
    var ed_empFname = this.getAttribute("data-edit-fname");
    var ed_empMname = this.getAttribute("data-edit-mname");
    var ed_empLname = this.getAttribute("data-edit-lname");
    var ed_empSfname = this.getAttribute("data-edit-sfname");
    var ed_empStatus = this.getAttribute("data-edit-status");
    var ed_display = this.getAttribute("data-edit-display").toString();
    var ed_regionID = this.getAttribute("data-edit-regionID").toString();
    var ed_salary = this.getAttribute("data-edit-salary").toString();

    document.getElementById("edit_EmpId").value = ed_empId;
    document.getElementById("edit_EmpFname").value = ed_empFname;
    document.getElementById("edit_EmpMname").value = ed_empMname;
    document.getElementById("edit_EmpLname").value = ed_empLname;
    // document.getElementById("edit_EmpSfname").value = ed_empSfname;
    document.getElementById("edit_EmpStatus").value = ed_empStatus;
    document.getElementById("edit_Region").value = ed_salary;
    document.getElementById("edit_employee_Salary").value = ed_salary;
    document.getElementById("edit_hidden_id").value = ed_regionID;
    

    var modalTitle = document.querySelector(
      "#mdlEditEmployee .modal-title span"
    );
    modalTitle.textContent = ed_display;
  });
});

document.querySelectorAll("#disable-btn").forEach(function (disableBtn) {
  disableBtn.addEventListener("click", function () {
    var dis_EmpId = this.getAttribute("data-disable-id");
    var dis_EmpName = this.getAttribute("data-disable-name");
    var dis_EmpStatus = this.getAttribute("data-disable-status");

    document.getElementById("disable_EmpId").value = dis_EmpId;
    document.getElementById("disable_EmpName").value = dis_EmpName;
    document.getElementById("disable_EmpStatus").value = dis_EmpStatus;

    var modalTitle = document.querySelector(
      "#mdlDisableEmployee .modal-title span"
    );
    modalTitle.textContent = dis_EmpName;

    var modalBodyName = document.querySelector(
      "#mdlDisableEmployee .modal-body span.font-weight-bold"
    );
    modalBodyName.textContent = dis_EmpName;
  });
});

document.querySelectorAll("#enable-btn").forEach(function (enableBtn) {
  enableBtn.addEventListener("click", function () {
    var en_EmpId = this.getAttribute("data-enable-id");
    var en_EmpName = this.getAttribute("data-enable-name");
    var en_EmpStatus = this.getAttribute("data-enable-status");

    document.getElementById("enable_EmpId").value = en_EmpId;
    document.getElementById("enable_EmpName").value = en_EmpName;
    document.getElementById("enable_EmpStatus").value = en_EmpStatus;

    var modalTitle = document.querySelector(
      "#mdlEnableEmployee .modal-title span"
    );
    modalTitle.textContent = en_EmpName;

    var modalBodyName = document.querySelector(
      "#mdlEnableEmployee .modal-body span.font-weight-bold"
    );
    modalBodyName.textContent = en_EmpName;
  });
});


// 08/25/24


// END