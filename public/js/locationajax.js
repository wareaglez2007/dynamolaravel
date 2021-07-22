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


    var dayshoursArray = {};

    $.each(edit_idtracker, function (key, i) {
        var days = $('#day_edit_' + i).val();
        var hoursfrom = $('#hours_from_edit_' + i).val();
        var hoursto = $('#hours_to_edit_' + i).val();
        //Set the array values
        dayshoursArray['day_edit_' + i] = days;
        dayshoursArray['hours_from_edit_' + i] = hoursfrom;
        dayshoursArray['hours_to_edit_' + i] = hoursto;
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
            numrows: edit_idtracker
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
        console.log(idtracker);
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


    console.log(idtracker)
    console.log("After:")
    if (numRows < 8) { //If a row is removed then enable the button
        $("#add_hours_btn").removeClass("disabled");
    }
    numRows--;//Decriment by one everytime a row is removed.

}

var edit_counter = 0; //Global Counter DO NOT remove
var edit_numRows = 0;
var edit_idtracker = [];
/**
 * Used inside the modal for editing locations
 * updated on 07/21/2021
 */
function addHourstoEdit() {
    console.log("clicked");
    var days_hours = $("#location_hours_div").clone();
    edit_counter++;
    edit_numRows++;
    days_hours.attr("id", "location_hours_div_edit" + edit_counter);

    days_hours.find("#day").attr("id", "day_edit_" + edit_counter);
    days_hours.find("#hours_from").attr("id", "hours_from_edit_" + edit_counter);
    days_hours.find("#hours_to").attr("id", "hours_to_edit_" + edit_counter);
    days_hours.find("#clearday").attr("id", "clearday_edit_" + edit_counter);
    days_hours.find("#clearday_edit_" + edit_counter).attr("onclick", "ClearEditDayRow(" + edit_counter + ")"); //Change counter value on function
    edit_idtracker.push(edit_counter);
    console.log(edit_idtracker);

    $("#additional_edit").each(function () {
        $("#additional_edit").append(days_hours);
    });
    days_hours.slideDown('slow'); //Call the slide down after the div has been appended! 07/19/2021
    //If counter is equal to 7 (that will give me max of 7 rows for days of the week)
    if (edit_numRows == 7) {
        $("#add_hours_btn_edit").addClass("disabled");
    }
}

/**
 * Removes the Day Row from the modal
 * Date: 07/17/2021
 * Author: Rostom Sahakian
 * @param {*} id
 */
function ClearEditDayRow(id) {
    //Remove that clicked row
    $("#location_hours_div_edit" + id).slideUp('slow');
    setTimeout(function () {
        $("#location_hours_div_edit" + id).remove();

    }, 600);
    edit_idtracker = jQuery.grep(edit_idtracker, function (value) {
        return value != id;
    });
    console.log(edit_idtracker);
    if (edit_numRows < 8) { //If a row is removed then enable the button
        $("#add_hours_btn_edit").removeClass("disabled");
    }
    edit_numRows--;//Decriment by one everytime a row is removed.

}
/**
 * Edit hours row in the location edit modal
 * @param {*} id
 */
function editHoursRow(id) {
    console.log($("#do_edit_day_" + id).attr('disabled'));
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
    //$("#do_edit_day_"+id).attr('disabled', false);

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
            console.log(data);
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
            //$('#locationeditmodal_' + data.location_id.id).remove();

            // setTimeout(function () {
            //     $('#location_delete_toast_' + id)
            //         .remove();

            // }, delay + 600);
            // $('#hours_to_edit-div #hours_row_'+id).remove();
            //
            //   setTimeout(function () {
            //$('#locations_modal_holder').remove();
            $('#modal_body_for_days_' + data.location_id.id).replaceWith(data.view).slideUp('slow');


            //  }, 1000);

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
