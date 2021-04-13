/**
 * This function will upload miltiple images on change
 * uses Ajax and php controller
 */
$("#upload_images_form").on("change", function () {
    //When user selects the open button call ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: "/admin/Images/uploadimage",
        method: "post",
        cache: false,
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data) {
            var current = 0;
            //first listen back from ajax to see if the image is valide or not
            $.each(data.validations, function (index, val) {
                console.log(val.upload);
                current++;
                var color = "";
                var mess = "";
                var timer = current * 9;
                var delay = 0;
                if (val.upload != null) {
                    color = "red";
                    mess = val.upload;
                    delay = 2500 + timer;

                    var e_toast =

                        '<div id="do_upload_image_toast_id_' + index +
                        '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                        delay + '" >' +
                        '<div class="toast-header" style="background-color: ' +
                        color +
                        ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                        '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                        '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                        '<div class="toast-body" id="toast_id_body' +
                        index + '">' + mess +
                        '</div> </div> </div>';
                    $("#bottom_toast").append(e_toast);
                    $('#do_upload_image_toast_id_' + index).toast("show");
                    setTimeout(function () {
                        $('#do_upload_image_toast_id_' + index)
                            .remove();
                    }, delay + 900);
                } else {
                    color = "green";
                    mess = val;
                    delay = 2300 + timer;
                    var toast =

                        '<div id="do_upload_image_toast_id_' + index +
                        '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                        delay + '" >' +
                        '<div class="toast-header" style="background-color: ' +
                        color +
                        ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                        '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                        '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                        '<div class="toast-body" id="toast_id_body' +
                        index + '">' + mess +
                        '</div> </div> </div>';
                    $("#bottom_toast").append(toast);
                    $('#do_upload_image_toast_id_' + index).toast("show");
                    setTimeout(function () {
                        $('#do_upload_image_toast_id_' + index)
                            .remove();
                    }, delay + 900);



                }

            });
            $('#images_section').html(data.view);

        }, //end of success
        error: function (error) {

            $("#ajaxactioncallimages").attr('class', "alert alert-danger");
            $.each(error.responseJSON.erros, function (index, val) {
                $("#ajaxactioncallimages #e_message").html(
                    "<img src='/storage/ajax-loader-red.gif'>" + val);
            });

        } //end of error
    }); //end of ajax

}); //End of on change

function getPublished(url) {
    $.ajax({
        url: url
    }).done(function (data) {

        // $('#images_section').html(data.view);
    }).fail(function () {

    });
}

/*************************Edit/Delete Images*****************************************/

/**
 * Edit images
 * @param {*} id
 */
function ShowImageEditOptions(id) {

    var image_name = $("#title_" + id).val();
    var image_alt_text = $("#alt_" + id).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: "/admin/Images/updateimagesinfo",
        method: "post",
        cache: false,
        data: {
            id: id,
            image_name: image_name,
            image_alt_text: image_alt_text,
        },
        success: function (data) {
            var color = "";
            var delay = 2300;
            color = "green";
            var toast =

                '<div id="upload_edit_toast_id_' + id +
                '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                delay + '" >' +
                '<div class="toast-header" style="background-color: ' +
                color +
                ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                '<div class="toast-body" id="toast_id_body' +
                id + '">' + data.success +
                '</div> </div> </div>';
            $("#bottom_toast").append(toast);
            $('#upload_edit_toast_id_' + id).toast("show");
            setTimeout(function () {
                $('#upload_edit_toast_id_' + id)
                    .remove();
            }, delay + 500);

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
    //Edit title
    //Edit size
    //Edit alt text

}
/**
 * Delete Images
 * @param {*} id int
 * @param {*} image_name String
 */
function DeleteSelectedImage(id, image_name, image_origin_name, page, count) {
    //When user selects the open button call ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: "/admin/Images/deleteselectedimage?page=" + page,
        method: "get",
        cache: false,
        data: {
            id: id,
            image_name: image_name,
            image_origin_name: image_origin_name
        },
        success: function (data) {
            var color = "";
            var delay = 2300;
            //If success is null then it must be an error.
            if (data.response.success != null) {
                color = "green";
                var toast =

                    '<div id="upload_toast_id_' + id +
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
                $('#upload_toast_id_' + id).toast("show");
                setTimeout(function () {
                    $('#upload_toast_id_' + id)
                        .remove();
                }, delay + 500);
            } else {
                color = "red";
                var e_toast =

                    '<div id="upload_toast_id_' + id +
                    '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
                    delay + '" >' +
                    '<div class="toast-header" style="background-color: ' +
                    color +
                    ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
                    '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
                    '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
                    '<div class="toast-body" id="toast_id_body' +
                    id + '">' + data.response.errors +
                    '</div> </div> </div>';
                $("#bottom_toast").append(e_toast);
                $('#upload_toast_id_' + id).toast("show");
                setTimeout(function () {
                    $('#upload_toast_id_' + id)
                        .remove();
                }, delay + 500);
            }
            if (count == 1) {
                getImageUploadPage(page - 1);
            } else {
                $('#images_section').html(data.view);
            }

        }, //end of success
        error: function (error) {

            $("#ajaxactioncallimages").attr('class', "alert alert-danger");
            $.each(error.responseJSON.errors, function (index, val) {
                $("#ajaxactioncallimages #e_message").html(
                    "<img src='/storage/ajax-loader-red.gif'/>" + val);
            });

            // console.log(error);


        } //end of error
    }); //end of ajax
}
function getImageUploadPage(page_number) {
    //When user selects the open button call ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: "/admin/Images/getafterdelete?page=" + page_number,
        method: "get",
        success: function (data) {

            $('#images_section').html(data.view);
        }, //end of success
        error: function (error) {

        } //end of error
    }); //end of ajax

}
