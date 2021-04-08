/**
 * This function will upload miltiple images on change
 * uses Ajax and php controller
 */
$("#upload_images_form").on("change", function() {
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
        success: function(data) {
            //first listen back from ajax to see if the image is valide or not
            $.each(data.validations, function(index, val) {
                console.log(val.upload);
                var alert = "success";
                var mess = val;
                var seconds = 2500;
                if(val.upload != null){
                    alert = "danger";
                    mess = val.upload;
                    seconds = 4000;
                }else{
                    alert = "success";
                    mess = val;
                    seconds = 2500;
                }
                $("#ajax_main_container").prepend('<div class="alert alert-'+alert+' shadow p-3 mb-5" id="up_' +
                    index +
                    '"> <span class="spinner-border spinner-border-sm" role="status" id="mess_' +
                    index + '"></span>' + mess + '</div>');
               $('#up_' + index).fadeOut(seconds);

            });
            $('#images_section').html(data.view);

        }, //end of success
        error: function(error) {

            $("#ajaxactioncallimages").attr('class', "alert alert-danger");
            $.each(error.responseJSON.erros, function(index, val) {
                $("#ajaxactioncallimages #e_message").html(
                    "<img src='/storage/ajax-loader-red.gif'>" + val);
                //   $('#ajaxactioncallimages').fadeOut(2500);
                //console.log(index, val);
            });




        } //end of error
    }); //end of ajax

}); //End of on change

function getPublished(url) {
    $.ajax({
        url: url
    }).done(function(data) {

        // $('#images_section').html(data.view);
    }).fail(function() {

    });
}

/*************************Edit/Delete Images*****************************************/

/**
 * Edit images
 * @param {*} id
 */
function ShowImageEditOptions(id) {

    var image_name = $("#title_"+id).val();
    var image_alt_text = $("#alt_"+id).val();
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
        success: function(data) {
            $("#exampleModalLabel_"+id).text("Name: "+image_name);
            $("#exampleModalLabel_"+id).prepend('<div class="alert alert-success" id="image_update_' +
                id +
                '"> <span class="spinner-border spinner-border-sm" role="status" id="update_mess_' +
                id + '" ></span>&nbsp;<span style="font-size:10px;">' + data.success + '</span></div>');
            $('#image_update_' + id).fadeOut(2400);
            ///$('#images_section').html(data.view);
            //  $('#ajaxactioncallimages').fadeOut(2500);

        }, //end of success
        error: function(error) {

            $("#ajaxactioncallimages").attr('class', "alert alert-danger");
            $.each(error.responseJSON.errors, function(index, val) {
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
function DeleteSelectedImage(id, image_name, page, count) {
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
        url: "/admin/Images/deleteselectedimage?page="+page,
        method: "get",
        cache: false,
        data: {
            id: id,
            image_name: image_name
        },
        success: function(data) {
            $("#ajax_main_container").prepend('<div class="alert alert-success shadow p-3 mb-5 " id="del_' +
                id +
                '"> <span class="spinner-border spinner-border-sm" role="status" id="messed_' +
                id + '"></span>&nbsp;' + data.success + '</div>');
            $('#del_' + id).fadeOut(2400);
            if(count == 1){
                getImageUploadPage(page-1);
            }else{
                $('#images_section').html(data.view);
            }

        }, //end of success
        error: function(error) {

            $("#ajaxactioncallimages").attr('class', "alert alert-danger");
            $.each(error.responseJSON.errors, function(index, val) {
                $("#ajaxactioncallimages #e_message").html(
                    "<img src='/storage/ajax-loader-red.gif'/>" + val);
                //   $('#ajaxactioncallimages').fadeOut(2500);
                // console.log(index, val);
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
        url: "/admin/Images/getafterdelete?page="+page_number,
        method: "get",
        success: function(data) {

            $('#images_section').html(data.view);


        }, //end of success
        error: function(error) {




        } //end of error
    }); //end of ajax

}
