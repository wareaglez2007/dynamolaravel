
                @if (is_countable($images) && count($images) > 0)
                    <div class="row" id="images_div">
                        @foreach ($images as $img)

                            <div class="col-md-2" style="margin-bottom: 15px" id="uploadedimages">

                                <div class="square">

                                    <a href="{{ $img->id }}" id="{{ $img->id }}" data-toggle="modal"
                                        data-target="#image_modal_{{ $img->id }}"
                                        title="{{ asset('storage/thumbnails/' . $img->image_original_name) }}"
                                        onclick="event.preventDefault();">
                                    <img src="{{ asset('storage/thumbnails/' . $img->file) }}" @if ($img->image_width != $img->image_height) class="upload-img-thumbnail landscape" @else
                        class="upload-img-thumbnail" @endif
                                            alt="/images/thumbs/{{ $img->file }}" />
                                    </a>
                                </div>
                            </div>


                        @endforeach
                    </div>
                @endif
                <div id="editpage_pagination">
                    {{ $images->withpath('/admin/pages/editpagepaginations/' . $editview->id) }}
                </div>
                <script>
                    $(function() {
                        $('#editpage_pagination .pagination a').on('click', function(e) {
                            e.preventDefault();
                           // var href = $(this).attr('href');
                            var id = $("#page_id_images").val();
                            var page = $("#pagination_page").val();

                            var url =  $(this).attr('href');
                            console.log(url);
                            getPublished(url);
                            //window.history.pushState("", "", url);
                        });

                        function getPublished(url) {
                            console.log(url);
                            $.ajax({
                                url: url,
                                method: 'get'
                            }).done(function(data) {
                                console.log(data.view);
                                $('#images_modal').html(data.view);
                            }).fail(function() {});
                        }
                    });

                </script>
