/**
 * Save locations
 * from: business.blade.php
 */

function savelocations() {

    //Business name
    var bus_name = $("#bus_name").val();
    //address 1
    var addr1 = $("#addr1").val();
    //address 2
    var addr2 = $("#addr2").val();
    //city
    var city = $("#city").val();
    //state
    var state = $("#state").val();
    //postal
    var postal = $("#postal").val();
    //Days & Hours
    var dayshoursArray = {};
    $.each(idtracker, function (key, i) {
        var days = $('#day_' + i).val();
        var hoursfrom = $('#hours_from_' + i).val();
        var hoursto = $('#hours_to_' + i).val();

        dayshoursArray['day_' + i] = days;
        dayshoursArray['hours_from_' + i] = hoursfrom;
        dayshoursArray['hours_to_' + i] = hoursto;
    });
    //use the global var numRows to get the count of business hours.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content') //Gets the CSRF code from the meta content in the header
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/locations/store',
        method: "post",
        // cache: false,
        // processData: false,
        // contentType: false,
        data: {
            location_name: bus_name,
            addr1: addr1,
            addr2: addr2,
            city: city,
            postal: postal,
            state: state,
            days: dayshoursArray,
            rowcount: idtracker
        },
        success: function (data) {
            //Handle Success Messages on toast
            if (typeof data != 'undefined') {
                var uid = data.locationid;
                var do_redirect = false;

                HandleErrorsToast(2300, "green", uid, data.response.success, 200, do_redirect);
            }
            //Change the view once message received
            setTimeout(function () {
                $('#locations_div').html(data.view);
            }, 400);
            idtracker = []; //DO NOT REMOVE THIS -> IT resets the array 
            $("form").trigger("reset");

        }, //end of success
        error: function (error) {
            //Handle Error Messages on toast
            if (typeof error.responseJSON != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                //419 status code is for mismatched CSRF code if code is 419 we need to logout or refresh page
                if (error.status === 419) {
                    do_redirect = true;
                }
                //these are for server side or exception errors
                HandleErrorsToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);
                //These are internal error messages
                $.each(error.responseJSON.errors, function (index, val) {
                    var uid = index;
                    var do_redirect = false;
                    HandleErrorsToast(2300, "red", uid, val, error.status, do_redirect);
                });
            }
        } //end of error
    }); //end of ajax
} //end of savelocations


/**
 * EditLocation(id)
 * @param {*} id
 * !IMPORTANT NEEDS FIXING THE MODAL CLOSING ISSUE
 */

function EditLocation(id) {

    //Business name
    var bus_name = $("#bus_name_" + id).val();
    //address 1
    var addr1 = $("#addr1_" + id).val();
    //address 2
    var addr2 = $("#addr2_" + id).val();
    //city
    var city = $("#city_" + id).val();
    //state
    var state = $("#state_" + id).val();
    //postal
    var postal = $("#postal_" + id).val();

    //Contacts Section//
    var phone = $("#phone_" + id).val();
    var email = $("#email_" + id).val();
    var fax = $("#fax_" + id).val();
    var maps_url = $("#maps_" + id).val();
    //Days & Hours
    var daysHours = $("#edit_hours_table_" + id + " select").serialize();

    //Send data
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/locations/update',
        method: "post",
        cache: false,
        data: {
            id: id,
            location_name: bus_name,
            addr1: addr1,
            addr2: addr2,
            city: city,
            postal: postal,
            state: state,
            phone: phone,
            email: email,
            fax: fax,
            maps_url: maps_url,
            daysHours: daysHours //serialized

        },
        beforeSend: function () {
            $("#location_editor_" + id).text("Saving ");
            $("#location_editor_" + id).attr("class", "btn btn-success");
            $("#loader_" + id).clone().appendTo("#location_editor_" + id).show();
        },
        success: function (data) {
            //Handle Success Messages on toast
            if (typeof data != 'undefined') {
                var uid = id;
                var do_redirect = false;
                HandleErrorsToast(2300, "green", uid, data.response.success, 200, do_redirect);
                setTimeout(function () {
                    $('#locationeditmodal_' + id).modal('hide');
                    $("#location_editor_" + id).text("Update");
                    $("#location_editor_" + id).attr("class", "btn btn-primary");

                    $("#loader_" + id).hide();
                }, 1000);
                setTimeout(function () {

                    $('#locations_div').html(data.view);

                }, 1300);
            }
        }, //end of success
        error: function (error) {
            if (typeof error.responseJSON != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                if (error.status === 419) {
                    do_redirect = true;
                }
                HandleErrorsToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);
                $.each(error.responseJSON.errors, function (index, val) {
                    HandleErrorsToast(2300, "red", index, val, error.status, do_redirect);
                    setTimeout(function () {
                        $("#location_editor_" + id).attr("class", "btn btn-primary");
                        $("#location_editor_" + id).text("Update");
                    }, 900);
                    $("#location_editor_" + id).attr("class", "btn btn-danger");

                    $("#location_editor_" + id).text("Unable to Update");

                });

            }
        }, //end of error

    }); //end of ajax
} //end of savelocations

//End Edit location

/**
 * Delete Location
 * Added on: 07/14/2021
 */
function DeleteLocation(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/locations/destroy',
        method: "post",
        //cache: false,
        data: {
            id: id
        },
        success: function (data) {
            if (typeof data != 'undefined') {
                HandleErrorsToast(2300, "green", id, data.response.success, 200);
                setTimeout(function () {
                    $('#locations_div').html(data.view);
                }, 400);
            }

        }, //end of success
        error: function (error) {
            if (typeof error.responseJSON.message != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                if (error.status === 419) {
                    do_redirect = true;
                }
                HandleErrorsToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);

                $.each(error.responseJSON.errors, function (index, val) {

                    HandleErrorsToast(2300, "red", index, val, error.status, do_redirect);
                });
            }

        } //end of error
    }); //end of ajax
} //end of savelocations


/**
 * These additions are made only with JQuery for the location modal.
 * Date: 07/17/2021
 * Author: Rostom Sahakian
 * This script should control the days and hours portion of the page
 * It should:
 * 1. Add new row (div) for user to add additional days and hours
 * 2. it should keep track of each row and auto ajax save the data into database
 **/

var counter = 0; //Global Counter DO NOT remove
var numRows = 0;
var idtracker = [];
//Add more rows
$(function () {
    $("#add_hours_btn").on("click", function () {
        var days_hours = $("#location_hours_div").clone();
        counter++;
        numRows++;
        days_hours.attr("id", "location_hours_div_" + counter);

        days_hours.find("#day").attr("id", "day_" + counter);
        days_hours.find("#hours_from").attr("id", "hours_from_" + counter);
        days_hours.find("#hours_to").attr("id", "hours_to_" + counter);
        days_hours.find("#clearday").attr("id", "clearday_" + counter);
        days_hours.find("#clearday_" + counter).attr("onclick", "ClearDayRow(" + counter + ")"); //Change counter value on function

        idtracker.push(counter);
        $("#additional").each(function () {
            $("#additional").append(days_hours);
        });
        days_hours.slideDown('slow'); //Call the slide down after the div has been appended! 07/19/2021
        //If counter is equal to 7 (that will give me max of 7 rows for days of the week)
        if (numRows == 7) {
            $("#add_hours_btn").addClass("disabled");
        }
    }); //End of add_hour_btn


});
/**
 * Removes the Day Row from the modal
 * Date: 07/17/2021
 * Author: Rostom Sahakian
 * @param {*} id
 */
function ClearDayRow(id) {
    //Remove that clicked row
    $("#location_hours_div_" + id).slideUp('slow');
    setTimeout(function () {
        $("#location_hours_div_" + id).remove();

    }, 600);

    idtracker = jQuery.grep(idtracker, function (value) {
        return value != id;
    });
    if (numRows < 8) { //If a row is removed then enable the button
        $("#add_hours_btn").removeClass("disabled");
    }
    numRows--;//Decriment by one everytime a row is removed.

}

function addHourstoEdit(loc_id, count) {
    //When the add edit hours button is clicked:
    //1. call to ajax 
    //2. add a row to the table.
    //3. get the id of that row and send it back to the view. 

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/locations/edit/addstorehoursrows',
        method: "post",
        //cache: false,
        data: {
            loc_id: loc_id,
            count: count

        },
        success: function (data) {

            if (typeof data != 'undefined') {
                HandleErrorsToast(2300, "green", loc_id, data.response.success, 200);
                $('#modal_body_for_days_' + data.location_id.id).replaceWith(data.view).slideUp('slow');
            }
        }, //end of success
        error: function (error) {
            if (typeof error.responseJSON.message != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                if (error.status === 419) {
                    do_redirect = true;
                }
                HandleErrorsToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);

                $.each(error.responseJSON.errors, function (index, val) {

                    HandleErrorsToast(2300, "red", index, val, error.status, do_redirect);

                });
            }

        } //end of error
    }); //end of ajax
}

/**
 * Delete the day hours row from edit store information modal
 * @param {*} id
 */

function deleteHoursRow(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/location_hours/destroy',
        method: "post",
        //cache: false,
        data: {
            id: id
        },
        success: function (data) {
            if (typeof data != 'undefined') {
                HandleErrorsToast(2300, "green", id, data.response.success, 200);
                $('#modal_body_for_days_' + data.location_id.id).replaceWith(data.view);
            }
        }, //end of success
        error: function (error) {
            if (typeof error.responseJSON.message != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                if (error.status === 419) {
                    do_redirect = true;
                }
                HandleErrorsToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);

                $.each(error.responseJSON.errors, function (index, val) {
                    HandleErrorsToast(2300, "red", index, val, error.status, do_redirect);

                });
            }

        } //end of error
    }); //end of ajax
} //end of savelocations


/**
 * 
 * @param {*} loc_id 
 * @param {*} contact_count 
 */

function addContactstoEdit(loc_id, contact_count) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/locations/contacts/add',
        method: "post",
        //cache: false,
        data: {
            id: loc_id,


        },
        success: function (data) {
            if(typeof data != 'undefined'){
                HandleErrorsToast(2300, "green", loc_id, data.response.success, 200);
                $('#locations_contacts_div_' + data.location_id.id).replaceWith(data.view);
            }
        }, //end of success
        error: function (error) {
            if (typeof error.responseJSON.message != 'undefined') {
                var uid = getRandomInt(5000);
                var do_redirect = false;
                if (error.status === 419) {
                    do_redirect = true;
                }
                HandleErrorsToast(2300, "red", uid, error.responseJSON.message, error.status, do_redirect);

                $.each(error.responseJSON.errors, function (index, val) {

                    HandleErrorsToast(2300, "red", index, val, error.status, do_redirect);
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
function HandleErrorsToast(delay_time, div_color, uid, message, status_code, CSR_ER = false) {


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