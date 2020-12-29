//Draft FUNCTIONS Page  Pushlish Script-->

function PublishPage(id, pagenum, first,last) {
    $.get('/admin/pages/draft/' + id + '/' + 0, function (draftpage) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        });
        $.ajax({
            url: "/admin/pages/publish",
            type: "post",
            data: {
                page_id: draftpage.id,
                change_status: 1
            },
            success: function (response) {


                if(first == last){
                    pagenum = pagenum-1;
                }
                var url = '/admin/pages/getdraftpages?page='+pagenum;

                $('#pid' + draftpage.id).fadeOut(700, function () {
                    $('#pid' + draftpage.id).remove();
                    getPublished(url);
                });


                function getPublished(url) {
                    $.ajax({
                        url: url
                    }).done(function(data) {
                        //  console.log(data);
                        $('#some_ajax').html(data);
                    }).fail(function() {
                        //Do some error
                    });
                }
                   //Call another ajax??
                   $.get('/admin/pages/published/count', function (newcount) {
                    $('#tcount').text('(' + newcount.tashedcount + ')');
                    $('#dcount').text('(' + newcount.draftnewcount + ')');
                    $('#pcount').text('(' + newcount.newcount + ')');

                });
                /**




                $('#pid' + draftpage.id).fadeOut(700, function () {
                    //$('#pid' + draftpage.id).fadeIn().delay(2000);
                   // $('#activeid'+ draftpage.id).show();

                    //Add unpublished page to published table

                    var update_date = new Date(draftpage.updated_at);
                    var create_date = new Date(draftpage.created_at);
                    var markup =
                        "<div class='dropdown show'><a class='btn btn-sm dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-toggle-off' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z' /></svg></a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a href='javascript:void(0)' onclick='EditActivePage(" +
                        draftpage.id +
                        ")'class='dropdown-item'>Edit</a><a href='javascript:void(0)'onclick='DeleteActivePage(" +
                        draftpage.id + "," + draftpage.parent_page_id +
                        ")'class='dropdown-item'>Delete</a><a href='javascript:void(0)'onclick='UnPublishPage(" +
                        draftpage.id +
                        ")'class='dropdown-item'>Unpublish</a></div></div></td>";

                        var send_to_publish = $('#pid'+ draftpage.id).clone().attr('id', 'activeid'+ draftpage.id).show();
                        send_to_publish.find('#publish_function'+draftpage.id)
                        .text('Unpublish')
                        .attr('onclick', 'event.preventDefault();UnPublishPage('+draftpage.id+')')
                        .attr('id','unpublish_function'+draftpage.id);

                        $("#publishedpages").find('tbody').append(send_to_publish);

                        $('#pid' + draftpage.id).remove();

                     /**
                    $("#publishedpages").find('tbody').append($('<tr>').attr('id',
                        'activeid' + draftpage.id)

                        .append($('<th>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + draftpage.id)
                                .attr('class', 'text-muted')
                                .text(draftpage.position)))
                        .append($('<th>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + draftpage.id)
                                .attr('class', 'text-muted')
                                .text(draftpage.id)))
                        .append($('<td>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + draftpage.id)
                                .attr('class', 'text-muted')
                                .text(draftpage.title)))
                        .append($('<td>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + draftpage.id)
                                .attr('class', 'text-muted')
                                .text(create_date.toLocaleDateString())))

                        .append($('<td>').css('text-align', 'center')
                            .append(markup))

                    ); //END oj JQUERY FIND->APPEND FROM Unpublish to Publish */

                /**});*/

            } //closing of success
        }) //closing of ajax
    }); //closing of get
} //closeing for PublishPage function

//unpublish function
function UnPublishPage(id) {
    $.get('/admin/pages/draft/' + id + '/' + 1, function (activepage) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        });
        $.ajax({
            url: "/admin/pages/publish",
            type: "post",
            data: {
                page_id: activepage.id,
                change_status: 0
            },
            success: function (response) {
                //Call another ajax??
                $.get('/admin/pages/published/count', function (newcount) {
                    $('#trashcount').text('Trashed (' + newcount.tashedcount + ')');
                    $('#draftcount').text('Draft (' + newcount.draftnewcount + ')');
                    $('#pubcount').text('Published (' + newcount.newcount + ')');

                });
                var update_date = new Date(activepage.updated_at);
                var create_date = new Date(activepage.created_at);

                $('#activeid' + activepage.id).fadeOut(700, function () {
                    //$('#activeid' + activepage.id).fadeIn().delay(2000);
                    //$('#pid' + activepage.id).show();

                    //Add published page to unpublished table
                    var markup =
                        "<div class='dropdown show'><a class='btn btn-sm dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-toggle-off' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z' /></svg></a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a href='javascript:void(0)' onclick='EditActivePage(" +
                        activepage.id +
                        ")'class='dropdown-item'>Edit</a><a href='javascript:void(0)'onclick='DeletePage(" +
                        activepage.id + "," + activepage.parent_page_id +
                        ")'class='dropdown-item'>Delete</a><a href='javascript:void(0)'onclick='PublishPage(" +
                        activepage.id +
                        ")'class='dropdown-item'>Publish</a></div></div></td>";


                        var send_to_unpublish = $('#activeid'+ activepage.id).clone().attr('id', 'pid'+ activepage.id).show();
                        send_to_unpublish.find('#unpublish_function'+activepage.id).text('Publish')

                       .attr('onclick', 'event.preventDefault();PublishPage('+activepage.id+')')
                       .attr('id','publish_function'+activepage.id);

                        $("#drafts").find('tbody').append(send_to_unpublish);

                        $('#activeid' + activepage.id).remove();
                    /**
                    $("#drafts").find('tbody').append($('<tr>').attr('id', 'pid' +
                        activepage.id)

                        .append($('<th>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + activepage.id)
                                .attr('class', 'text-muted')
                                .text(activepage.id)))
                        .append($('<td>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + activepage.id)
                                .attr('class', 'text-muted')
                                .text(activepage.title)))
                        .append($('<td>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + activepage.id)
                                .attr('class', 'text-muted')
                                .text(create_date.toLocaleDateString())))
                        .append($('<td>')
                            .append($('<a>')
                                .attr('href', '/admin/pages/edit/' + activepage.id)
                                .attr('class', 'text-muted')
                                .text(update_date.toLocaleDateString())))
                        .append($('<td>').css('text-align', 'center')
                            .append(markup))

                    ); //END oj JQUERY FIND->APPEND->Publish to Unpublish*/


                });

            } //closing of success
        }) //closing of ajax
    }); //closing of get
} //closeing for PublishPage function




//Delete FUNCTIONS page AJAX script--->

//Delete from Drafts-> to Trashed
function DeletePage(id, parent) {
    $.get('/admin/pages/all/todelete/' + id + '/' + parent, function (todelete) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        }); //closing of ajax setup
        $.ajax({
            url: "/admin/pages/delete",
            type: "PUT",
            data: {
                id: todelete.id,
                parent: todelete.parent_page_id
            },
            success: function (response) {
                //Call another ajax??
                $.get('/admin/pages/published/count', function (newcount) {
                    //console.log(newcount);
                    $('#trashcount').text('Trashed (' + newcount.tashedcount + ')');
                    $('#draftcount').text('Draft (' + newcount.draftnewcount + ')');
                    $('#pubcount').text('Published (' + newcount.newcount + ')');
                });
                //SECOND CALL TO GET THE DELETED AT DATE
                $.get('/admin/pages/all/deleted/date/' + id + '/', function (deletedate) {

                    var delete_date = new Date(deletedate.deleted_at);
                    var create_date = new Date(todelete.created_at);

                    $('#pid' + todelete.id).fadeOut(700, function () {
                        $('#pid' + todelete.id).fadeIn().delay(2000);
                        $('#pid' + todelete.id).remove();
                        //Add UNPUBLISHED TO TRASH TABLES ---->
                        var markup =
                            "<div class='dropdown show'><a class='btn btn-sm dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-toggle-off' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z' /></svg></a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a href='javascript:void(0)'onclick='RestorePage(" +
                            todelete.id +
                            ")'class='dropdown-item'>Restore</a> <a href='javascript:void(0)'onclick='PermDeletePage(" + todelete.id + ", " + todelete.page_parent_id + ")'class='dropdown-item'>Permanent Delete</a></div></div></td>";
                        $("#trashed").find('tbody').append($('<tr>').attr('id', 'tid' +
                            todelete.id)

                            .append($('<th>')

                                .attr('class', '')
                                .text(todelete.id))
                            .append($('<td>')

                                .attr('class', '')
                                .text(todelete.title))
                            .append($('<td>')

                                .attr('class', '')
                                .text(create_date.toLocaleDateString()))
                            .append($('<td>')

                                .attr('class', '')
                                .text(delete_date.toLocaleDateString()))
                            .append($('<td>').css('text-align', 'center')
                                .append(markup))

                        ); //END oj JQUERY FIND->APPEND->Unpublished to TRASH tid+id AND table id trashed



                    });

                });

            }
        }); //closing for AJAX
    }) //closing for get
}
//Delete from Published to Trash
function DeleteActivePage(id, parent) {
    $.get('/admin/pages/all/todelete/' + id + '/' + parent, function (todelete) {
        //console.log(todelete);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        }); //closing of ajax setup
        $.ajax({
            url: "/admin/pages/delete",
            type: "post",
            data: {
                id: todelete.id,
                parent: todelete.parent_page_id
            },
            success: function (response) {
                //Call another ajax??
                $.get('/admin/pages/published/count', function (newcount) {
                    //console.log(newcount);
                    $('#trashcount').text('Trashed (' + newcount.tashedcount + ')');
                    $('#draftcount').text('Draft (' + newcount.draftnewcount + ')');
                    $('#pubcount').text('Published (' + newcount.newcount + ')');

                    if (newcount.tashedcount === 0) {
                        $("#notrashpages").text('There is no item here yet.');
                    } else {
                        $("#notrashpages").remove();
                    }

                });
                //SECOND CALL TO GET THE DELETED AT DATE
                $.get('/admin/pages/all/deleted/date/' + id + '/', function (deletedate) {

                    var delete_date = new Date(deletedate.deleted_at);
                    var create_date = new Date(todelete.created_at);

                    $('#activeid' + todelete.id).fadeOut(700, function () {
                        //$('#activeid' + todelete.id).fadeIn().delay(2000);

                        //ADD PUBLISHED TO TRASH TABLES --->
                        var markup =
                            "<div class='dropdown show'><a class='btn btn-sm dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-toggle-off' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z' /></svg></a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a href='javascript:void(0)'onclick='RestorePage(" +
                            todelete.id +
                            ")'class='dropdown-item'>Restore</a> <a href='javascript:void(0)'onclick='PermDeletePage(" + todelete.id + ", " + todelete.page_parent_id + ")'class='dropdown-item'>Permanent Delete</a></div></div></td>";








                            /**

                            var send_to_unpublish = $('#activeid'+ activepage.id).clone().attr('id', 'pid'+ activepage.id).show();
                            send_to_unpublish.find('#unpublish_function'+activepage.id).text('Publish')

                           .attr('onclick', 'event.preventDefault();PublishPage('+activepage.id+')')
                           .attr('id','publish_function'+activepage.id);

                            $("#drafts").find('tbody').append(send_to_unpublish);

                            $('#activeid' + activepage.id).remove();*/





                        //From publish -> trash
                        //Find -> tr -> with id of = #activeid' + todelete.id
                        var send_to_trash_from_published = $('#activeid' + todelete.id).clone().attr('id', 'tid'+todelete.id).show();
                        send_to_trash_from_published.find('#page_position_clone'+todelete.id).remove(); //Remove the position column
                      //  $("tr").find("td:last").before();
                        $("#trashed").find('tbody').append(send_to_trash_from_published)
                        .find('td:last').before('<td>'+create_date.toLocaleDateString()+'</td><td>'+delete_date.toLocaleDateString()+'</td>');



                        $('#activeid' + todelete.id).remove();///LAST to be called


                        /**
                        $("#trashed").find('tbody').append($('<tr>').attr('id',
                            'tid' +
                            todelete.id)

                            .append($('<th>')

                                .attr('class', '')
                                .text(todelete.id))
                            .append($('<td>')

                                .attr('class', '')
                                .text(todelete.title))
                            .append($('<td>')

                                .attr('class', '')
                                .text(create_date.toLocaleDateString()))
                            .append($('<td>')

                                .attr('class', '')
                                .text(delete_date.toLocaleDateString()))
                            .append($('<td>').css('text-align', 'center')
                                .append(markup))

                        ); //END oj JQUERY FIND->APPEND->Unpublished to TRASH tid+id AND table id trashed */


                    });
                }); //Closing of the second get Call to get the deleted date information

            }
        }); //closing for AJAX
    }) //closing for get
}

//Permenant Delete

function PermDeletePage(id, parent) {
    $.get('/admin/pages/all/todelete/' + id + '/' + parent, function (todelete) {
        console.log(todelete);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        }); //closing of ajax setup
        //URL /admin/pages/forcedelete
        $.ajax({
            url: "/admin/pages/forcedelete",
            type: "PUT",
            data: {
                id: todelete.id,
                parent: todelete.parent_page_id
            },
            success: function (response) {
                //Call another ajax??
                $.get('/admin/pages/published/count', function (newcount) {
                    //console.log(newcount);
                    $('#trashcount').text('Trashed (' + newcount.tashedcount + ')');
                });
                $('#tid' + todelete.id).fadeOut(700, function () {
                    $('#tid' + todelete.id).fadeIn().delay(2000);
                    $('#tid' + todelete.id).remove();
                });
            }
        });//closing of ajax
    });

}


// Restore -->

//Restore from Trash to Published ? Draft
function RestorePage(id) {
    $.get('/admin/pages/all/trashed/' + id, function (torestore) {
        //console.log(torestore);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        }); //closing of ajaxSetup
        $.ajax({
            url: "/admin/pages/restore",
            type: "PUT",
            data: {
                id: torestore.id
            },
            success: function (response) {

                //Call another ajax??
                $.get('/admin/pages/published/count', function (newcount) {
                    //console.log(newcount);
                    $('#trashcount').text('Trashed (' + newcount.tashedcount + ')');
                    $('#draftcount').text('Draft (' + newcount.draftnewcount + ')');
                    $('#pubcount').text('Published (' + newcount.newcount + ')');


                    var update_date = new Date(torestore.updated_at);
                    var create_date = new Date(torestore.created_at);

                    $('#tid' + torestore.id).fadeOut(500, function () {

                        $('#tid' + torestore.id).fadeIn().delay(1000);
                        $('#tid' + torestore.id).remove();
                        if (newcount.tashedcount == 0) {
                            $("#trashed").find('tbody').append($('<tr><th class="text-muted">There is no item here yet.</th></tr>').attr('id', "notrashpages")).fadeIn().delay(2000);
                        } else {

                        }

                    });



                    //ADD TRASHED TO EITHER DRAFT OR PUBLISHED PAGES --->
                    //Check if the page is Published OR Unpublished user torestore.active
                    if (torestore.active === 0) { //if it is inactive table id = drafts tr=pid
                        //FROM TRASH TO UNPUBLISHED
                        var markup =
                            "<div class='dropdown show'><a class='btn btn-sm dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-toggle-off' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z' /></svg></a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a href='javascript:void(0)' onclick='EditActivePage(" +
                            torestore.id +
                            ")'class='dropdown-item'>Edit</a><a href='javascript:void(0)'onclick='DeletePage(" +
                            torestore.id + "," + torestore.parent_page_id +
                            ")'class='dropdown-item'>Delete</a><a href='javascript:void(0)'onclick='PublishPage(" +
                            torestore.id +
                            ")'class='dropdown-item'>Publish</a></div></div></td>";
                        $("#drafts").find('tbody').append($('<tr>').attr('id', 'pid' +
                            torestore.id)

                            .append($('<th>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(torestore.id)))
                            .append($('<td>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(torestore.title)))
                            .append($('<td>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(create_date.toLocaleDateString())))
                            .append($('<td>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(update_date.toLocaleDateString())))
                            .append($('<td>').css('text-align', 'center')
                                .append(markup))

                        ); //END oj JQUERY FIND->APPEND->Trash to UNPUBLISHED
                    } else {
                        ///table id = publishedpages tr = activeid
                        ///FROM TRASH To PUBLISHED
                        var markup =
                            "<div class='dropdown show'><a class='btn btn-sm dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-toggle-off' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z' /></svg></a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a href='javascript:void(0)' onclick='EditActivePage(" +
                            torestore.id +
                            ")'class='dropdown-item'>Edit</a><a href='javascript:void(0)'onclick='DeleteActivePage(" +
                            torestore.id + "," + torestore.parent_page_id +
                            ")'class='dropdown-item'>Delete</a><a href='javascript:void(0)'onclick='UnPublishPage(" +
                            torestore.id +
                            ")'class='dropdown-item'>Unpublish</a></div></div></td>";
                        $("#publishedpages").find('tbody').append($('<tr>').attr('id',
                            'activeid' + torestore.id)

                            .append($('<th>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(torestore.id)))
                            .append($('<td>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(torestore.title)))
                            .append($('<td>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(create_date.toLocaleDateString())))
                            .append($('<td>')
                                .append($('<a>')
                                    .attr('href', '/admin/pages/edit/' + torestore
                                        .id)
                                    .attr('class', 'text-muted')
                                    .text(update_date.toLocaleDateString())))
                            .append($('<td>').css('text-align', 'center')
                                .append(markup))

                        ); //END oj JQUERY FIND->APPEND FROM TRASH To PUBLISH
                    }

                });

            }
        }) //closing for ajax

    }) //closing for get
}

