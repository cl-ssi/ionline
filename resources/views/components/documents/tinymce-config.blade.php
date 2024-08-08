<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    /**
     * Para actualizar TinyMce:
     * 1. composer update (para actualizar los paquetes)
     * 2. npx mix (para copiar los archivos de TinyMce a la carpeta public)
     */
    tinymce.init({
        selector: 'textarea#contenido', // Replace this CSS selector to match the placeholder element for TinyMCE
        menu: {
            tools: {
                title: 'Herramientas',
                items: 'code visualblocks removeformat'
            },
            custom: {
                title: 'Limpiar documento',
                items: 'cleanSpaceButton cleanTextButton cleanColorButton cleanTableButton'
            },
        },
        menubar: 'file edit views insert format tools table custom',
        plugins: 'code table lists preview fullscreen pagebreak visualblocks',
        language: 'es_MX',
        browser_spellcheck: true,
        style_formats: [{
            title: 'Caracteres especiales',
            inline: 'span',
            classes: 'especial'
        }, ],
        style_formats_merge: true,
        toolbar: 'undo redo | styles | bold | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist | table forecolor backcolor preview',
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
                        table.removeAttribute('height');
                        table.removeAttribute('cellspacing');
                        table.removeAttribute('cellpadding');
                        table.removeAttribute('align');

                        // Procesar cada celda en la tabla
                        var cells = table.querySelectorAll('tr, td, th');
                        cells.forEach(cell => {
                            // Conservar los atributos 'colspan' y 'rowspan'
                            const colspan = cell.getAttribute('colspan');
                            const rowspan = cell.getAttribute('rowspan');
                            let textAlignCenter = cell.style.textAlign ===
                                'center';

                            // Buscar en los spans si hay un text-align: center y conservarlo
                            const centerSpan = cell.querySelector(
                                'span[style*="text-align: center"]');
                            if (centerSpan) {
                                textAlignCenter = true;
                            }

                            // Limpiar todos los atributos excepto 'colspan' y 'rowspan'
                            cell.removeAttribute('style');
                            while (cell.attributes.length > 0) {
                                cell.removeAttribute(cell.attributes[0].name);
                            }

                            // Reestablecer 'colspan' y 'rowspan' si existían
                            if (colspan) cell.setAttribute('colspan', colspan);
                            if (rowspan) cell.setAttribute('rowspan', rowspan);
                            if (textAlignCenter) cell.style.textAlign = 'center';

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

                            // Si un <span> tiene text-align: center, mover esa propiedad al td o th
                            var spans = cell.querySelectorAll(
                                'span[style*="text-align: center"]');
                            spans.forEach(span => {
                                // Añadir text-align: center al td o th
                                cell.style.textAlign = 'center';
                                // Quitar el atributo style del span si solo tenía text-align
                                if (span.style.length === 1) {
                                    span.removeAttribute('style');
                                } else {
                                    span.style.removeProperty(
                                        'text-align');
                                }
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

                    // Convertir h1, h2, h3, h4 a p con texto en negrita
                    var headers = container.querySelectorAll('h1, h2, h3, h4');
                    headers.forEach(function(header) {
                        var p = document.createElement('p'); // Crea un nuevo elemento p
                        var strong = document.createElement(
                            'strong'); // Crea un nuevo elemento strong
                        strong.innerHTML = header
                            .innerHTML; // Copia el contenido del encabezado al strong
                        p.appendChild(strong); // Añade strong a p
                        header.parentNode.replaceChild(p,
                            header); // Reemplaza el encabezado por el nuevo p
                    });


                    // Eliminar todos los comentarios HTML
                    var removeComments = function(node) {
                        var child = node.firstChild;
                        while (child) {
                            if (child.nodeType === Node.COMMENT_NODE) {
                                var toRemove = child;
                                child = child
                                    .nextSibling; // Asegúrate de establecer el nextSibling antes de eliminar
                                node.removeChild(toRemove);
                            } else {
                                removeComments(child);
                                child = child.nextSibling;
                            }
                        }
                    };

                    removeComments(container);

                    // Encontrar todos los elementos con estilos inline y eliminar font-size y font-family
                    var allElements = container.querySelectorAll('*');
                    allElements.forEach(function(element) {

                        // Eliminar propiedades específicas de estilo y todas las propiedades que comiencen con mso-
                        var style = element.getAttribute('style');
                        if (style) {
                            var cleanedStyle = style.replace(/mso-[^\s:]+:\s*[^;]+;?/g,
                                '').trim();
                            if (cleanedStyle) {
                                element.setAttribute('style', cleanedStyle);
                            } else {
                                element.removeAttribute('style');
                            }
                        }

                        // Eliminar la clase MsoBodyText si está presente
                        if (element.classList.contains('MsoBodyText')) {
                            element.classList.remove('MsoBodyText');
                        }
                        if (element.classList.contains('TableNormal')) {
                            element.classList.remove('TableNormal');
                        }
                        if (element.classList.contains('MsoNormal')) {
                            element.classList.remove('MsoNormal');
                        }
                        if (element.classList.contains('MsoTableGrid')) {
                            element.classList.remove('MsoTableGrid');
                        }

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
                        if (element.style.letterSpacing) {
                            element.style.removeProperty('letter-spacing');
                        }

                        // Si después de eliminar las clases, el atributo class está vacío, quitar el atributo class
                        if (element.classList.length === 0) {
                            element.removeAttribute('class');
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

                    // Extendiendo la funcionalidad para eliminar etiquetas vacías y reemplazarlas por un espacio
                    var elements = container.querySelectorAll('span, div, em, strong, a');
                    elements.forEach(function(el) {
                        // Eliminar la etiqueta si el contenido es solo espacio en blanco o &nbsp; y reemplazar con un espacio
                        var innerContent = el.innerHTML.replace(/&nbsp;/g, ' ').trim();
                        if (!innerContent) {
                            var space = document.createTextNode(
                                ' '); // Crear un nodo de texto con un espacio
                            el.parentNode.replaceChild(space,
                                el); // Reemplazar el elemento por el espacio
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
