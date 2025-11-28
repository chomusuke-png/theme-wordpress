jQuery(document).ready(function ($) {

    // Comprueba si ThemeRepeaterData existe (definido por wp_localize_script)
    if (typeof ThemeRepeaterData === 'undefined') {
        return;
    }

    // Función principal para actualizar el campo oculto JSON
    function updateField(wrapper) {
        let items = [];

        // Estandarizado: Clase de elemento a ._theme-repeater-item
        wrapper.find('._theme-repeater-item').each(function () {
            items.push({
                title: $(this).find('.title-field').val(),
                icon: $(this).find('.icon-field').val(),
                url: $(this).find('.url-field').val()
            });
        });

        // Estandarizado: Clase del campo oculto a ._theme-repeater-hidden
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
    // Estandarizado: Clase del contenedor a ._theme-repeater-wrapper
    $('._theme-repeater-wrapper').each(function () {
        const wrapper = $(this);
        const wrapperId = wrapper.attr('class').split(' ').find(cls => cls.startsWith('_theme_')); // Obtiene el ID del setting (e.g., _theme_social_repeater)
        
        // Determina qué lista de iconos usar basado en el ID del repetidor
        let iconList = {};
        if (wrapperId === ThemeRepeaterData.social_id) {
            iconList = ThemeRepeaterData.social_icons;
        } else if (wrapperId === ThemeRepeaterData.related_id) {
            iconList = ThemeRepeaterData.related_icons;
        }

        const iconOptions = generateIconOptions(iconList);

        // Drag & Drop
        // Estandarizado: Clase de lista a ._theme-repeater-list
        wrapper.find('._theme-repeater-list').sortable({
            handle: '.drag-handle',
            update: function () {
                updateField(wrapper);
            }
        });

        // Añadir (el botón se llama .add-repeater-item en el PHP, no .add-social)
        wrapper.on('click', '.add-repeater-item', function () {
            wrapper.find('._theme-repeater-list').append(`
                <li class="_theme-repeater-item">
                    <input type="text" class="title-field" placeholder="Título del sitio">

                    <select class="icon-select">
                        ${iconOptions} 
                    </select>

                    <input type="text" class="icon-field" placeholder="o escribe icono (fa-solid fa-x)">
                    <input type="text" class="url-field" placeholder="URL">

                    <span class="drag-handle">☰</span>
                    <button type="button" class="button remove-social">Eliminar</button>
                </li>
            `);
            updateField(wrapper);
        });

        // Eliminar
        wrapper.on('click', '.remove-social', function () {
            $(this).closest('._theme-repeater-item').remove();
            updateField(wrapper);
        });

        // Select sincroniza con input (y actualiza)
        wrapper.on('change', '.icon-select', function () {
            $(this).closest('._theme-repeater-item')
                   .find('.icon-field')
                   .val($(this).val());
            updateField(wrapper);
        });

        // Input sincroniza con select (y actualiza)
        wrapper.on('input', '.title-field, .icon-field, .url-field', function () {
            // Nota: Aquí no se actualiza el select, solo el hidden field.
            updateField(wrapper);
        });
    });

});