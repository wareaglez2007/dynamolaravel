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
        //cache: false,
        data: {
            location_name: bus_name,
            addr1: addr1,
            addr2: addr2,
            city: city,
            postal: postal,
            state: state
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
            $("form").trigger("reset");

        }, //end of success
        error: function (error) {
            $.each(error.responseJSON.errors, function (index, val) {
                console.log(val);
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
                console.log(val);
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
