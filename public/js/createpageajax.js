                                //EventListener Click
                                $( window ).on( "load", function() {
                                    $('#ajaxSubmit').on('click', function(e) {
                                        e.preventDefault();
                                        $('#ajax_messages').html('');
                                    }); //End of on Click


                                    //If the title of the page has already been taken then give error
                                    //Ajax call to see if title
                                    $('#page_title').on('blur',function() {
                                        var page_title = $('#page_title').val();
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
                                                title: page_title
                                            },
                                            success: function(response) {
                                                $('#helppagetitle').attr('class',
                                                    'text-success');
                                                $('#helppagetitle').text(response.success);
                                            }, //end of success
                                            error: function(error) {
                                                $('#page_title').focus();
                                                setTimeout(function() {
                                                    $('#page_title').focus()
                                                }, 50);
                                                $('#helppagetitle').attr('class',
                                                'text-danger');
                                                $('#helppagetitle').text(error.responseJSON
                                                    .errors
                                                    .title);


                                            } //end of error
                                        }); //end of ajax


                                    }); //End of blur
                                    //If the slug name is not unique give error
                                    //Ajax call to see if title
                                    $('#page_slug').on('blur',function() {
                                        var page_slug = $('#page_slug').val();
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
                                            success: function(response) {
                                                $('#helpIdSlug').attr('class', 'text-success');
                                                $('#helpIdSlug').text(response.success);
                                            }, //end of success
                                            error: function(error) {
                                                console.log(error);
                                                $('#page_slug').focus();
                                                setTimeout(function() {
                                                    $('#page_slug').focus()
                                                }, 50);
                                                $('#helpIdSlug').attr('class', 'text-danger');
                                                $('#helpIdSlug').text(error.responseJSON.slug);


                                            } //end of error
                                        }); //end of ajax


                                    }); //End of blur

                                }); //End of Ready


                                function CreateNewPagesAjax() {
                                    //Post requests
                                    var PageTitle = $('#page_title').val();
                                    var PageSubTitle = $('#page_subtitle').val();
                                    var PageParent = $('select#page_parent').val();
                                    var PageSlug = $('#page_slug').val();
                                    var PageOwner = $('#page_owner').val();
                                    var PageDesription = CKEDITOR.instances.editor.getData();
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                'content')
                                        }
                                    }); //End of AjaxSetup
                                    $.ajax({
                                        url: "/admin/pages/store",
                                        method: "post",
                                        data: {
                                            title: PageTitle,
                                            subtitle: PageSubTitle,
                                            parent_page_id: PageParent,
                                            slug: PageSlug,
                                            owner: PageOwner,
                                            content: PageDesription

                                        }, //End of data
                                        success: function(response) {
                                            //   console.log(response);
                                            $('#mtype').attr('class',
                                            'btn btn-success');
                                            $('#ajax_messages').append('<ol><li><h4>' + response
                                                .success +
                                                '</h4></li></ol>');
                                            $('#modal').modal('show');
                                            setTimeout(function(){// wait for 7 mili secs(2)
                                                $("#cform")[0].reset();
                                                CKEDITOR.instances.editor.setData('');
                                                location.reload(); // then reload the page.(3)
                                           }, 700);



                                        }, //end of respnse
                                        error: function(error) {
                                            $('#mtype').attr('class',
                                            'btn btn-danger');
                                            $('#ajax_messages').append('<ol>');
                                            for (var prop in error.responseJSON.errors) {
                                                var item = error.responseJSON.errors[prop];
                                                $('#ajax_messages ol').append('<li><h4>' + item +
                                                    '</h4></li>');
                                                //
                                                // console.log(item);
                                            }
                                            $('#modal').modal('show')

                                        }

                                    }); //End of Ajax Call


                                }
