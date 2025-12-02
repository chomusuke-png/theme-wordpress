jQuery(document).ready(function ($) {

    // Comprueba si ThemeRepeaterData existe
    if (typeof ThemeRepeaterData === 'undefined') {
        return;
    }

    // Función principal para actualizar el campo oculto JSON
    function updateField(wrapper) {
        let items = [];

        wrapper.find('._theme-repeater-item').each(function () {
            items.push({
                title: $(this).find('.title-field').val(),
                icon: $(this).find('.icon-field').val(), // En modo imagen, esto guarda la URL de la imagen
                url: $(this).find('.url-field').val()
            });
        });

        wrapper.find('._theme-repeater-hidden').val(JSON.stringify(items)).trigger('change');
    }

    // Función para generar las opciones <option> del select
    function generateIconOptions(icons) {
        let options = '<option value="">Elegir icono…</option>';
        for (const [class_name, label] of Object.entries(icons)) {
            options += `<option value="${class_name}">${label}</option>`;
        }
        return options;
    }

    // Inicialización de cada repetidor
    $('._theme-repeater-wrapper').each(function () {
        const wrapper = $(this);
        const wrapperId = wrapper.attr('class').split(' ').find(cls => cls.startsWith('_theme_'));
        const mode = wrapper.data('mode'); // Leemos el modo (icon o image)

        // Determina qué lista de iconos usar
        let iconList = {};
        if (wrapperId === ThemeRepeaterData.social_id) {
            iconList = ThemeRepeaterData.social_icons;
        } else if (wrapperId === ThemeRepeaterData.related_id) {
            iconList = ThemeRepeaterData.related_icons;
        }

        const iconOptions = generateIconOptions(iconList);

        // Drag & Drop
        wrapper.find('._theme-repeater-list').sortable({
            handle: '.drag-handle',
            update: function () {
                updateField(wrapper);
            }
        });

        // AÑADIR ELEMENTO
        wrapper.on('click', '.add-repeater-item', function () {
            let fieldHtml = '';

            if (mode === 'image') {
                // HTML PARA MODO IMAGEN
                fieldHtml = `
                    <label class="field-label">Nombre de la empresa</label>
                    <input type="text" class="title-field" placeholder="Nombre empresa">

                    <label class="field-label">Logo</label>
                    <div class="image-upload-controls">
                        <img src="" class="repeater-image-preview" style="display:none;" />
                        <input type="hidden" class="icon-field">
                        <button type="button" class="button upload-repeater-image">Seleccionar Imagen</button>
                    </div>

                    <label class="field-label">Sitio web (Opcional)</label>
                    <input type="text" class="url-field" placeholder="https://...">
                `;
            } else {
                // HTML PARA MODO ICONO
                fieldHtml = `
                    <label class="field-label">Título</label>
                    <input type="text" class="title-field" placeholder="Título">

                    <label class="field-label">Icono</label>
                    <select class="icon-select">${iconOptions}</select>
                    <input type="text" class="icon-field" placeholder="o escribe icono (fa-solid fa-x)">

                    <label class="field-label">Enlace</label>
                    <input type="text" class="url-field" placeholder="URL">
                `;
            }

            wrapper.find('._theme-repeater-list').append(`
                <li class="_theme-repeater-item">
                    ${fieldHtml}
                    <span class="drag-handle">☰</span>
                    <button type="button" class="button remove-social">Eliminar</button>
                </li>
            `);
            updateField(wrapper);
        });

        // ELIMINAR ELEMENTO
        wrapper.on('click', '.remove-social', function () {
            $(this).closest('._theme-repeater-item').remove();
            updateField(wrapper);
        });

        // LOGICA DE SELECT DE ICONOS (Solo modo icono)
        wrapper.on('change', '.icon-select', function () {
            $(this).closest('._theme-repeater-item')
                   .find('.icon-field')
                   .val($(this).val());
            updateField(wrapper);
        });

        // ACTUALIZAR AL ESCRIBIR
        wrapper.on('input', '.title-field, .icon-field, .url-field', function () {
            updateField(wrapper);
        });
    });

    // ==========================================
    // LOGICA DEL SUBIDOR DE IMÁGENES (GLOBAL)
    // ==========================================
    $('body').on('click', '.upload-repeater-image', function(e) {
        e.preventDefault();
        var button = $(this);
        var container = button.closest('.image-upload-controls');
        var input = container.find('.icon-field'); // Reutilizamos icon-field para guardar la URL
        var preview = container.find('.repeater-image-preview');

        // Si ya tenemos el objeto frame, ábrelo.
        var frame = wp.media({
            title: 'Seleccionar Logo',
            button: { text: 'Usar esta imagen' },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            input.val(attachment.url).trigger('input'); // Dispara evento input para guardar
            preview.attr('src', attachment.url).show();
            
            // Añadir botón de borrar si no existe
            if(container.find('.remove-repeater-image').length === 0) {
                container.append('<button type="button" class="button remove-repeater-image" style="color: #a00;">X</button>');
            }
        });

        frame.open();
    });

    // BOTÓN PARA QUITAR LA IMAGEN SELECCIONADA
    $('body').on('click', '.remove-repeater-image', function(e) {
        e.preventDefault();
        var container = $(this).closest('.image-upload-controls');
        container.find('.icon-field').val('').trigger('input');
        container.find('.repeater-image-preview').hide().attr('src', '');
        $(this).remove();
    });

});