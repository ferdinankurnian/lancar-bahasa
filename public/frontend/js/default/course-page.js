"use strict";

/** variables */
const placeholder = $(".preloader-two");
var filters = {};

function fetchCourseData(page = 1, filters = {}) {
    var filterParams = new URLSearchParams();
    for (var key in filters) {
        filterParams.append(key, filters[key]);
    }
    $.ajax({
        url: base_url + "/fetch-courses?page=" + page + "&" + filterParams.toString(),
        beforeSend: function () {
            placeholder.removeClass("d-none");
            scrollToElement(".top-baseline");
        },
        success: function (data) {
            $(".course-holder").html(data.items);
            $(".sub-category-holder").html(data.sidebar_items);
            if (data.itemCount != 0) {
                updatePaginationLinks(page, data.lastPage);
            }
            $(".course-count").text(data.itemCount);
            placeholder.addClass("d-none");
            if (data.itemCount == 0) {
                $(".pagination-wrap").addClass("d-none");
            } else {
                $(".pagination-wrap").removeClass("d-none");
            }
        },
        error: function (xhr, status, error) {
            placeholder.addClass("d-none");
            toastr.error("Something went wrong! please reload the page");
        },
    });

    // Update browser history
    var state = {
        page: page,
        filters: filters
    };
    if (filterParams.toString().length > 0) {
        var url = window.location.pathname + '?' + filterParams.toString();
    } else {
        var url = window.location.pathname;
    }

    history.pushState(state, null, url);
}


$(document).on("click", ".pagination a", function (event) {
    event.preventDefault();
    var page = $(this).attr("href").split("page=")[1];

    // filters.page = page;

    // Fetch data with the updated filters
    fetchCourseData(page, filters);
});

function updatePaginationLinks(currentPage, lastPage) {
    var paginationHtml = '<ul class="pagination">';
    var maxPagesToShow = 8;
    var startPage = Math.max(currentPage - maxPagesToShow, 1);
    var endPage = Math.min(currentPage + maxPagesToShow, lastPage);

    // Get current URL parameters
    var urlParams = new URLSearchParams(window.location.search);

    // Previous link
    if (currentPage > 1) {
        urlParams.set('page', currentPage - 1);
        paginationHtml += '<li class="page-item"><a class="page-link" href="?' + urlParams.toString() + '"><i class="fas fa-chevron-left"></i></a></li>';
    } else {
        paginationHtml += '<li class="page-item disabled"><span><i class="fas fa-chevron-left"></i></span></li>';
    }

    // First and dots if needed
    if (startPage > 1) {
        urlParams.set('page', 1);
        paginationHtml += '<li class="page-item"><a class="page-link" href="?' + urlParams.toString() + '">1</a></li>';
        if (startPage > 2) {
            paginationHtml += '<li class="disabled page-dots"><span>...</span></li>';
        }
    }

    // Page links
    for (var i = startPage; i <= endPage; i++) {
        urlParams.set('page', i);
        paginationHtml += '<li class="page-item' + (i == currentPage ? ' active' : '') + '"><a class="page-link" href="?' + urlParams.toString() + '">' + i + '</a></li>';
    }

    // Last and dots if needed
    if (endPage < lastPage) {
        if (endPage < lastPage - 1) {
            paginationHtml += '<li class="disabled"><span>...</span></li>';
        }
        urlParams.set('page', lastPage);
        paginationHtml += '<li class="page-item"><a class="page-link" href="?' + urlParams.toString() + '">' + lastPage + '</a></li>';
    }

    // Next link
    if (currentPage < lastPage) {
        urlParams.set('page', currentPage + 1);
        paginationHtml += '<li class="page-item"><a class="page-link" href="?' + urlParams.toString() + '"><i class="fas fa-chevron-right"></i></a></li>';
    } else {
        paginationHtml += '<li class="page-item disabled"><span><i class="fas fa-chevron-right"></i></span></li>';
    }

    paginationHtml += "</ul>";
    $(".pagination").html(paginationHtml);
}


// Filters
$(".main-category-checkbox").on("change", function () {
    var mainCategory = $(this).val()

    filters.main_category = mainCategory;
    // filters.page = 1;
    filters.category = '';
    fetchCourseData(1, filters);
});

$(document).on("change", ".category-checkbox", function () {
    var selectedCategories = [];
    $(".category-checkbox:checked").each(function () {
        selectedCategories.push($(this).val());
    });

    filters.category = selectedCategories.join(",");
    fetchCourseData(1, filters);
});

$(".language-checkbox").on("change", function () {
    var selectedLanguages = [];
    $(".language-checkbox:checked").each(function () {
        selectedLanguages.push($(this).val());
    });
    filters.language = selectedLanguages.join(",");

    fetchCourseData(1, filters);
});

$(".price-checkbox").on("change", function () {
    var selectedPrice = [];
    $(".price-checkbox:checked").each(function () {
        selectedPrice.push($(this).val());
    });
    filters.price = selectedPrice.join(",");

    fetchCourseData(1, filters);
});

$(".level-checkbox").on("change", function () {
    var selectedLevel = [];
    $(".level-checkbox:checked").each(function () {
        selectedLevel.push($(this).val());
    });
    filters.level = selectedLevel.join(",");

    fetchCourseData(1, filters);
});

$(".rating-checkbox").on("change", function () {
    var selectedRating = [];
    $(".rating-checkbox:checked").each(function () {
        selectedRating.push($(this).val());
    });
    filters.rating = selectedRating.join(",");

    fetchCourseData(1, filters);
});

$(".orderby").on("change", function () {
    var order = $(this).val()

    filters.order = order;
    fetchCourseData(1, filters);
});


// On Document Load
$(document).ready(function () {
    // Extract page number and filters from URL
    var urlParams = new URLSearchParams(window.location.search);

    var page = urlParams.get("page") || 1;
    var search = urlParams.get("search");
    var category = urlParams.get("category");
    var main_category = urlParams.get("main_category");
    var language = urlParams.get("language");
    var price = urlParams.get("price");
    var level = urlParams.get("level");
    var rating = urlParams.get("rating");

    // Initialize filters object
    if (search) {
        filters.search = search;
    }
    if (category) {
        filters.category = category.split(',');
        $(".category-checkbox").each(function () {
            if (filters.category.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });
    }
    if (main_category) {
        filters.main_category = main_category;
        $(".main-category-checkbox").each(function () {
            if (filters.main_category.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });
    }
    if (language) {
        filters.language = language.split(',');
        $(".language-checkbox").each(function () {
            if (filters.language.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });
    }
    if (price) {
        filters.price = price.split(',');
        $(".price-checkbox").each(function () {
            if (filters.price.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });
    }
    if (level) {
        filters.level = level.split(',');
        $(".level-checkbox").each(function () {
            if (filters.level.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });
    }
    if (rating) {
        filters.rating = rating.split(',');
        $(".rating-checkbox").each(function () {
            if (filters.rating.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });
    }

    // Fetch data on page load
    fetchCourseData(page, filters);
});

