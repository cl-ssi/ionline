<!-- resources/views/components/pdf-viewer-modal.blade.php -->
<div class="p-0">
    <object type="application/pdf" data="{{ $pdfUrl }}" width="100%" height="700">
    </object>
    {{-- 
    <iframe id="document" 
        width="100%"
        height="700px" 
        src="http://docs.google.com/gview?url={{ $pdfUrl }}"> 
    --}}
</div>
