//Draft FUNCTIONS Page  Pushlish Script-->
function PublishPage(id, pagenum, first, last) {
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


                if (first == last) {
                    pagenum = pagenum - 1;
                }
                var url = '/admin/pages/drafts?page=' + pagenum;

                $('#ajaxactioncalls').attr('style', 'display: visible;');
                $('#ajaxactioncalls').html('<img src="/storage/ajax-loader.gif">' + response.success + "...");
                $('#activeid' + draftpage.id).fadeOut(700, function () {
                    $('#activeid' + draftpage.id).remove();
                    getPublished(url);
                });

                $('#ajaxactioncalls').fadeOut(2500);
                function getPublished(url) {
                    $.ajax({
                        url: url
                    }).done(function (data) {
                        //  console.log(data);
                        $('#some_ajax').html(data);
                    }).fail(function () {
                        //Do some error
                    });
                }
                //Call another ajax??
                $.get('/admin/pages/published/count', function (newcount) {
                    $('#tcount').text('(' + newcount.tashedcount + ')');
                    $('#dcount').text('(' + newcount.draftnewcount + ')');
                    $('#pcount').text('(' + newcount.newcount + ')');

                });
            } //closing of success
        }) //closing of ajax
    }); //closing of get
} //closeing for PublishPage function

//Unpublish function
function UnPublishPage(id, pagenum, first, last) {
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


                if (first == last) {
                    pagenum = pagenum - 1;
                }
                var url = '/admin/pages?page=' + pagenum;

                $('#ajaxactioncalls').attr('style', 'display: visible;');
                $('#ajaxactioncalls').html('<img src="/storage/ajax-loader.gif">' + response.success + "...");

                $('#activeid' + activepage.id).fadeOut(700, function () {
                    $('#activeid' + activepage.id).remove();
                    getPublished(url);
                });

                $('#ajaxactioncalls').fadeOut(2500);
                function getPublished(url) {
                    $.ajax({
                        url: url
                    }).done(function (data) {
                        //  console.log(data);
                        $('#some_ajax').html(data);
                    }).fail(function () {
                        //Do some error
                    });
                }

                //Call another ajax??
                $.get('/admin/pages/published/count', function (newcount) {
                    $('#tcount').text('(' + newcount.tashedcount + ')');
                    $('#dcount').text('(' + newcount.draftnewcount + ')');
                    $('#pcount').text('(' + newcount.newcount + ')');

                });
            } //closing of success
        }) //closing of ajax
    }); //closing of get
} //closeing for PublishPage function

//Delete Any Page
function DeleteAnyPage(id, parent, pagenum, first, last, type) {
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

                if (first == last) {
                    pagenum = pagenum - 1;
                }
                var url = '/admin/pages' + type + '?page=' + pagenum;
               // console.log(url);
               $('#ajaxactioncalls').attr('style', 'display: visible;');
               $('#ajaxactioncalls').html('<img src="/storage/ajax-loader.gif">' + response.success + "...");

                $('#activeid' + todelete.id).fadeOut(700, function () {
                    $('#activeid' + todelete.id).remove();
                    getPublished(url);
                });

                $('#ajaxactioncalls').fadeOut(2500);

                function getPublished(url) {
                    $.ajax({
                        url: url
                    }).done(function (data) {
                        $('#some_ajax').html(data);
                    }).fail(function () {
                        //Do some error
                    });
                }
                //Call another ajax
                $.get('/admin/pages/published/count', function (newcount) {
                    $('#tcount').text('(' + newcount.tashedcount + ')');
                    $('#dcount').text('(' + newcount.draftnewcount + ')');
                    $('#pcount').text('(' + newcount.newcount + ')');

                });

            }
        }); //closing for AJAX
    }) //closing for get
}

//Permenant Delete
function PermDeletePage(id, parent, pagenum, first, last, position) {
    $.get('/admin/pages/all/todelete/' + id + '/' + parent, function (todelete) {
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
            type: "post",
            data: {
                id: todelete.id,
                parent: todelete.parent_id,
                position: position
            },
            success: function (response) {

                if (first == last) {
                    pagenum = pagenum - 1;
                }
                var url = '/admin/pages/trashed?page=' + pagenum;

                //ajaxadangercalls
                $('#ajaxadangercalls').attr('style', 'display: visible;');
                $('#ajaxadangercalls').html('<img src="/storage/ajax-loader-red.gif">' + response.success);

                $('#activeid' + todelete.id).fadeOut(700, function () {
                    $('#activeid' + todelete.id).remove();
                    getPublished(url);
                });

                $('#ajaxadangercalls').fadeOut(2500);
                function getPublished(url) {
                    $.ajax({
                        url: url
                    }).done(function (data) {
                        $('#some_ajax').html(data);
                    }).fail(function () {
                        //Do some error
                    });
                }
                //Call another ajax
                $.get('/admin/pages/published/count', function (newcount) {
                    $('#tcount').text('(' + newcount.tashedcount + ')');
                    $('#dcount').text('(' + newcount.draftnewcount + ')');
                    $('#pcount').text('(' + newcount.newcount + ')');

                });
            }
        });//closing of ajax
    });

}
// Restore -->

//Restore Any Page
function RestorePage(id, pagenum, first, last) {
    $.get('/admin/pages/all/trashed/' + id, function (torestore) {
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

                if (first == last) {
                    pagenum = pagenum - 1;
                }
                var url = '/admin/pages/trashed?page=' + pagenum;
                $('#ajaxactioncalls').attr('style', 'display: visible;');
                $('#ajaxactioncalls').html('<img src="/storage/ajax-loader.gif">' + response.success + "...");

                $('#activeid' + torestore.id).fadeOut(700, function () {
                    $('#activeid' + torestore.id).remove();
                    getPublished(url);
                });

                $('#ajaxactioncalls').fadeOut(2500);
                function getPublished(url) {
                    $.ajax({
                        url: url
                    }).done(function (data) {
                        $('#some_ajax').html(data);
                    }).fail(function () {
                        //Do some error
                    });
                }
                //Call another ajax
                $.get('/admin/pages/published/count', function (newcount) {
                    $('#tcount').text('(' + newcount.tashedcount + ')');
                    $('#dcount').text('(' + newcount.draftnewcount + ')');
                    $('#pcount').text('(' + newcount.newcount + ')');

                });

            }
        }) //closing for ajax

    }) //closing for get
}

