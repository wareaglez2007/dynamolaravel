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
                    'content')
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

            var delay = 2300;
            color = "green";
            var toast =

                '<div id="location_toast_' + data.locationid +
                '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                delay + '" >' +
                '<div class="toast-header" style="background-color: ' +
                color +
                ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                '<div class="toast-body" id="toast_id_body' +
                data.locationid + '">' + data.response.success +
                '</div> </div> </div>';
            $("#bottom_toast").append(toast);
            $('#location_toast_' + data.locationid).toast("show");
            $('#attached_image_modal_' + data.locationid).modal('hide');

            setTimeout(function () {
                $('#location_toast_' + data.locationid)
                    .remove();

            }, delay + 600);
            setTimeout(function () {
                $('#locations_div').html(data.view);
            }, 400);
            idtracker = [];
            $("form").trigger("reset");

        }, //end of success
        error: function (error) {
            $.each(error.responseJSON.errors, function (index, val) {
                var delay = 2300;
                color = "red";
                var toast =
                    '<div id="location_toast_' + index +
                    '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                    delay + '" >' +
                    '<div class="toast-header" style="background-color: ' +
                    color +
                    ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                    '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                    '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                    '<div class="toast-body" id="toast_id_body' +
                    index + '">' + val +
                    '</div> </div> </div>';
                $("#bottom_toast").append(toast);
                $('#location_toast_' + index).toast("show");
                setTimeout(function () {
                    $('#location_toast_' + index)
                        .remove();

                }, delay + 600);

            });


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
    var phone = $("#phone_"+id).val();
    var email = $("#email_"+id).val();
    var fax = $("#fax_"+id).val();
    var maps_url = $("#maps_"+id).val();


    var old_dayshoursArray = {};
    if (typeof current_location_days !== 'undefined') {
        $.each(current_location_days, function (k, v) {
            var old_days = $("#do_edit_day_" + v).val();
            var old_hour_from = $("#do_edit_hours_from_" + v).val();
            var old_hour_to = $("#do_edit_hours_to_" + v).val();
            old_dayshoursArray['old_days_' + v] = old_days;
            old_dayshoursArray['old_hours_from_' + v] = old_hour_from;
            old_dayshoursArray['old_hours_to_' + v] = old_hour_to;
        });
    }

    var dayshoursArray = {};
    //console.log(edit_uids);



    $.each(edit_uids, function (key, i) {
        var days = $('#day_edit_for_' + id + "_" + i).val();
        var hoursfrom = $('#hours_from_edit_for_' + id + "_" + i).val();
        var hoursto = $('#hours_to_edit_for_' + id + "_" + i).val();
        //Set the array values
        dayshoursArray['day_edit_for_' + id + "_" + i] = days;
        dayshoursArray['hours_from_edit_for_' + id + "_" + i] = hoursfrom;
        dayshoursArray['hours_to_edit_for_' + id + "_" + i] = hoursto;
    });

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
        //cache: false,
        data: {
            id: id,
            location_name: bus_name,
            addr1: addr1,
            addr2: addr2,
            city: city,
            postal: postal,
            state: state,
            days: dayshoursArray,
            numrows: edit_uids,
            editing_days: current_location_days,
            editing_days_values: old_dayshoursArray,
            phone: phone,
            email: email,
            fax: fax,
            maps_url: maps_url

        },
        success: function (data) {
            var delay = 2300;
            color = "green";
            var toast =

                '<div id="location_delete_toast_' + id +
                '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                delay + '" >' +
                '<div class="toast-header" style="background-color: ' +
                color +
                ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                '<div class="toast-body" id="toast_id_body' +
                id + '">' + data.response.success +
                '</div> </div> </div>';
            $("#bottom_toast").append(toast);
            $('#location_delete_toast_' + id).toast("show");
            $('#locationeditmodal_' + id).modal('hide');

            edit_counter = 0; //Global Counter DO NOT remove
            edit_numRows = 0;
            edit_idtracker = [];
            edit_uids = [];
            current_location_days = [];
            current_locations = [];
            clickId = [];
            setTimeout(function () {
                $('#location_delete_toast_' + id)
                    .remove();

            }, delay + 600);

            setTimeout(function () {
                $('#locations_div').html(data.view);
            }, 400);

            //$('#modal_body_for_days_' + data.location_id.id).replaceWith(data.view);

        }, //end of success
        error: function (error) {
            $.each(error.responseJSON.errors, function (index, val) {
                var delay = 2300;
                color = "red";
                var toast =
                    '<div id="location_toast_' + index +
                    '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                    delay + '" >' +
                    '<div class="toast-header" style="background-color: ' +
                    color +
                    ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                    '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                    '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                    '<div class="toast-body" id="toast_id_body' +
                    index + '">' + val +
                    '</div> </div> </div>';
                $("#bottom_toast").append(toast);
                $('#location_toast_' + index).toast("show");
                setTimeout(function () {
                    $('#location_toast_' + index)
                        .remove();

                }, delay + 600);

            });


        } //end of error
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
            var delay = 2300;
            color = "green";
            var toast =

                '<div id="location_delete_toast_' + id +
                '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                delay + '" >' +
                '<div class="toast-header" style="background-color: ' +
                color +
                ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                '<div class="toast-body" id="toast_id_body' +
                id + '">' + data.response.success +
                '</div> </div> </div>';
            $("#bottom_toast").append(toast);
            $('#location_delete_toast_' + id).toast("show");
            $('#attached_image_modal_' + data.locationid).modal('hide');

            setTimeout(function () {
                $('#location_delete_toast_' + id)
                    .remove();

            }, delay + 600);
            setTimeout(function () {
                $('#locations_div').html(data.view);
            }, 400);

        }, //end of success
        error: function (error) {
            $.each(error.responseJSON.errors, function (index, val) {
                var delay = 2300;
                color = "red";
                var toast =
                    '<div id="location_toast_' + index +
                    '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                    delay + '" >' +
                    '<div class="toast-header" style="background-color: ' +
                    color +
                    ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                    '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                    '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                    '<div class="toast-body" id="toast_id_body' +
                    index + '">' + val +
                    '</div> </div> </div>';
                $("#bottom_toast").append(toast);
                $('#location_toast_' + index).toast("show");
                setTimeout(function () {
                    $('#location_toast_' + index)
                        .remove();

                }, delay + 600);

            });


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
/**
 * *************************
 * GLOBAL VARS
 * DO NOT REMOVE
 * *************************
 */
var edit_counter = 0;
var edit_numRows = 0;
var edit_idtracker = [];
var edit_uids = [];
/**
 ***************************
 * @param {*} id (location id)
 * @param {*} count (starts from 0 to 7)
 * finished on 07/23/2021
 */
function addHourstoEdit(id, count) {
    edit_numRows = count;
    edit_counter++;
    edit_numRows++;
    //Clone
    var days_hours = $("#location_hours_div").clone();
    //Change the cloned div's id names
    days_hours.attr("id", "location_hours_div_edit_for_" + id + "_" + edit_counter);
    days_hours.find("#day").attr("id", "day_edit_for_" + id + "_" + edit_counter);
    days_hours.find("#hours_from").attr("id", "hours_from_edit_for_" + id + "_" + edit_counter);
    days_hours.find("#hours_to").attr("id", "hours_to_edit_for_" + id + "_" + edit_counter);
    days_hours.find("#clearday").attr("id", "clearday_edit_for_" + id + "_" + edit_counter);
    days_hours.find("#clearday_edit_for_" + id + "_" + edit_counter).attr("onclick", "ClearEditDayRow(" + edit_counter + ", " + id + ")"); //Change counter value on function
    //Append to div
    $("#additional_edit_" + id).append(days_hours);
    days_hours.slideDown('slow');
    //pass the count value back to the original function thru html
    $("#add_hours_btn_edit_" + id).attr("onclick", "addHourstoEdit(" + id + ", " + edit_numRows + ")");
    //if count is 7 then disable the add hours button
    if (edit_numRows == 7) {
        $("#add_hours_btn_edit_" + id).addClass("disabled");
    }
    //push the id and value of incremented counts into array (key = id (location id), value = counter value)
    edit_idtracker.push({
        key: id,
        value: edit_counter
    });
    //console.log(edit_idtracker);
    //go through the array and check if the location id is the same as the key in array, then push them together.
    var obj = [];

    $.each(edit_idtracker, function (k, v) {
        if (edit_idtracker[k].key === id) {
            obj.push(edit_idtracker[k].value);
        }
    });
    //set the newly created array to the glodal array (accessable outside the function)
    edit_uids = obj;
}

/**
 * ************************************
 * Removes the Day Row from the modal
 * Date: 07/17/2021
 * Author: Rostom Sahakian
 * @param {*} id (unique id generated by edit_counter)
 * @param {*} loc_id (location id)
 * ************************************
 */
function ClearEditDayRow(id, loc_id) {
    //Remove that clicked row
    $("#location_hours_div_edit_for_" + loc_id + "_" + id).slideUp('slow');
    setTimeout(function () {
        $("#location_hours_div_edit_for_" + loc_id + "_" + id).remove();

    }, 600);
    edit_uids = jQuery.grep(edit_uids, function (value) {
        return value != id;
    });
    if (edit_numRows < 8) { //If a row is removed then enable the button
        $("#add_hours_btn_edit_" + loc_id).removeClass("disabled");

    }
    edit_numRows--;//Decriment by one everytime a row is removed.
    $("#add_hours_btn_edit_" + loc_id).attr("onclick", "addHourstoEdit(" + loc_id + ", " + edit_numRows + ")");
}
/**
 * Edit hours row in the location edit modal
 * @param {*} id
 */
var current_location_days = [];
var current_locations = [];
var clickId = [];

function editHoursRow(id, location_id) {
    //Toggle between disabled and enabled
    if ($("#do_edit_day_" + id).attr('disabled') == 'disabled' || $("#do_edit_hours_from_" + id).attr('disabled') == 'disabled' || $("#do_edit_hours_to_" + id).attr('disabled') == 'disabled') {

        $("#do_edit_day_" + id).attr('disabled', false);
        $("#do_edit_hours_from_" + id).attr('disabled', false);
        $("#do_edit_hours_to_" + id).attr('disabled', false);
    } else {
        $("#do_edit_day_" + id).attr('disabled', true);
        $("#do_edit_hours_from_" + id).attr('disabled', true);
        $("#do_edit_hours_to_" + id).attr('disabled', true);
    }
    obj = {};
    obj.location_id = location_id;
    obj.dayshoursid = id;
    current_locations.push(obj);

    $.each(current_locations, function (index, value) {

        //  console.log(current_location_days[index].dayshoursid);
        if (clickId.indexOf(value.dayshoursid) === -1) {
            clickId.push(value.dayshoursid);
        }
        //console.log(value.location_id !== location_id);
        if (value.location_id !== location_id) {
            clickId = [];
        }
    });
    current_location_days = clickId;
    //console.log(current_location_days);
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
            var delay = 2300;
            color = "green";
            var toast =

                '<div id="location_hour_delete_toast_' + id +
                '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                delay + '" >' +
                '<div class="toast-header" style="background-color: ' +
                color +
                ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                '<div class="toast-body" id="toast_id_body' +
                id + '">' + data.response.success +
                '</div> </div> </div>';
            $("#bottom_toast").append(toast);
            $('#location_hour_delete_toast_' + id).toast("show");
            current_location_days = jQuery.grep(clickId, function (value) {
                return value != id;
            });
            current_locations = jQuery.grep(clickId, function (value) {
                return value != id;
            });

            $('#modal_body_for_days_' + data.location_id.id).replaceWith(data.view).slideUp('slow');

            //console.log(current_location_days);

        }, //end of success
        error: function (error) {
            $.each(error.responseJSON.errors, function (index, val) {
                var delay = 2300;
                color = "red";
                var toast =
                    '<div id="location_toast_' + index +
                    '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                    delay + '" >' +
                    '<div class="toast-header" style="background-color: ' +
                    color +
                    ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                    '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                    '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                    '<div class="toast-body" id="toast_id_body' +
                    index + '">' + val +
                    '</div> </div> </div>';
                $("#bottom_toast").append(toast);
                $('#location_toast_' + index).toast("show");
                setTimeout(function () {
                    $('#location_toast_' + index)
                        .remove();

                }, delay + 600);

            });


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
          

            $('#locations_contacts_div_' + data.location_id.id).replaceWith(data.view);

        }, //end of success
        error: function (error) {
            $.each(error.responseJSON.errors, function (index, val) {
                

            });


        } //end of error
    }); //end of ajax
}