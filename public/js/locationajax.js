/**
 * Save locations
 * from: business.blade.php
 */

function savelocations() {
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
            data: file_id //<=Edit
        },
        success: function (data) {
            var delay = 2300;
            color = "green";
            //
            var toast =

                '<div id="detach_toast_id_' + file_id +
                '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                delay + '" >' +
                '<div class="toast-header" style="background-color: ' +
                color +
                ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                '<div class="toast-body" id="toast_id_body' +
                file_id + '">' + data.response.success +
                '</div> </div> </div>';
            $("#bottom_toast").append(toast);
            $('#detach_toast_id_' + file_id).toast("show");
            console.log(file_id);
            $('#attached_image_modal_' + file_id).modal('hide');

            setTimeout(function () {
                $('#detach_toast_id_' + file_id)
                    .remove();

            }, delay + 600);
            setTimeout(function () {
                $('#attached_files').html(data.view);
            }, 400);

        }, //end of success
        error: function (error) {

            $("#ajaxactioncallimages").attr('class', "alert alert-danger");
            $.each(error.responseJSON.errors, function (index, val) {
                $("#ajaxactioncallimages #e_message").html(
                    "<img src='/storage/ajax-loader-red.gif'/>" + val);
                //   $('#ajaxactioncallimages').fadeOut(2500);
                // console.log(index, val);
            });

            // console.log(error);


        } //end of error
    }); //end of ajax
} //end of savelocations
