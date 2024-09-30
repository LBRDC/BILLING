function formatDate(input) {
  const parts = input.split("/");
  if (parts.length !== 3) {
    console.log("Invalid date format. Expected MM/DD/YYYY");
    return input;
  }
  const [month, day, year] = parts;
  return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
}

/* ########## PROJECT ########## */
// manage-project ADD
$(document).on("submit", "#addProjectFrm", function (event) {
  event.preventDefault();

  var formData = {
    add_PrjName: $("#add_PrjName").val(),
    add_PrjDesc: $("#add_PrjDesc").val(),
    add_PrjContactNo: $("#add_PrjContactNo").val(),
    add_PrjEmail: $("#add_PrjEmail").val(),
    add_PrjAddress: $("#add_PrjAddress").val(),
  };

  //console.log(formData); //DEBUG

  var isValid;
  if (formData["add_PrjName"] === "") {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/add_ProjectExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " added.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-project";
        });
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-project EDIT
$(document).on("submit", "#editProjectFrm", function (event) {
  event.preventDefault();

  var formData = {
    edit_PrjId: $("#edit_PrjId").val(),
    edit_PrjName: $("#edit_PrjName").val(),
    edit_PrjDesc: $("#edit_PrjDesc").val(),
    edit_PrjContactNo: $("#edit_PrjContactNo").val(),
    edit_PrjEmail: $("#edit_PrjEmail").val(),
    edit_PrjAddress: $("#edit_PrjAddress").val(),
    edit_PrjStatus: $("#edit_PrjStatus").val(),
  };

  //console.log(formData); //DEBUG

  var isValid;
  if (
    formData["edit_PrjId"] === "" ||
    formData["edit_PrjName"] === "" ||
    formData["edit_PrjStatus"] === ""
  ) {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/edit_ProjectExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " updated.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-project";
        });
      } else if (response.res == "exists") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "An error occurred while updating Project. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-project DISABLE
$(document).on("submit", "#disableProjectFrm", function (event) {
  event.preventDefault();

  var formData = {
    disable_PrjId: $("#disable_PrjId").val(),
    disable_PrjName: $("#disable_PrjName").val(),
    disable_PrjStatus: $("#disable_PrjStatus").val(),
  };

  var isValid;
  if (
    formData["disable_PrjId"] === "" ||
    formData["disable_PrjName"] === "" ||
    formData["disable_PrjStatus"] === ""
  ) {
    isValid = false;
  } else {
    isValid = true;
  }

  if (!isValid) {
    Swal.fire({
      icon: "warning",
      title: "Incomplete",
      text: "required field missing.",
    });
    return;
  }

  //console.log("INPUT VALIDATED"); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/status_ProjectDisableExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " disabled.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-project";
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "incomplete") {
        Swal.fire({
          icon: "warning",
          title: "Incomplete",
          text: "required fields missing.",
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.msg,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "System error occurred.",
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-project ENABLE
$(document).on("submit", "#enableProjectFrm", function (event) {
  event.preventDefault();

  var formData = {
    enable_PrjId: $("#enable_PrjId").val(),
    enable_PrjName: $("#enable_PrjName").val(),
    enable_PrjStatus: $("#enable_PrjStatus").val(),
  };

  var isValid;
  if (
    formData["enable_PrjId"] === "" ||
    formData["enable_PrjName"] === "" ||
    formData["enable_PrjStatus"] === ""
  ) {
    isValid = false;
  } else {
    isValid = true;
  }

  if (!isValid) {
    Swal.fire({
      icon: "warning",
      title: "Incomplete",
      text: "required field missing.",
    });
    return;
  }

  //console.log("INPUT VALIDATED"); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/status_ProjectEnableExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " enabled.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-project";
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "incomplete") {
        Swal.fire({
          icon: "warning",
          title: "Incomplete",
          text: "required fields missing.",
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.msg,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "System error occurred.",
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});
/* ########## END PROJECT ########## */

/* ########## EMPLOYEE ########## */
// manage-employee ADD
$(document).on("submit", "#addEmployeeFrm", function (event) {
  event.preventDefault();

  var formData = {
    add_EmpFname: $("#add_EmpFname").val(),
    add_EmpMname: $("#add_EmpMname").val(),
    add_EmpLname: $("#add_EmpLname").val(),
    add_region: $("#add_hidden_id").val(),
    // 'add_EmpSfname': $('#add_EmpSfname').val()
  };

  console.log(formData); //DEBUG
  var isValid;
  if (formData["add_EmpFname"] === "" || formData["add_EmpLname"] === "") {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/add_EmployeeExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " added.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-employee";
        });
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
          text: "An error occurred while adding Employee. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-employee EDIT
$(document).on("submit", "#editEmployeeFrm", function (event) {
  event.preventDefault();

  var formData = {
    edit_EmpId: $("#edit_EmpId").val(),
    edit_EmpFname: $("#edit_EmpFname").val(),
    edit_EmpMname: $("#edit_EmpMname").val(),
    edit_EmpLname: $("#edit_EmpLname").val(),
    // edit_EmpSfname: $("#edit_EmpSfname").val(),
    edit_EmpStatus: $("#edit_EmpStatus").val(),
    edit_Region: $("#edit_hidden_id").val(),
  };

  //   console.log(formData); //DEBUG
  var isValid;
  if (
    formData["edit_EmpId"] === "" ||
    formData["edit_EmpFname"] === "" ||
    formData["edit_EmpLname"] === "" ||
    formData["edit_Status"] === ""
  ) {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/edit_EmployeeExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " updated.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-employee";
        });
      } else if (response.res == "exists") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "An error occurred while updating Project. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-employee DISABLE
$(document).on("submit", "#disableEmployeeFrm", function (event) {
  event.preventDefault();

  var formData = {
    disable_EmpId: $("#disable_EmpId").val(),
    disable_EmpName: $("#disable_EmpName").val(),
    disable_EmpStatus: $("#disable_EmpStatus").val(),
  };

  var isValid;
  if (
    formData["disable_EmpId"] === "" ||
    formData["disable_EmpName"] === "" ||
    formData["disable_EmpStatus"] === ""
  ) {
    isValid = false;
  } else {
    isValid = true;
  }

  if (!isValid) {
    Swal.fire({
      icon: "warning",
      title: "Incomplete",
      text: "required field missing.",
    });
    return;
  }

  //console.log("INPUT VALIDATED"); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/status_EmployeeDisableExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " disabled.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-employee";
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "incomplete") {
        Swal.fire({
          icon: "warning",
          title: "Incomplete",
          text: "required fields missing.",
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.msg,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "System error occurred.",
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-employee ENABLE
$(document).on("submit", "#enableEmployeeFrm", function (event) {
  event.preventDefault();

  var formData = {
    enable_EmpId: $("#enable_EmpId").val(),
    enable_EmpName: $("#enable_EmpName").val(),
    enable_EmpStatus: $("#enable_EmpStatus").val(),
  };

  var isValid;
  if (
    formData["enable_EmpId"] === "" ||
    formData["enable_EmpName"] === "" ||
    formData["enable_EmpStatus"] === ""
  ) {
    isValid = false;
  } else {
    isValid = true;
  }

  if (!isValid) {
    Swal.fire({
      icon: "warning",
      title: "Incomplete",
      text: "required field missing.",
    });
    return;
  }

  //console.log("INPUT VALIDATED"); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/status_EmployeeEnableExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " enabled.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-employee";
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg,
        });
      } else if (response.res == "incomplete") {
        Swal.fire({
          icon: "warning",
          title: "Incomplete",
          text: "required fields missing.",
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.msg,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "System error occurred.",
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});
/* ########## END EMPLPOYEE ########## */

/* ########## BILLING ########## */
// manage-billing ADD
$(document).on("submit", "#addBillingFrm", function (event) {
  event.preventDefault();

  var formData = {
    add_BillCategory: $("#add_BillCategory").val(),
    add_BillProject: $("#add_BillProject").val(),
    add_BillEmployee: $("#add_BillEmployee").val(),
    add_BillPeriodFrom: formatDate($("#add_BillPeriodFrom").val()),
    add_BillPeriodTo: formatDate($("#add_BillPeriodTo").val()),
    add_BillAmount: $("#add_BillAmount").val().replace(/,/g, ""),
    add_BillDateReceived: formatDate($("#add_BillDateReceived").val()),
    add_BillTotalBilled: $("#add_BillTotalBilled").val().replace(/,/g, ""),
    add_BillAmountCollect: $("#add_BillAmountCollect").val().replace(/,/g, ""),
    add_BillDateDue: formatDate($("#add_BillDateDue").val()),
    add_BillDateCollect: formatDate($("#add_BillDateCollect").val()),
    add_BillRemarks: formatDate($("#add_BillRemarks").val()),
    //'add_BillPartial': $('#add_BillPartial').val().replace(/,/g, ""),
    //'add_BillPartialCollect': $('#add_BillPartialCollect').val().replace(/,/g, ""),
  };

  //console.log(formData); //DEBUG

  var isValid;
  if (
    formData["add_BillCategory"] === "" ||
    formData["add_BillProject"] === "" ||
    formData["add_BillPeriodFrom"] === "" ||
    formData["add_BillPeriodTo"] === "" ||
    formData["add_BillAmount"] === ""
  ) {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/add_BillingExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Bill added.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-billing";
        });
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
          text: "An error occurred while adding Billing. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-billing EDIT
$(document).on("submit", "#editBillingFrm", function (event) {
  event.preventDefault();

  var formData = {
    edit_BillId: $("#edit_BillId").val(),
    edit_BillCategory: $("#edit_BillCategory").val(),
    edit_BillProject: $("#edit_BillProject").val(),
    edit_BillEmployee: $("#edit_BillEmployee").val(),
    edit_BillPeriodFrom: formatDate($("#edit_BillPeriodFrom").val()),
    edit_BillPeriodTo: formatDate($("#edit_BillPeriodTo").val()),
    edit_BillAmount: $("#edit_BillAmount").val().replace(/,/g, ""),
    edit_BillDateReceived: formatDate($("#edit_BillDateReceived").val()),
    edit_BillTotalBilled: $("#edit_BillTotalBilled").val().replace(/,/g, ""),
    //'edit_BillPartial': $('#edit_BillPartial').val().replace(/,/g, ""),
    //'edit_BillPartialCollect': $('#edit_BillPartialCollect').val().replace(/,/g, ""),
    edit_BillDateDue: formatDate($("#edit_BillDateDue").val()),
    edit_BillDateCollect: formatDate($("#edit_BillDateCollect").val()),
    edit_BillAmountCollect: $("#edit_BillAmountCollect")
      .val()
      .replace(/,/g, ""),
    edit_BillRemarks: $("#edit_BillRemarks").val(),
  };

  //console.log(formData); //DEBUG

  var isValid;
  if (
    formData["edit_BillId"] === "" ||
    formData["edit_BillCategory"] === "" ||
    formData["edit_BillProject"] === "" ||
    formData["edit_BillPeriod"] === "" ||
    formData["edit_BillAmount"] === ""
  ) {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/edit_BillingExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Bill updated.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-billing";
        });
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
          text: "An error occurred while editing Billing. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-admin DELETE
$(document).on("submit", "#deleteBillingFrm", function (event) {
  event.preventDefault();

  var formData = {
    delete_BillingId: $("#delete_BillingId").val(),
  };

  //console.log(formData); //DEBUG

  var isValid;
  if (formData["delete_BillingId"] === "") {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/delete_BillingExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "User deleted.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-billing";
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "User does not exist.",
        }).then(function () {
          window.location.href = "home.php?page=manage-billing";
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "An error occurred while updating User. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});
/* ########## END BILLING ########## */

/* ########## ADMIN ########## */
// manage-admin ADD

$(document).on("submit", "#addUserFrm", function (event) {
  event.preventDefault();
  var formData = {
    add_UserFname: $("#add_UserFname").val(),
    add_UserLname: $("#add_UserLname").val(),
    add_UserPosition: $("#add_UserPosition").val(),
    add_UserSuper: $("#add_UserSuper").val(),
    add_UserRole: $("#add_UserRole").val(),
    add_UserName: $("#add_UserName").val(),
    add_UserPass: $("#add_UserPass").val(),
  };
  // console.log(formData); //DEBUG
  var isValid;
  if (
    formData["add_UserFname"] === "" ||
    formData["add_UserLname"] === "" ||
    formData["add_UserName"] === "" ||
    formData["add_UserPass"] === ""
  ) {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  $.ajax({
    url: "query/add_UserExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " added.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-admin";
        });
        console.log(formData);
      } else if (response.res == "exists") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg + " already exists.",
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "An error occurred while adding User. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-admin EDIT
$(document).on("submit", "#editUserFrm", function (event) {
  event.preventDefault();

  var formData = {
    edit_UserId: $("#edit_UserId").val(),
    edit_UserFname: $("#edit_UserFname").val(),
    edit_UserLname: $("#edit_UserLname").val(),
    edit_UserPosition: $("#edit_UserPosition").val(),
    edit_UserSuper: $("#edit_UserSuper").val(),
    edit_UserName: $("#edit_UserName").val(),
    edit_UserPass: $("#edit_UserPass").val(),
    edit_UserStatus: $("#edit_UserStatus").val(),
  };

  //console.log(formData); //DEBUG

  var isValid;
  if (
    formData["edit_UserId"] === "" ||
    formData["edit_UserFname"] === "" ||
    formData["edit_UserLname"] === "" ||
    formData["edit_UserName"] === "" ||
    formData["edit_UserPass"] === "" ||
    formData["edit_UserStatus"] === ""
  ) {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/edit_UserExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.msg + " updated.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-admin";
        });
      } else if (response.res == "exists") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: response.msg + " already exists.",
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "An error occurred while updating User. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});

// manage-admin DELETE
$(document).on("submit", "#deleteUserFrm", function (event) {
  event.preventDefault();

  var formData = {
    delete_UserId: $("#delete_UserId").val(),
  };

  //console.log(formData); //DEBUG

  var isValid;
  if (formData["delete_UserId"] === "") {
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

  //console.log("INPUT VALIDATED " + isValid); //DEBUG
  //console.log(formData); //DEBUG

  $.ajax({
    url: "query/delete_UserExe.php",
    type: "POST",
    dataType: "json",
    data: formData,
    beforeSend: function () {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (response) {
      swalLoad.close();
      if (response.res == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "User deleted.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-admin";
        });
      } else if (response.res == "norecord") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "User does not exist.",
        }).then(function () {
          window.location.href = "home.php?page=manage-admin";
        });
      } else if (response.res == "failed") {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "An error occurred while updating User. Please try again.",
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
    error: function (jqXHR, textStatus, errorThrown) {
      swalLoad.close();
      alert("A script error occured. Please try again.");
      console.error(textStatus, errorThrown);
      console.log(jqXHR.responseText);
      location.reload();
    },
  });
});
/* ########## END ADMIN ########## */

// 9/24/25 Import Excel file


$(document).on("submit", "#importfileFrm", (e) => {
  e.preventDefault();
  const sheetName = $("#sheetName").val()
  const file = $("#importFile")[0].files[0]

  if (!sheetName, !file) {
    return;
  }

  //Read the Excel  file and Extract the data

  const reader = new FileReader();
  reader.onload = (e) => {
    const data = new Uint8Array(e.target.result);
    const workbook = XLSX.read(data, { type: 'array' });
    const sheet = workbook.Sheets[sheetName];
    const jsonData = XLSX.utils.sheet_to_json(sheet);
    // console.log(jsonData);

    Test(jsonData);
  };
  reader.readAsArrayBuffer(file);
})




//Test  

// const uniqueArr = arr.filter((item, index, self) => {
//   return self.findIndex((t) => t.id === item.id) === index;
// });


// __EMPTY:CATEGORY, __EMPTY_1:NUMBER ID, __EMPTY_2:NAME,  __EMPTY_3:POSITION, __EMPTY_4:ASSIGNMENt, __EMPTY_5:REGION, __EMPTY_6:RATE

const Test = (emp) => {
  let newEmp = [];
  for (let i = 0; i < Object.keys(emp).length; i++) {
    if (Object.keys(emp[i]).length >= 8 && emp[i].__EMPTY_2 != "Employee Name") {
      if (emp[i].__EMPTY_2 && emp[i].__EMPTY_2 != "Employee Name") {
        const empName = _splitName(emp[i]?.__EMPTY_2, emp[i].__rowNum__);
        if (empName) {
          if (empName.Error) {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: `${empName.Error}. Please fix the issue before proceeding`,
            });
            break;
          }
        }
        newEmp.push({ emp_Id: emp[i]['__EMPTY_1'], ..._splitName(emp[i]?.__EMPTY_2, emp[i].__rowNum__), position: emp[i]['__EMPTY_3'], assignment: emp[i]['__EMPTY_4'], region: emp[i]['__EMPTY_5'], rate: emp[i]['__EMPTY_6'], row: emp[i].__rowNum__ + 1 })
      }
    }
  }
  const filteredEmp = newEmp.filter((item, index, self) => {
    return self.findIndex((t) => t.emp_Id === item.emp_Id) === index;
  });
  // console.log(filteredEmp);
  _addEmployee(filteredEmp)
}


const _splitName = (fullName, row) => {
  if (!fullName) {
    console.log("Name is missing");
    return { Error: "Name is missing" };
  }

  let name = fullName.split(', ');
  if (name.length < 2) {
    return { Error: `Invalid name format->${fullName} at row->${row + 1}. It should be (LASTNAME, FIRSTNAME MIDDLENAME)` };
  }
  let lastName = name[0];
  let otherNames = name[1].split(' ');
  let firstName, middleName;

  if (otherNames.length > 1) {
    middleName = otherNames.pop();
    firstName = otherNames.join(' ');
  } else {
    firstName = otherNames[0];
    middleName = '';
  }

  return {
    firstName: firstName.toUpperCase(),
    middleName: middleName.toUpperCase(),
    lastName: lastName.toUpperCase()
  };
}


// End Test


// Ajax Request (Insert Employees in DB from Excel) 
const _addEmployee = (emp, row) => {
  $.ajax({
    url: "query/add_ImportEmployeeExe.php",
    type: "POST",
    dataType: "json",
    data: {
      "Employees": JSON.stringify(emp),
      "StartingRow": row
    },
    beforeSend: () => {
      swalLoad = Swal.fire({
        title: "Loading...",
        html: "Please wait while your query is being processed.",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: (response) => {
      if (response.res == "success") {
        swalLoad.close();
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Data has been imported.",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).then(function () {
          window.location.href = "home.php?page=manage-employee";
        });
      }
    },
    error: (jqXHR, textStatus, errorThrown) => {
      console.log(errorThrown);
      console.log(textStatus);
      console.log(jqXHR);

    }
  })
}
// 9/24/25 END (Import Excel file)
