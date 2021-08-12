//Employee management scripts
/**
 * 
 * @param {*} step 
 * @param {*} progress 
 */
function AddEmployeeNextSteps(step, progress) {
    var form_data = $("#add_employee_form").serialize();
    AjaxFormValidation(step, progress, form_data);

}
/**
 * 
 * @param {*} step 
 * @param {*} progress 
 */
function AjaxFormValidation(step, progress, form_data) {
    var success_code = 0;
    //2. Validate the data
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/employees/validate',
        method: "post",
        cache: false,
        data: form_data,
        success: function (data) {
            if (typeof data != 'undefined') {
                $('#step_tracker').val(step);
                //JQUERY CONTROLS BELOW
                if (typeof data.response.success != 'undefined') {
                    var response_message = data.response.success;
                    HandleNextMove(step, progress);
                    if (typeof data.response.success.code != 'undefined') {
                        if (data.response.success.code == 200) {
                            //Call the form submission function here <<--------------Step 1 pre submission
                            HandleAjaxFormSubmission(step, form_data);
                            //Then we will need to reset the form & close it. <<------Step 2 post submission
                            setTimeout(function () {
                                ResetFormView(step);
                            }, 1800);
                            response_message = "Data has been succesfully added to the database.";
                        }
                    }
                    HandleAjaxResponsesToast(2300, "green", step, response_message, 200);

                }
                if (typeof data.response.warning != 'undefined') {
                    HandleAjaxResponsesToast(3000, "#ffc107", step, data.response.warning, 200, false, 'bg-warning');
                }


            }
        }, //end of success
        error: function (error) {
            if (typeof error.responseJSON.message != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                if (error.status === 419) {
                    do_redirect = true;
                }
                HandleAjaxResponsesToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);

                $.each(error.responseJSON.errors, function (index, val) {
                    HandleAjaxResponsesToast(2300, "red", index, val, error.status, do_redirect);

                });
            }

        } //end of error
    }); //end of ajax
    return success_code;
}
/**
 * Handle Form Submission
 * @param {*} step 
 * @param {*} form_data 
 */
function HandleAjaxFormSubmission(step, form_data) {
    //Submit form
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/employees/add',
        method: "post",
        cache: false,
        data: form_data,
        success: function (data) {
            if (typeof data != 'undefined') {
                //JQUERY CONTROLS BELOW
                if (typeof data.response.success != 'undefined') {
                    setTimeout(() => {
                        $("#show_employees").html(data.view); //Updates the background fields.
                        $('#form_sub_message').text('Submitting...');
                        $("#go_forward").attr('class', 'btn btn-success disabled');
                    }, 20);
                    setTimeout(() => {
                        $('#form_sub_message').html('Done! <i class="bi bi-card-checklist text-success"></i>'); 
                    }, 750);
                    setTimeout(() => {
                        
                    }, 800);
                    HandleAjaxResponsesToast(2300, "green", step, data.response.success, 200);

                }
                if (typeof data.response.warning != 'undefined') {
                    HandleAjaxResponsesToast(3000, "#ffc107", step, data.response.warning, 200, false, 'bg-warning');
                }


            }
        }, //end of success
        error: function (error) {
            if (typeof error.responseJSON.message != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                if (error.status === 419) {
                    do_redirect = true;
                }
                HandleAjaxResponsesToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);

                $.each(error.responseJSON.errors, function (index, val) {
                    HandleAjaxResponsesToast(2300, "red", index, val, error.status, do_redirect);

                });
            }

        } //end of error
    }); //end of ajax
}
/**
 * //to reset the form
 * @param {*} step 
 */
function ResetFormView(step) {
    //1. reset values
    $('#step_tracker').val(1); //IMPORTANT this will dictate the form direction at reset
    $("#add_employee_form")[0].reset();
    //2. reset veiw
    //Hide all steps but the 1st step.
    for (var i = 2; i < 6; i++) {
        $('#add_employee_step_' + i).hide();
    }
    $('#add_employee_step_1').show();
    //3. reset the progress bar
    $("#add_employee_mt").text("Employee Basic Information");
    $("#new_employee_progress_bar").attr("style", "width:0%");
    $("#new_employee_progress_bar").attr("aria-valuenow", 0);
    $("#new_employee_progress_bar").attr("class", "progress-bar bg-primary");
    //4. reset the buttons
    $("#go_forward").attr('class', 'btn btn-primary');
    $("#go_forward").html('Next Step <i class="bi bi-arrow-right-square"style="vertical-align: text-bottom !important;"></i>');
    $("#go_back").hide();
    //5. reset the functions on buttons
    $("#go_back").attr('onclick', 'AddEmployeePrevSteps(1,0)');
    $("#go_forward").attr('onclick', 'AddEmployeeNextSteps(2,25)');
    $('#form_sub_message').text('Ready to submit?');

    $("#modelId").modal('hide');
}


/**
 * 
 * @param {*} step 
 * @param {*} progress 
 */
function AddEmployeePrevSteps(step, progress) {
    $('#step_tracker').val(step);
    //JQUERY CONTROL THIS
    HandlePrevMove(step, progress);
}

/**
 * Get a random number max is the number your choose the range for
 * @param {*} max 
 * @returns 
 */
function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}
/**
 * Reusable Toast
 * @param {*} delay_time 
 * @param {*} div_color 
 * @param {*} uid 
 * @param {*} message 
 * @param {*} status_code 
 * @param {*} CSR_ER (defalut false)
 * @returns 
 */
function HandleAjaxResponsesToast(delay_time, div_color, uid, message, status_code, CSR_ER = false, tclass = null) {


    var delay = delay_time;
    color = div_color;
    var toast_class = tclass;
    var toast =
        '<div id="location_toast_' + uid +
        '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
        delay + '" >' +
        '<div class="toast-header  ' + toast_class + '" style="background-color: ' +
        color +
        ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
        '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
        '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
        '<div class="toast-body" id="toast_id_body' +
        uid + '">' + message +
        '</div> </div> </div>';
    //Informational responses (100–199)
    // Successful responses (200–299)
    // Redirects (300–399)
    // Client errors (400–499)
    // Server errors (500–599)
    //If the CSRF is mismatched use this script

    if (status_code > 99 && status_code < 600) {
        //logout url
        $("#bottom_toast").append(toast);
        $('#location_toast_' + uid).toast("show");
        setTimeout(function () {
            $('#location_toast_' + uid)
                .remove();

        }, delay + 600);

        if (CSR_ER) {
            setTimeout(function () {
                window.location.href = '/logout';
                window.location.href = '/login';
            }, delay + 700);

        }

    }

    return toast;
}
/**
 * 
 * @param {*} step 
 * @param {*} progress 
 */
function HandleNextMove(step, progress) {
    if (step < 6) {
        var next_step = step + 1;
        var prev_step = step - 1;
        var modal_title = "";

        if (next_step > 1) {
            $("#go_back").show();
        }
        //Pregress bar and section title
        switch (step) {
            case 1:
                modal_title = "Employee Basic Information";
                break;
            case 2:
                modal_title = "Employee Address Information";
                break;
            case 3:
                modal_title = "Employee Contacts Information";
                break;
            case 4:
                modal_title = "Employee Work History (Optional)";
                break;
            case 5:
                modal_title = "Submit Employee Data";
                break;
            default:
                modal_title = "Employee Basic Information";
                break;
        }
        $('#add_employee_step_' + prev_step).hide("slide", { direction: "left" }, 200);

        setTimeout(function () {
            $("#add_employee_mt").text(modal_title);
            $("#new_employee_progress_bar").attr("style", "width:" + progress + "%");
            $("#new_employee_progress_bar").attr("aria-valuenow", progress);


            $("#go_back").attr('onclick', 'AddEmployeePrevSteps(' + prev_step + ',' + (progress - 25) + ')');
            $("#go_forward").attr('onclick', 'AddEmployeeNextSteps(' + next_step + ', ' + (progress + 25) + ')');
            $('#add_employee_step_' + step).show("slide", { direction: "right" }, 300);
        }, 200);

        //Last step is for submission 
        if (step == 5) {
            $("#new_employee_progress_bar").attr("class", "progress-bar bg-success");
            $("#go_forward").attr('class', 'btn btn-success');
            $("#go_forward").html('Finish <i class="bi bi-arrow-right-square"style="vertical-align: text-bottom !important;"></i>');
        }


    }
}
/**
 * 
 * @param {*} step 
 * @param {*} progress 
 */
function HandlePrevMove(step, progress) {
    if (step > 0) {
        var next_step = step + 1;
        var prev_step = step - 1;
        var modal_title = "";

        if (step < 2) {
            $("#go_back").hide();
        }
        //Pregress bar and section title
        switch (step) {
            case 1:
                modal_title = "Employee Basic Information";
                break;
            case 2:
                modal_title = "Employee Address Information";
                break;
            case 3:
                modal_title = "Employee Contacts Information";
                break;
            case 4:
                modal_title = "Employee Work History (Optional)";
                break;
            case 5:
                modal_title = "Submit Employee Data";
                break;
            default:
                modal_title = "Employee Basic Information";
                break;
        }
        $("#go_forward").attr('class', 'btn btn-primary');
        $("#go_forward").html('Next Step <i class="bi bi-arrow-right-square"style="vertical-align: text-bottom !important;"></i>');
        $('#add_employee_step_' + next_step).hide("slide", { direction: "right" }, 200);

        setTimeout(function () {
            $("#add_employee_mt").text(modal_title);
            $("#new_employee_progress_bar").attr("style", "width:" + progress + "%");
            $("#new_employee_progress_bar").attr("aria-valuenow", progress);

            $("#new_employee_progress_bar").attr("class", "progress-bar bg-primary");


            $("#go_back").attr('onclick', 'AddEmployeePrevSteps(' + prev_step + ',' + (progress - 25) + ')');
            $("#go_forward").attr('onclick', 'AddEmployeeNextSteps(' + next_step + ', ' + (progress + 25) + ')');
            $('#add_employee_step_' + step).show("slide", { direction: "left" }, 300);
        }, 200);

    }
}