<div class="document-preview-area overflow-auto">
    <div id="docx-preview-container"></div>
</div>
<script>
    async function fetchAndPreviewDocx() {
       try {
           // URL of the .docx file
           const docUrl = "{{ asset($file_path )}}";
           // Fetch the .docx file
           const response = await fetch(docUrl);
           // Check if the response is ok
           if (!response.ok) {
               throw new Error('Network response was not ok');
           }
           // Convert the response to Blob
           const blob = await response.blob();
           
           docx.renderAsync(blob, document.getElementById("docx-preview-container")).then(x => console.log("docx: finished"));
       } catch (error) {
           //
       }
   }
   fetchAndPreviewDocx();
</script>