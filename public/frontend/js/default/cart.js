"use strict";

const csrf_token = $("meta[name='csrf-token']").attr("content");

/** On Document Load */

$(document).ready(function () {

    // Add to cart
    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();
        let element = $(this);

        $.ajax({
            method: "post",
            url: base_url + "/add-to-cart/" + $(this).data('id'),
            data: {
                _token: csrf_token
            },
            beforeSend: function () {
                element.find("span").text("Adding...");
            },
            success: function (data) {
                if (data.status == "success") {
                    toastr.success(data.message);
                    $('.mini-cart-count').text(data.cart_count);
                    if (data.dataLayer && typeof data.dataLayer === 'object') {
                        dataLayer.push({
                            'event': 'addToCart',
                            'cart_details': data.dataLayer
                        });
                    }
                    
                } else {
                    toastr.error(data.message);
                }

                element.find("span").text("Add to cart");
            },
            error: function (xhr, status, error) {
                toastr.error(basic_error_message);
                element.find("span").text("Add to cart");
            },

        })

    })

    // apply coupon
    $('.coupon-form').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        $.ajax({
            method: "POST",
            url: base_url + "/apply-coupon",
            data: formData,
            beforeSend: function () {
                $('.coupon-form button').attr('disabled', true);
                $('.coupon-form button').text("Applying...");
            },
            success: function (data) {
                let html = `
                  <span>${discount}</span>
                    <br>
                  <small>${data.coupon_code} (${data.offer_percentage}%) <a class="ms-2 text-danger" href="/remove-coupon">×</a></small>
                `;
                $('.coupon-discount').html(html);
                $('.discount-amount').text(data.discount_amount);
                $('.amount').text(data.total);
                // reset form
                $('.coupon-form button').attr('disabled', false);
                $('.coupon-form button').text("Apply Coupon");
                $('.coupon-form')[0].reset();
                toastr.success(data.message);
            },
            error: function (xhr, status, error) {
                
                $('.coupon-form button').attr('disabled', false);
                $('.coupon-form button').text("Apply Coupon");
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    toastr.error(value);
                });
            }
        })
    });
})