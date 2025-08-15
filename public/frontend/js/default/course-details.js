$(document).ready(function () {
    $("#videoModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var videoUrl = button.data("bs-video");
        $(this).find(".iframe-video").attr("src", videoUrl);
    });
    $("#videoModal").on("hide.bs.modal", function () {
        $(this).find(".iframe-video").attr("src", "");
    });
});
