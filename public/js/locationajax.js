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
            $("#location_editor_"+id).text("Saving ");
            $("#location_editor_"+id).attr("class", "btn btn-success");
            $("#loader_"+id).clone().appendTo("#location_editor_"+id).show();

           // $("#location_editor_"+id).text("Saving "+$(loader).show());
            
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
            


            setTimeout(function () {
                $('#locationeditmodal_' + id).modal('hide');
                $("#location_editor_"+id).text("Update");
                $("#location_editor_"+id).attr("class", "btn btn-primary");

                $("#loader_"+id).hide();
                $('#location_delete_toast_' + id).toast("show");
            }, 1000);


            setTimeout(function () {
                $('#location_delete_toast_' + id)
                    .remove();



            }, delay + 500);
            
        

            setTimeout(function () {

                $('#locations_div').html(data.view);

            }, 1300);

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
                    $("#location_editor_"+id).attr("class", "btn btn-primary");
                    $("#location_editor_"+id).text("Update");
                }, 900);
                $("#location_editor_"+id).attr("class", "btn btn-danger");

                $("#location_editor_"+id).text("Unable to Update");
                setTimeout(function () {
                    $('#location_toast_' + index)
                        .remove();

                }, delay + 600);

            });


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

            var delay = 2300;
            color = "green";
            var toast =

                '<div id="location_hour_to_edit_toast_' + loc_id +
                '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                delay + '" >' +
                '<div class="toast-header" style="background-color: ' +
                color +
                ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                '<div class="toast-body" id="toast_id_body' +
                loc_id + '">' + data.response.success +
                '</div> </div> </div>';
            $("#bottom_toast").append(toast);
            $('#location_hour_to_edit_toast_' + loc_id).toast("show");
            $('#modal_body_for_days_' + data.location_id.id).replaceWith(data.view).slideUp('slow');

        }, //end of success
        error: function (error) {
            $.each(error.responseJSON.errors, function (index, val) {


            });


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