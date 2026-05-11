(function ($) {
    "use strict";
    jQuery(document).ready(function () {
        if (typeof wc_add_to_cart_params != 'undefined') {

            /* Ajax mini cart remove and Revert item remove from cart.*/
            $(document).on('click', '.woocommerce-mini-cart-item .remove', function (e) {
                e.preventDefault();
                var $thisbutton = $(this),
                    $mini_cart = $thisbutton.closest('.widget_shopping_cart_content'),
                    $cart_item = $thisbutton.closest('.woocommerce-mini-cart-item');
                $cart_item.addClass('loading');
                if (!$(this).hasClass('revert-cart-item')) {
                    $.post(wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'remove_from_cart'), {cart_item_key: $thisbutton.data('cart_item_key')}, function (response) {
                        if (!response || !response.fragments) {
                            window.location = $thisbutton.attr('href');
                            return;
                        }
                        $thisbutton.addClass('revert-cart-item');

                        $mini_cart.find('.pre-remove').addClass('removed');
                        $cart_item.addClass('pre-remove');

                        $mini_cart.find('.woocommerce-mini-cart__total.total .woocommerce-Price-amount').replaceWith(response.fragments.cart_subtotal);
                        $mini_cart.find('.free-shipping-required-notice').replaceWith(response.fragments.free_shipping_cart_notice);
                        $thisbutton.closest('.widget_shopping_cart ').find('.total-cart-item').replaceWith(response.fragments['.total-cart-item']);

                        setTimeout(function () {
                            $mini_cart.find('.removed').remove();
                        }, 500);
                        if (response.fragments.cart_count == 0) {
                            $mini_cart.find('.wrap-bottom-mini-cart').fadeOut();
                        }

                        $cart_item.removeClass('loading');
                        $(document).trigger('Sublimeplus_after_remove_product_item', {
                            "fragments": response.fragments
                        });
                    }).fail(function () {
                        window.location = $thisbutton.attr('href');
                        return;
                    });
                } else {
                    var cart_item_key = $thisbutton.data('cart_item_key');
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: wc_add_to_cart_params.ajax_url,
                        data: {
                            action: "restore_cart_item",
                            cart_item_key: cart_item_key
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log('AJAX Restore ' + errorThrown);
                            console.log('AJAX Restore ' + cart_item_key);
                        },
                        success: function (data) {
                            $(document).trigger('Sublimeplus_after_restore_product_item', {
                                "fragments": data
                            });
                            $thisbutton.removeClass('revert-cart-item');

                            $cart_item.removeClass('pre-remove');
                            if (!$mini_cart.find('.wrap-bottom-mini-cart').is(":visible")) {
                                $mini_cart.find('.wrap-bottom-mini-cart').fadeIn();
                            }
                            $mini_cart.find('.woocommerce-mini-cart__total.total .woocommerce-Price-amount').replaceWith(data.cart_subtotal);
                            $mini_cart.find('.free-shipping-required-notice').replaceWith(data.free_shipping_cart_notice);
                            $thisbutton.closest('.widget_shopping_cart ').find('.total-cart-item').replaceWith(data['.total-cart-item']);
                            $cart_item.removeClass('loading');
                        }
                    });
                    return false;
                }
            });

            //Update mini top cart ajax
            $(document).on('added_to_cart', function (event, fragments) {
                if (!$('.cafe-canvas-cart')[0])
                    Sublimeplus_add_to_cart_mess(fragments['Sublimeplus_add_to_cart_message']);

            });
            /* End Ajax cart for shop loop product item*/

            //Refresh variations_form button added to cart when change option.
            $("form.variations_form").on("woocommerce_variation_select_change", function () {
                $(this).find('.cart-added').removeClass('cart-added');
            });

            
        }
        /* End Ajax Add to Cart for Single Product */

        //Function for Add to Cart message
        function Sublimeplus_add_to_cart_mess($Sublimeplus_mess) {
            if (!!$Sublimeplus_mess && $Sublimeplus_mess != undefined) {
                if ($('#sublimeplus-add-to-cart-message')[0]) {
                    $('#sublimeplus-add-to-cart-message').replaceWith($Sublimeplus_mess);
                } else {
                    $('body').append($Sublimeplus_mess);
                }
                setTimeout(function () {
                    $('#sublimeplus-add-to-cart-message').addClass('active');
                }, 100);
                setTimeout(function () {
                    $('#sublimeplus-add-to-cart-message').removeClass('active');
                }, 3500);
            }
        }

        /* Quick view js */
        $(document).on('click', '.product .btn-quick-view', function (e) {
            e.preventDefault();
            $('.sublimeplus-mask-close').addClass('loading active mask-quick-view');
            var load_product_id = $(this).attr('data-productid');
            var data = {action: 'Sublimeplus_quick_view', product_id: load_product_id};
            $(this).parent().addClass('loading');
            var $this = $(this);
            $.ajax({
                url: ajaxurl,
                data: data,
                type: "POST",
                success: function (response) {
                    $('body').append(response);
                    $this.parent().removeClass('loading');
                    // Variation Form
                    var form_variation = $(document).find('#sublimeplus-quickview-lb .variations_form');
                    form_variation.wc_variation_form();
                    form_variation.trigger('check_variations');
                    Sublimeplus_quick_view_gal();
                    //Sync button compare/wishlist quickview load.
                    if ($('#sublimeplus-quickview-lb .sublimeplus-wishlist-button')[0]) {
                        if (window.zooWishlist.model.exists($('#sublimeplus-quickview-lb .sublimeplus-wishlist-button').data('id'))) {
                            window.zooWishlist.view.renderBrowseButton($('#sublimeplus-quickview-lb .sublimeplus-wishlist-button'));
                        }
                    }
                    if ($('#sublimeplus-quickview-lb .sublimeplus-compare-button')[0]) {
                        if (window.zooProductsCompare.model.exists($('#sublimeplus-quickview-lb .sublimeplus-compare-button').data('id'))) {
                            window.zooProductsCompare.view.renderBrowseButton($('#sublimeplus-quickview-lb .sublimeplus-compare-button'));
                        }
                    }
                    setTimeout(function () {
                        $('#sublimeplus-quickview-lb').css('opacity', '1');
                        $('#sublimeplus-quickview-lb').css('top', '50%');
                    }, 100);
                }
            });
        });

        $(document).on('click', '.close-quickview, .sublimeplus-mask-close.mask-quick-view', function (e) {
            e.preventDefault();
            Sublimeplus_close_quick_view();
        });
        //Close Quickview when click to compare/wish list.
        $(document).on('Sublimeplus_browse_wishlist', function () {
            Sublimeplus_close_quick_view();
        });
        $(document).on('Sublimeplus_browse_compare', function () {
            Sublimeplus_close_quick_view();
        });
        //Swatches gallery for quick view
        $(document).on('cleverswatch_update_gallery', function (event, response) {
            if ($('#sublimeplus-quickview-lb')[0])
                Sublimeplus_quick_view_gal();
        });

        //Close Quickview;
        function Sublimeplus_close_quick_view() {
            $('.sublimeplus-mask-close').removeClass('loading active mask-quick-view');
            $('#sublimeplus-quickview-lb').css({'top': 'calc(50% + 150px)', 'opacity': '0'});
            setTimeout(function () {
                $('#sublimeplus-quickview-lb').remove();
            }, 500)
        }

        //Quickview gallery
        function Sublimeplus_quick_view_gal() {
            if ($('.sublimeplus-product-quick-view .wrap-main-product-gallery')[0]) {
                let thumb_num = $('.sublimeplus-product-gallery.images').data('columns');
                if (typeof  $.fn.slick != 'undefined') {
                    $('.sublimeplus-product-quick-view .wrap-main-product-gallery').slick({
                        slidesToShow: 1,
                        rows: 0,
                        slidesToScroll: 1,
                        dots: true,
                        focusOnSelect: true,
                        rtl: $('body.rtl')[0] ? true : false,
                        prevArrow: '<span class="sublimeplus-carousel-btn prev-item"><i class="sublimeplus-icon-arrow-left"></i></span>',
                        nextArrow: '<span class="sublimeplus-carousel-btn next-item"><i class="sublimeplus-icon-arrow-right"></i></span>',
                    });
                }
            }
        }

        /* End Quick view js */
    })
})(jQuery);