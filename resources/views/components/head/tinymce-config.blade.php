<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#contenido', // Replace this CSS selector to match the placeholder element for TinyMCE
        menu: {
            custom: {
                title: 'Limpiar documento',
                items: 'cleanTableButton cleanTextButton cleanSpaceButton cleanParragraphButton'
            }
        },
        menubar: 'file edit views insert format tools table custom',
        plugins: 'code table lists preview fullscreen pagebreak',
        language: 'es_MX',
        browser_spellcheck: true,
        style_formats: [{
            title: 'Caracteres especiales',
            inline: 'span',
            classes: 'especial'
        }, ],
        style_formats_merge: true,
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table forecolor backcolor removeformat preview',
        content_style: "body { font-size: 10pt; font-family: Verdana; }",
        promotion: false,
        license_key: 'gpl',
        setup: function(editor) {
            editor.ui.registry.addMenuItem('cleanTableButton', {
                text: 'Limpiar tablas',
                onAction: function(_) {
                    // Obtener el contenido del editor
                    var content = editor.getContent();

                    // Crear un elemento HTML para manipular el DOM
                    var container = document.createElement('div');
                    container.innerHTML = content;

                    // Encontrar todas las tablas y eliminar sus atributos
                    var tables = container.querySelectorAll('table');
                    tables.forEach(function(table) {
                        // Establecer los atributos de estilo y borde
                        table.setAttribute('style',
                            'border-collapse: collapse; width: 100%;');
                        table.setAttribute('border', '1');

                        // Procesar cada celda en la tabla
                        var cells = table.querySelectorAll('td, th');
                        cells.forEach(cell => {
                            // Conservar los atributos 'colspan' y 'rowspan'
                            const colspan = cell.getAttribute('colspan');
                            const rowspan = cell.getAttribute('rowspan');

                            // Limpiar todos los atributos excepto 'colspan' y 'rowspan'
                            while (cell.attributes.length > 0) {
                                cell.removeAttribute(cell.attributes[0].name);
                            }

                            // Reestablecer 'colspan' y 'rowspan' si existían
                            if (colspan) cell.setAttribute('colspan', colspan);
                            if (rowspan) cell.setAttribute('rowspan', rowspan);
                        });
                    });

                    // Establecer el contenido limpio de nuevo en el editor
                    editor.setContent(container.innerHTML);
                }
            });

            editor.ui.registry.addMenuItem('cleanTextButton', {
                text: 'Limpiar letras',
                onAction: function(_) {
                    var content = editor.getContent();
                    var container = document.createElement('div');
                    container.innerHTML = content;

                    // Encontrar todos los elementos con estilos inline y eliminar font-size y font-family
                    var allElements = container.querySelectorAll('*');
                    allElements.forEach(function(element) {
                        if (element.style.fontSize) {
                            element.style.removeProperty('font-size');
                        }
                        if (element.style.fontFamily) {
                            element.style.removeProperty('font-family');
                        }
                    });

                    editor.setContent(container.innerHTML);
                }
            });

            editor.ui.registry.addMenuItem('cleanSpaceButton', {
                text: 'Limpiar espacios',
                onAction: function(_) {
                    var content = editor.getContent({
                        format: 'raw'
                    });
                    // Reemplazar todas las instancias de &nbsp; con un espacio regular
                    var updatedContent = content.replace(/&nbsp;/g, ' ');
                    editor.setContent(updatedContent);
                }
            });

            editor.ui.registry.addMenuItem('cleanParragraphButton', {
                text: 'Limpiar párrafos',
                onAction: function(_) {
                    var content = editor.getContent();
                    var container = document.createElement('div');
                    container.innerHTML = content;

                    var paragraphs = container.querySelectorAll('p');
                    paragraphs.forEach(function(p) {
                        // Conservar text-align: justify si está presente
                        const textAlign = p.style.textAlign === 'justify' ? 'justify' :
                            '';
                        p.removeAttribute('style');
                        if (textAlign) {
                            p.style.textAlign = textAlign;
                        }
                    });

                    editor.setContent(container.innerHTML);
                }
            });
        }
    });
</script>
