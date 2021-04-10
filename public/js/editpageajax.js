/**/
/**/ //Edit page - Publish/unpublish toggle button
/**/

$(document).ready(function () {
    $(".switch input[type=checkbox]").click(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            }
        }),


            $.ajax({
                type: "POST",
                url: "/admin/pages/edit/updatestatus",
                data: {
                    page_id: $("#page_id").val(),
                    status: $(this).prop("checked") ? 1 : 0
                },
                success: function (response) {
                    console.log(response);
                }
            });
    });
});
/************************************************SLUGS*************************************** */
//EDIT SLUG SECTION
//TODO:
//if user clicks on the edit icon, then enable the slug edit.
function EnableSlugEdit() {
    if ($("#slug_input_section").prop('disabled') == true) {
        $("#slug_input_section").prop('disabled', false);
        $("#do_edit_slug i").attr("class", "bi bi-unlock");
    } else {
        $("#slug_input_section").prop('disabled', true);
        $("#do_edit_slug i").attr("class", "bi bi-lock");
    }
}

//If the slug name is not unique give error
//Ajax call to see if title

function CheckUserSlugInput() {
    var page_slug = $('#slug_input_section').val();
    var old_slug = $('#hidden_page_slug').val();
    var page_id = $("#edit_url_pg_id").val();
    var page_parent = $("#edit_url_parent").val();
    var base_url = $("#page_base_url").val();
    if (page_slug != "") {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            }
        }); //End of ajax setup
        $.ajax({
            url: "/admin/pages/create/validateslug",
            method: "post",
            data: {
                slug: page_slug
            },
            success: function (response) {
                $('#helpIdSlug').attr('class', 'text-success');
                $('#helpIdSlug').text(response.success);
                $("#do_edit_slug").attr("class",
                    "form-control btn btn-outline-secondary d-none");
                $("#do_edit_slug").prop("disabled", true);
                $("#save_edit_slug").attr("class",
                    "form-control btn btn-success");
                return true;

            }, //end of success
            error: function (error) {
                console.log(error);
                $('#slug_input_section').focus();
                setTimeout(function () {
                    $('#slug_input_section').focus()
                }, 50);
                $('#helpIdSlug').attr('class', 'text-danger');
                $('#helpIdSlug').text(error.responseJSON.slug);
                $("#do_edit_slug").attr("class",
                    "form-control btn btn-outline-secondary");
                $("#do_edit_slug").prop("disabled", true);
                $("#save_edit_slug").attr("class",
                    "form-control btn btn-success d-none");
                return false;

            } //end of error
        }); //end of ajax
    }


}

//Save slug changes-------------------------------------
function SaveSlugChanges(id, parent) {
    //if save edit slug is hit------------*****-----03-31-2021
    var slug = $('#slug_input_section').val();
    var base_url = $("#page_base_url").val();
    var old_slug = $("#hidden_page_slug").val();
    console.log(parent);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup

    $.ajax({
        url: "/admin/pages/edit/editpageslug",
        method: "post",
        data: {
            page_id: id,
            parent_id: parent,
            slug: slug,
            old_slug: old_slug
        },
        success: function (response) {

            $('#helpIdSlug').attr('class', 'text-success');
            $('#helpIdSlug').text(response.success.success_messag);
            $("#save_edit_slug").attr("class",
                "form-control btn btn-success d-none");
            $("#slug_input_section").prop('disabled', true);

            $("#do_edit_slug").attr("class", "form-control btn btn-outline-secondary");
            $("#do_edit_slug").prop("disabled", false);
            $("#do_edit_slug i").attr("class", "bi bi-lock");
            $('#page_link').prop("href", base_url + response.success.uri);
            $('#page_link').text(base_url + response.success.uri);
            $('#slug_input_section').val(response.success.slug);

        }, //end of success save edit  ajax call
        error: function (error) {

            $('#helpIdSlug').attr('class', 'text-danger');
            $('#helpIdSlug').text(error.responseJSON.error_message);
            $("#save_edit_slug").attr("class", "form-control btn btn-danger");
            $('#slug_input_section').val(error.responseJSON.slug);
        } //end of error save edit ajax call
    }); //End of save edit ajax call------***----------***---

}
//CHECKING IF THIS IS A HOMEPAGE SECTION
$(document).ready(function () {
    $("#is_homepage").on('change', function () {

        var homepage = $(this).prop("checked") ? 1 : null;
        console.log(homepage);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        }),


            $.ajax({
                type: "POST",
                url: "/admin/pages/edit/homepage",
                data: {
                    page_id: $("#page_id").val(),
                    status: homepage
                },
                success: function (response) {

                    console.log(response.success);
                    $('#homepage_message').attr('class',
                        'text-success');
                    $('#homepage_message').text(response
                        .success);


                },
                error: function (response) {
                    console.log(response.responseJSON.errors);
                    $('#homepage_message').attr('class',
                        'text-danger');
                    $('#homepage_message').text(response
                        .responseJSON.errors);

                }
            });
    });
});
//VALIDATING DATA
//EventListener Click
$(window).on("load", function () {
    $('#ajaxSubmit').on('click', function (e) {
        e.preventDefault();
        $('#ajax_messages').html('');
    }); //End of on Click


    //If the title of the page has already been taken then give error
    //Ajax call to see if title
    $('#title').on('blur', function () {
        var page_title = $('#title').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            }
        }); //End of ajax setup
        $.ajax({
            url: "/admin/pages/create/validatenewdata",
            method: "post",
            data: {
                title: page_title,
                flag: true,
                id: $('#page_id').val()

            },
            success: function (response) {
                $('#helpId').attr('class',
                    'text-success');
                $('#helpId').text(response.success);
            }, //end of success
            error: function (error) {
                $('#title').focus();
                setTimeout(function () {
                    $('#title').focus()
                }, 50);
                $('#helpId').attr('class',
                    'text-danger');
                $('#helpId').text(error.responseJSON
                    .errors
                    .title);


            } //end of error
        }); //end of ajax

    });
});

function UpdatePage(id) {
    //Post requests
    var PageTitle = $('#title').val();
    var PageSubTitle = $('#subtitle').val();
    var PageParent = $('select#page_parent').val();
    var PageOwner = $('#owner').val();
    var PageDesription = CKEDITOR.instances.editor.getData();
    var slug = $('#slug').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content')
        }
    }); //End of AjaxSetup
    $.ajax({
        url: "/admin/pages/update",
        method: "post",
        data: {
            id: id,
            title: PageTitle,
            subtitle: PageSubTitle,
            parent_id: PageParent,
            owner: PageOwner,
            description: PageDesription,
            slug: slug,

        }, //End of data
        success: function (response) {
            $('#ajax_messages').text("");
            $('#mtype').attr('class',
                'btn btn-success');
            $('#ajax_messages').append('<h4>' + response
                .success +
                '</h4>');
            $('#modal').modal('show');

            setTimeout(function () { // wait for 5 secs(2)


                location.reload(); // then reload the page.(3)
            }, 700);


        }, //end of respnse
        error: function (error) {
            $('#ajax_messages').text("");
            $('#mtype').attr('class',
                'btn btn-danger');
            $('#ajax_messages').append('<ol>');
            for (var prop in error.responseJSON.errors) {
                var item = error.responseJSON.errors[prop];
                $('#ajax_messages ol').append('<li><h4>' + item +
                    '</h4></li>');

            }
            $('#modal').modal('show')

        }

    }); //End of Ajax Call


}
