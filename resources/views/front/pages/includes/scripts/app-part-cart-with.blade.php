<script type="text/javascript">
    $(document).ready(function () {
        // for adding product to cart from part box - STARTED //
        $('.add-to-cart-part-box').on('click', function (e) {
            var quantity = 1;
            var part_id = $(this).data('partId');
            var brand_id = $(this).data('brandId');
            var a_tag = $('#add-to-cart-part-box-'+part_id);
            $.ajax({
                type: "post",
                url: route('part-add-to-cart'),
                data: {
                    'part_id': part_id,
                    'quantity': quantity,
                    'brand_id': brand_id,
                    'action': 'add',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    a_tag.html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
                },
                success: function (response) {
                    if(response.message.length > 0) {
                        $('.cart-total-counter').html(response.return.total_items);
                    } else {
                        //
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                },
                complete: function () {
                    a_tag.html('<i class="fa fa-shopping-cart"></i>');
                }
            });
        });
        // for adding product to cart from part box - ENDED //

        // for adding product to wish list from part box - STARTED //
        $('.add-to-with-list-part-box').on('click', function (e) {
            var part_id = $(this).data('partId');
            var brand_id = $(this).data('brandId');
            var a_tag = $('#add-to-with-list-part-box-'+part_id);
            $.ajax({
                type: "post",
                url: route('part-add-to-wish-list'),
                data: {
                    'part_id': part_id,
                    'brand_id': brand_id,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    a_tag.html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
                },
                success: function (response) {
                    if(response.message.length > 0) {
                        if(response.return == 'Added') {
                            a_tag.attr('data-tip', 'Remove from Wishlist');
                            a_tag.html('<i class="fa fa-heart"></i>');
                        } else {
                            a_tag.attr('data-tip', 'Add to Wishlist');
                            a_tag.html('<i class="fa fa-heart-o"></i>');
                        }
                    } else {
                        //
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    a_tag.html('<i class="fa fa-heart-o"></i>');
                },
                complete: function () {
                    //
                }
            });

        });
        // // for adding product to wish list from part box - ENDED //
    });
</script>