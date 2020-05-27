<script type="text/javascript">
    $(document).ready(function () {
        // search accessories
        var searchAccessoriesRequest = null;
        $('#assign_accessories').on('keyup', function (e) {
            var value = $(this).val();
            searchAccessoriesRequest = $.ajax({
                type: "post",
                dataType: 'html',
                url: "{{route('admin-get-search-parts')}}",
                data: {
                    'key': value,
                    'type': 'accessory',
                    '_token': $('input[name="_token"]').val()
                },
                beforeSend: function () {
                    $('.loader-search-accessories').show();
                    if (searchAccessoriesRequest != null) {
                        searchAccessoriesRequest.abort();
                    }
                },
                success: function (response) {
                    $('#search_accessories_result').fadeIn();
                    $('#search_accessories_result').html(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Error handling
                },
                complete: function () {
                    searchAccessoriesRequest = null;
                    $('.loader-search-accessories').hide();
                }
            });
        });
        // search parts
        var searchPartsRequest = null;
        $('#assign_parts').on('keyup', function (e) {
            var value = $(this).val();
            searchPartsRequest = $.ajax({
                type: "post",
                dataType: 'html',
                url: "{{route('admin-get-search-parts')}}",
                data: {
                    'key': value,
                    'type': 'part',
                    '_token': $('input[name="_token"]').val()
                },
                beforeSend: function () {
                    $('.loader-search-parts').show();
                    if (searchPartsRequest != null) {
                        searchPartsRequest.abort();
                    }
                },
                success: function (response) {
                    $('#search_parts_result').fadeIn();
                    $('#search_parts_result').html(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Error handling
                },
                complete: function () {
                    searchPartsRequest = null;
                    $('.loader-search-parts').hide();
                }
            });
        });

        // delete image code
        $(".delete-model-image").on("click", function (e) {
            e.preventDefault();
            var payload = $(this).attr("payload");
            var token = $('input[name="_token"]').val();
            var elm = $(this);
            if (confirm('Are you sure you want to delete image?')) {
                $.ajax({
                    url: "{{ route('admin-remove-model-image') }}",
                    method: "POST",
                    data: "_token=" + token + "&payload=" + payload,
                    success: function (resp) {
                        elm.prop("disabled", true);
                        elm.parent().parent().remove();
                        elm.remove();
                    }
                });
            }
        });
    });
</script>