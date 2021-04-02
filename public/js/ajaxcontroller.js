
//$(function () {
   // $('#image_page').on('click', function (e) {
    //    e.preventDefault();
     //   var url = '/admin/Images/uploadimage';
    //    getPublished(url);
   // });

    function getPublished(url) {
        $.ajax({
            url: url
        }).done(function (data) {

            $('#ajax_main_container').html(data);
        }).fail(function () {

        });
    }
//});
