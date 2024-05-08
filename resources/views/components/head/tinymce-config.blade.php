<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#contenido', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists preview fullscreen pagebreak',
        language: 'es_MX',
        browser_spellcheck: true,
        style_formats: [
            {title: 'Caracteres especiales', inline: 'span', classes: 'especial'},
        ],
        style_formats_merge: true,
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table forecolor backcolor removeformat preview',
        content_style: "body { font-size: 10pt; font-family: Verdana; }",
        promotion: false
    });
</script>