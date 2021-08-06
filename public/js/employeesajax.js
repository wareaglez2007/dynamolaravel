//Employee management scripts
/**
 * 
 * @param {*} step 
 * @param {*} progress 
 */
function AddEmployeeNextSteps(step, progress) {

    var form_data = $("#add_employee_form").serialize();

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
        //cache: false,
        data: form_data,
        success: function (data) {
            if (typeof data != 'undefined') {
                //JQUERY CONTROLS BELOW
                HandleNextMove(step, progress);
                HandleAjaxResponsesToast(2300, "green", step, data.response.success, 200);


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
    //2. Validate the data
    //3. repeat next step

}
/**
 * 
 * @param {*} step 
 * @param {*} progress 
 */
function AddEmployeePrevSteps(step, progress) {
    var form_data = $("#add_employee_form").serialize();

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
        //cache: false,
        data: form_data,
        success: function (data) {
            //JQUERY CONTROL THIS
            HandlePrevMove(step, progress);
            // HandleAjaxResponsesToast(2300, "green", step, data.response.success, 200);
            //add_employee_step_1
            //Steps


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
function HandleAjaxResponsesToast(delay_time, div_color, uid, message, status_code, CSR_ER = false) {


    var delay = delay_time;
    color = div_color;
    var toast =
        '<div id="location_toast_' + uid +
        '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
        delay + '" >' +
        '<div class="toast-header" style="background-color: ' +
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
    if (step < 5) {
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
                modal_title = "Employee Work History";
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

        setTimeout(function () {
            if (step == 4) {
               // $("#new_employee_progress_bar").attr("class", "progress-bar bg-success");
                $("#go_forward").attr('class', 'btn btn-success');
                $("#go_forward").html('Finish <i class="bi bi-arrow-right-square"style="vertical-align: text-bottom !important;"></i>');
            }
        }, 600);

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
                modal_title = "Employee Work History";
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