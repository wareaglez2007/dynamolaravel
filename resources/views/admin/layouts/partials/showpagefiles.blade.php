@if (is_countable($files) && count($files) > 0)
    <div class="row">
        @foreach ($files as $file)
            <div class="col-md-2" id="files_div" style="margin-bottom: 15px;">

                <div class="card" id="{{ $file->id }}">
                    <img src="{{ asset('storage/resource-images/' . $file->extension . '.png') }}"
                        class="card-img-top" id="{{ $file->id }}"/>
                    <div class="card-body">
                        <p class="card-text"> {{ $file->file_name }}</p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
@else
    <div class="col-md-12">
        <p>There are currently no files uploaded.</p>
    </div>
@endif
<div id="editpagefile_pagination">
    {{ $files->withpath('/admin/pages/editpagepaginations/files/' . $editview->id) }}
</div>
<style>
    span.imgCheckbox0 {
        position: inherit !important;

    }

</style>
<script src="{{ asset('imgCheckbox-master/jquery.imgcheckbox.js') }}"></script>
<script>
    //This function will make sure pagination is handlled with Ajax in the background
    $(function() {
        $('#editpagefile_pagination .pagination a').on('click', function(e) {
            e.preventDefault();
            //URL for the pagiantion
            var url = $(this).attr('href');
            getView(url);
        });

        function getView(url) {
            $.ajax({
                url: url,
                method: 'get'
            }).done(function(data) {
                $('#file_modal').html(data.view);
            }).fail(function() {});
        }
    });

    $("#files_div img").imgCheckbox({
        "graySelected": true,
        "scaleSelected": true,
        onload: function() {
            // Do something fantastic!
        },
        onclick: function(el) {
            var isChecked = el.hasClass("imgChked"),
                imgEl = el.children()[0]; // the img element

            // console.log(imgEl.id + " is now " + (isChecked ? "checked" : "not-checked") + "!");
            var page_id = $("#page_id_file").val();
            if (isChecked) {
                var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "file_id_" + imgEl.id)
                    .attr("id", "file_id_" + imgEl.id)
                    .val(imgEl.id);
                $('#file_page_attachment').append(input);
            } else {
                $("#file_id_" + imgEl.id).remove();
            }

        }
    });

</script>
