//Employee management scripts

function AddEmployeeNextSteps(step) {
    var gender = $("#gender").val();
    //When the next button is clicked:
    //1. call the controller through ajax
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
        data: {
            steps: step,
            gender: gender
        },
        success: function (data) {
            if (typeof data != 'undefined') {
                console.log(data.current_step);
                console.log(data.forward_step);
                console.log(data.backward_step);
                //   $("#gender").val(data.request.gender)
                HandleAjaxResponsesToast(2300, "green", step, data.response.success, 200);
                //add_employee_step_1
                //Steps
                if (step != data.forward_step) {
                    $("#add_employee_mt").text(data.modal_title);
                    $("#new_employee_progress_bar").attr("style", "width:" + data.progress + "%");
                    //aria-valuenow="25"
                    $("#new_employee_progress_bar").attr("aria-valuenow", data.progress);
                    $("#go_back").show();
                    $("#go_back").attr('onclick', 'AddEmployeePrevSteps(' + data.backward_step + ')');
                    if (data.current_step == 4) {
                        $("#go_forward").attr('class', "btn btn-success");
                        $("#go_forward").attr('onclick', 'AddEmployeeNextSteps(' + data.forward_step + ')');
                        $("#go_forward").text('Finish');

                    }
                    $("#go_forward").attr('onclick', 'AddEmployeeNextSteps(' + data.forward_step + ')');

                    $('#add_employee_step_' + data.backward_step).remove();


                    $('#add_new_employee_modal_body').append(data.view);
                    $("#add_employee_step_" + data.current_step).show("slide", { direction: "right" }, 400);
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
    //2. Validate the data
    //3. repeat next step

}

function AddEmployeePrevSteps(step) {
    //When the next button is clicked:
    //1. call the controller through ajax
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
        data: {
            steps: step
        },
        success: function (data) {
            if (typeof data != 'undefined') {
                // HandleAjaxResponsesToast(2300, "green", step, data.response.success, 200);
                //add_employee_step_1
                //Steps
                if (step != data.forward_step) {
                    $("#add_employee_mt").text(data.modal_title);
                    $("#new_employee_progress_bar").attr("style", "width:" + data.progress + "%");
                    //aria-valuenow="25"
                    $("#new_employee_progress_bar").attr("aria-valuenow", data.progress);
                    if (data.current_step == 1) {
                        $("#go_back").hide();
                    }

                    if (data.current_step != 4) {
                        $("#go_forward").attr('class', "btn btn-primary");

                        $("#go_forward").html('Next Step <i class="bi bi-arrow-right-square"style="vertical-align: text-bottom !important;"></i>');

                    }

                    $("#go_back").attr('onclick', 'AddEmployeePrevSteps(' + data.backward_step + ')');
                    $("#go_forward").attr('onclick', 'AddEmployeeNextSteps(' + data.forward_step + ')');

                    $('#add_employee_step_' + data.forward_step).remove();
                    $('#add_new_employee_modal_body').append(data.view);
                    $("#add_employee_step_" + data.current_step).show("slide", { direction: "left" }, 400);
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
