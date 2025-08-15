"use strict";

/** Global Variables */
const dynamicModalContent = $(".dynamic-modal .modal-content");

/** Template Variables */
const loader = `
<div class="d-flex justify-content-center align-items:center p-3">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>`;

/** Functions */



/** Image preview function
 * @param {object} input
 * @param {string} selector
 * @param {function} callback
 */
function previewImage({ input, selector = null, callback }) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            if (selector) {
                $(selector).attr("src", e.target.result);
            }
            callback(e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/** Show dynamic modal
 * @param {string} url
 */
function showDynamicModal(url) {
    $.ajax({
        method: "GET",
        url: url,
        beforeSend: function () {
            $(".modal-content").html(loader);
        },
        success: function (data) {
            $(".modal-content").html(data);
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "bottom auto"
            });
        },
        error: function (xhr, status, error) { },
    });
}

/** get and set location
 * @param {string} url
 * @param {string} selector
 */
function getLocation(url, selector) {
    $.ajax({
        method: "GET",
        url: url,
        beforeSend: function () {
            $.ajax({
                method: "GET",
                url: url,
                beforeSend: function () {
                    $(selector).html(`<option value="">Loading...</option>`);
                },
                success: function (data) {
                    $(selector).html(`<option value="">Select</option>`);
                    $.each(data, function (key, value) {
                        $(selector).append(
                            `<option value="${value.id}">${value.name}</option>`
                        );
                    });
                },
                error: function (xhr, status, error) {
                    $(selector).html(`<option value="">Select</option>`);
                },
            });
        },
    });
}

/**
 * Scroll to an element.
 *
 * @param {string} selector - jQuery selector for the element to scroll to.
 */
function scrollToElement(selector) {
    var $element = $(selector);
    if ($element.length) $("html, body").animate({ scrollTop: $element.offset().top }, 300);
}


/** On DOM load */
$(document).ready(function () {

    $(".logout-btn").on('click', function(e) {
            e.preventDefault();
            $("#logout-form").trigger('submit');
    });
    
    $("#cover-img").change(function () {
        previewImage({
            input: this,
            callback: function (path) {
                $(".preview-cover-img").css(
                    "background-image",
                    "url(" + path + ")"
                );
            },
        });
    });

    $("#avatar").change(function () {
        previewImage({ input: this, selector: ".preview-avatar" });
    });

    /** Show dynamic modal */
    $(".show-modal").on("click", function (e) {
        e.preventDefault();
        $(".dynamic-modal").modal("show");
        let url = $(this).attr("data-url");
        showDynamicModal(url);
    });

    /** Delete item */
    $(".delete-item").on("click", function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "DELETE",
                    url: url,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function () { },
                    success: function (data) {
                        if (data.status == "success") {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                            });
                            location.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error(error);
                    },
                });
            }
        });
    });

    /*************************************************
     * Become Instructor page js Start
     *************************************************/

    /** payout account change */
    $("#payout_account").on("change", function () {
        let value = $(this).val();
        $('.payment_info_wrap').removeClass('d-none')
        $('.payment-info').addClass('d-none');
        $(`.payment-${value}`).removeClass('d-none');

    });

    /*************************************************
     * Become Instructor page js End
     *************************************************/

    /** Change Currency */
    $('.change-currency').on('change', function (e) {
        $('.set-currency-header').trigger('submit');
    });
    $('.set-currency-header-mobile').on('change', function (e) {
        $('.change-currency-header-mobile').trigger('submit');
    });
    
    // submit language form
    $("#setLanguageHeader").on("change", function (e) {
        $(this).trigger('submit');
    });

    $(".set-language-header-mobile").on("change", function (e) {
        $('.change-language-header-mobile').trigger('submit');
    });

    /** Newsletter Form */
    $('.newsletter').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            method: "POST",
            url: base_url + "/newsletter-request",
            data: formData,
            beforeSend: function () {
                $(".newsletter button").text(submitting);
                $(".newsletter button").prop('disabled', true);
            },
            success: function (data) {
                toastr.success(data.message)
                $(".newsletter button").text(subscribe_now);
                $(".newsletter button").prop('disabled', false);
                $(".newsletter")[0].reset();
            },
            error: function (xhr, status, error) {
                let messages = xhr.responseJSON.message;
                $.each(messages, function (key, value) {
                    toastr.error(value);
                });
                $(".newsletter button").text(subscribe_now);
                $(".newsletter button").prop('disabled', false);
            }
        })
    });

    /** handle contact form */
    $("#contact-form").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            method: "POST",
            url: base_url + "/contact/send-mail",
            data: formData,
            beforeSend: function() {
                $("#contact-form button").text(submitting);
                $("#contact-form button").prop('disabled', true);
            },
            success: function (data) {
                toastr.success(data.message)
                $("#contact-form")[0].reset();
                $("#contact-form button").text(subscribe_now);
                $("#contact-form button").prop('disabled', false);
                window.location.reload();

            },
            error: function(xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    toastr.error(value);
                });
                $("#contact-form button").text(subscribe_now);
                $("#contact-form button").prop('disabled', false);
            }
        })
    });

    /** Show course delete request Modal*/
    $('.course-delete-request').on('click', function (e) {
        e.preventDefault();
        $(".dynamic-modal").modal("show");
        let url = $(this).attr("href");
        showDynamicModal(url);
    })



    /** Plugins init */
    tinymce.init({
        selector: ".text-editor",
        plugins:
            "anchor autolink charmap emoticons image link lists searchreplace visualblocks wordcount ",
        toolbar:
            "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons",
        tinycomments_mode: "embedded",
        tinycomments_author: "Author name",
        menubar: false,
        mergetags_list: [
            {
                value: "First.Name",
                title: "First Name",
            },
            {
                value: "Email",
                title: "Email",
            },
        ],
    });

    $(".select2").select2();
});
