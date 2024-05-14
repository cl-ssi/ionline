<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#contenido', // Replace this CSS selector to match the placeholder element for TinyMCE
        menu: {
            custom: {
                title: 'Limpiar documento',
                items: 'cleanSpaceButton cleanTextButton cleanColorButton cleanTableButton'
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
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist | table forecolor backcolor removeformat preview',
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

                        // Eliminar atributos innecesarios de la tabla
                        table.removeAttribute('width');
                        table.removeAttribute('heigth');
                        table.removeAttribute('cellspacing');
                        table.removeAttribute('cellpadding');

                        // Procesar cada celda en la tabla
                        var cells = table.querySelectorAll('tr, td, th');
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

                            // Buscar y reemplazar etiquetas <p> por <span> dentro de las celdas
                            var paragraphs = cell.querySelectorAll('p');
                            paragraphs.forEach(p => {
                                var span = document.createElement(
                                    'span');
                                span.innerHTML = p
                                .innerHTML; // Mover el contenido
                                span.setAttribute('style', p
                                    .getAttribute('style')
                                    ); // Conservar el estilo
                                p.parentNode.replaceChild(span,
                                p); // Reemplazar <p> por <span>
                            });
                        });
                    });

                    // Establecer el contenido limpio de nuevo en el editor
                    editor.setContent(container.innerHTML);
                }
            });



            editor.ui.registry.addMenuItem('cleanTextButton', {
                text: 'Limpiar tamaño y tipo de letra',
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
                        if (element.style.lineHeight) {
                            element.style.removeProperty('line-height');
                        }
                        if (element.style.margin) {
                            element.style.removeProperty('margin');
                        }
                    });

                    var paragraphs = container.querySelectorAll('p');
                    paragraphs.forEach(function(p) {
                        // Verificar y conservar text-align: justify o center si están presentes
                        const textAlign = p.style.textAlign === 'justify' ? 'justify' :
                            (p.style.textAlign === 'center' ? 'center' : '');
                        p.removeAttribute('style'); // Elimina todos los estilos
                        if (textAlign) {
                            p.style.textAlign =
                                textAlign; // Reestablece justify o center si estaba aplicado
                        }
                    });

                    // Extendiendo la funcionalidad para eliminar etiquetas vacías ahora también para 'p'
                    var elements = container.querySelectorAll('span, div, em, strong');
                    elements.forEach(function(el) {
                        // Eliminar la etiqueta si el contenido es solo espacio en blanco o &nbsp;
                        var innerContent = el.innerHTML.replace(/&nbsp;/g, ' ').trim();
                        if (!innerContent) {
                            el.parentNode.removeChild(el);
                        }
                    });

                    editor.setContent(container.innerHTML);
                }
            });

            editor.ui.registry.addMenuItem('cleanSpaceButton', {
                text: 'Limpiar espacios en blanco',
                onAction: function(_) {
                    var content = editor.getContent({
                        format: 'raw'
                    });
                    // Reemplazar todas las instancias de &nbsp; con un espacio regular
                    var updatedContent = content.replace(/&nbsp;/g, ' ');
                    editor.setContent(updatedContent);
                }
            });

            editor.ui.registry.addMenuItem('cleanColorButton', {
                text: 'Eliminar colores y fondos',
                onAction: function(_) {
                    var content = editor.getContent();
                    var container = document.createElement('div');
                    container.innerHTML = content;

                    var elements = container.querySelectorAll('span, p');
                    elements.forEach(function(el) {
                        // Eliminar los estilos de color y todos los estilos de fondo
                        if (el.style.color) {
                            el.style.removeProperty('color');
                        }

                        // Eliminar todas las propiedades de estilo que comienzan con 'background'
                        Array.from(el.style).forEach(styleProp => {
                            if (styleProp.startsWith('background')) {
                                el.style.removeProperty(styleProp);
                            }
                        });

                        // Si la etiqueta queda sin atributos, eliminarla completamente
                        if (!el.getAttribute('style') || el.getAttribute('style') ===
                            '') {
                            el.outerHTML = el
                                .innerHTML; // Elimina la etiqueta pero conserva su contenido
                        }
                    });

                    editor.setContent(container.innerHTML);
                }
            });
        }
    });
</script>
