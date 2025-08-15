$(document).ready(function() {
    $(document).on("click", '.delete-item', function(e) {
        e.preventDefault();
        let form = $(this).find('form');
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
                form.submit();
            }
        });
    });

    //image popup init
    $('.image-popup').on('click', function() {
        $.magnificPopup.open({
            items: {
                src: $(this).attr('src')
            },
            type: 'image'
        });
    });
});

function markAsReadUnread(checkbox,id) {
    if (isDemo == 'DEMO') {
        toastr.error(demo_mode_error);
        return;
    }
    $.ajax({
        type: "put",
        data: {
            _token: csrf_token,
        },
        url: base_url + "/instructor/lesson-question/seen-update/" + id,
        success: function(response) {
            if (response.success) {
                $(checkbox).attr('title', response.title)
                toastr.success(response.message);
            } else {
                toastr.warning(response.message);
            }
        },
        error: function(xhr, status, err) {
            console.log(err);
            let errors = xhr.responseJSON.errors;
            $.each(errors, function(key, value) {
                toastr.error(value);
            })
        }
    });
}

// Function to toggle the editor visibility
function toggleEditor(questionId) {
    $('.text-editor-' + questionId).toggleClass('d-none');
    $('.default-textarea-' + questionId).toggleClass('d-none');
}