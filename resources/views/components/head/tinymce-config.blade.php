<script src="https://cdn.tiny.cloud/1/ktzops2hqsh9irqr0b17eqfnkuffe5d3u0k4bcpzkc1kfssx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#contenido', // Replace this CSS selector to match the placeholder element for TinyMCE
    language: 'es_MX',
    //theme: 'modern',
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'save table directionality emoticons template paste textcolor'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | removeformat ',
    browser_spellcheck: true,
    contextmenu: false,
    style_formats: [
        {title: 'Caracteres especiales', inline: 'span', classes: 'especial'},
    ],
    // The following option is used to append style formats rather than overwrite the default style formats.
    style_formats_merge: true,
    content_style: "body { font-size: 10pt; font-family: Verdana; }"
  });
</script>