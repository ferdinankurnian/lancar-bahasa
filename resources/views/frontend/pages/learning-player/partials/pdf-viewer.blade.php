<div class="document-preview-area position-relative w-100">
    <div class="pdf_viewer_box overflow-auto">
        <div id="canvas_container" class="w-100 h-100 text-center overflow-auto">
            <canvas id="pdf_renderer"></canvas>
        </div>

        <div class="pdf_navigation_controls position-absolute d-flex">
            <button id="pdf_previous_btn" class="h-100">Previous</button>
            <input id="pdf_current_page" value="1" type="number" class="w-100" />
            <button id="pdf_next_btn" class="h-100">Next</button>
        </div>

        <div class="pdf_zoom_controls position-absolute text-center">
            <button class="btn btn-two" id="pdf_zoom_out"><i class="fas fa-search-minus"></i></button>
            <button class="btn btn-two" id="pdf_zoom_in"><i class="fas fa-search-plus"></i></button>
            <button class="btn btn-two"
                onclick="
                    let element = document.querySelector('.document-preview-area'); 
                    if (element) {
                        if (!document.fullscreenElement) {
                            element.requestFullscreen();
                        } else if (document.exitFullscreen) {
                            document.exitFullscreen();
                        }
                    }
                ">
                <i class="fa fa-expand"></i>
            </button>
        </div>
    </div>
</div>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('frontend/js/pdf.worker.min.js') }}";

    var myState = {
        pdf: null,
        currentPage: 1,
        zoom: 0.8,
    };

    pdfjsLib
        .getDocument("{{ asset($file_path ) }}")
        .promise.then((pdf) => {
            myState.pdf = pdf;
            render();
        })
        .catch(function(error) {
            //
        });

    function render() {
        myState.pdf.getPage(myState.currentPage).then((page) => {
            var canvas = document.getElementById("pdf_renderer");
            var ctx = canvas.getContext("2d");
            var viewport = page.getViewport({
                scale: myState.zoom
            });

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            page
                .render({
                    canvasContext: ctx,
                    viewport: viewport,
                })
                .promise.then(function() {
                    //
                });
        });
    }

    document.getElementById("pdf_previous_btn").addEventListener("click", (e) => {
        if (myState.currentPage > 1) {
            myState.currentPage -= 1;
            document.getElementById("pdf_current_page").value = myState.currentPage;
            render();
            window.scrollTo(0, 0);
            return;
        }
    });

    document.getElementById("pdf_next_btn").addEventListener("click", (e) => {
        if (myState.currentPage < myState.pdf._pdfInfo.numPages) {
            myState.currentPage += 1;
            document.getElementById("pdf_current_page").value = myState.currentPage;
            render();
            window.scrollTo(0, 0);
        }
    });

    document
        .getElementById("pdf_current_page")
        .addEventListener("keypress", (e) => {
            if (myState.pdf == null) return;

            // Get key code
            var code = e.keyCode ? e.keyCode : e.which;

            // If key code matches that of the Enter key
            if (code == 13) {
                var desiredPage =
                    document.getElementById("pdf_current_page").valueAsNumber;

                if (
                    desiredPage >= 1 &&
                    desiredPage <= myState.pdf._pdfInfo.numPages
                ) {
                    myState.currentPage = desiredPage;
                    document.getElementById("pdf_current_page").value = desiredPage;
                    render();
                }
            }
        });

    document.getElementById("pdf_zoom_in").addEventListener("click", (e) => {
        if (myState.pdf == null) return;
        myState.zoom += 0.2;
        render();
    });

    document.getElementById("pdf_zoom_out").addEventListener("click", (e) => {
        if (myState.pdf == null) return;
        myState.zoom -= 0.2;
        render();
    });
</script>
