<?php

// Registrar menús
function tema_menus() {
    register_nav_menus([
        'main_menu' => __('Menú Principal', 'mi-tema'),
    ]);
}
add_action('after_setup_theme', 'tema_menus');


// Cargar Widget de Header y Footer
function mi_tema_registrar_widgets() {
    register_sidebar(array(
        'name'          => __('Header Widget', 'mi-tema'),
        'id'            => 'header-widget',
        'description'   => __('Widget para el logo y menú en el header.', 'mi-tema'),
        'before_widget' => '<div class="widget-header %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget', 'mi-tema'),
        'id'            => 'footer-widget',
        'description'   => __('Widget para email, teléfono y redes sociales en el footer.', 'mi-tema'),
        'before_widget' => '<div class="widget-footer %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'mi_tema_registrar_widgets');



// Cargar todos los templates
function registrar_plantillas_personalizadas($templates) {
    $ruta_templates = get_template_directory() . '/templates/';

    foreach (glob($ruta_templates . '*.php') as $archivo) {
        $nombre_archivo = basename($archivo, '.php'); // Obtiene el nombre sin extensión
        
        // Genera un nombre a partir del nombre del archivo
        $nombre_plantilla = ucwords(str_replace('_', ' ', $nombre_archivo));

        // Registrar plantilla en WordPress
        $templates['templates/' . $nombre_archivo . '.php'] = $nombre_plantilla;
    }

    return $templates;
}
add_filter('theme_page_templates', 'registrar_plantillas_personalizadas');


function cargar_plantillas_personalizadas($template) {
     // Verificar si es un post del tipo 'service'
    if (is_singular('service')) {
        $template_seleccionado = get_post_meta(get_the_ID(), '_servicio_template', true);

        if ($template_seleccionado && file_exists(get_template_directory() . '/' . $template_seleccionado)) {
            return get_template_directory() . '/' . $template_seleccionado;
        }
    } else if (is_page()) {
        $template_seleccionado = get_page_template_slug();
        
        if ($template_seleccionado && file_exists(get_template_directory() . '/' . $template_seleccionado)) {
            return get_template_directory() . '/' . $template_seleccionado;
        }
    }

    return $template;
}
add_filter('template_include', 'cargar_plantillas_personalizadas');







// Logica de servicios
function registrar_post_type_service() {
    $labels = array(
        'name'               => 'Services',
        'singular_name'      => 'Service',
        'menu_name'          => 'Services',
        'name_admin_bar'     => 'Service',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Service',
        'new_item'           => 'New Service',
        'edit_item'          => 'Edit Service',
        'view_item'          => 'View Service',
        'all_items'          => 'All Services',
        'search_items'       => 'Search Services',
        'not_found'          => 'No services found',
        'not_found_in_trash' => 'No services found in trash',
    );


    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'service'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('service', $args);
}
add_action('init', 'registrar_post_type_service');


/* Agregar una nueva columna de services order */
// Agregar la columna "Service Order" en la lista de servicios
function agregar_columna_service_order($columns) {
    $columns['services_orden'] = 'Service Order';
    return $columns;
}
// Agregar ancho a la columna "Service Order" en el listado
function agregar_estilos_columnas_admin() {
    echo '<style>
        .fixed  .column-services_orden { width: 14% !important; }
    </style>';
}
add_action('admin_head', 'agregar_estilos_columnas_admin');
add_filter('manage_service_posts_columns', 'agregar_columna_service_order');
// Mostrar el contenido de la columna "Service Order"
function mostrar_columna_service_order($column, $post_id) {
    if ($column === 'services_orden') {
        $orden = get_post_meta($post_id, '_servicio_orden', true);
        echo esc_html($orden ? $orden : '0'); // Muestra 0 si no tiene orden asignado
    }
}
add_action('manage_service_posts_custom_column', 'mostrar_columna_service_order', 10, 2);
// Hacer que la columna "Service Order" sea ordenable
function hacer_columna_service_order_ordenable($columns) {
    $columns['services_orden'] = 'services_orden';
    return $columns;
}
add_filter('manage_edit-service_sortable_columns', 'hacer_columna_service_order_ordenable');




/* Configurar la logica adicionales */
function agregar_metabox_servicio_configuracion() {
    add_meta_box(
        'servicio_configuracion',
        'Service Configuration',
        'mostrar_metabox_servicio_configuracion',
        'service',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'agregar_metabox_servicio_configuracion');
function mostrar_metabox_servicio_configuracion($post) {
    $mostrar_en_servicios = get_post_meta($post->ID, '_servicio_mostrar_en_servicios', true);
    $banner_activado = get_post_meta($post->ID, '_servicio_banner_activado', true);
    $imagen_banner = get_post_meta($post->ID, '_servicio_banner', true);
    $imagen_post = get_post_meta($post->ID, '_servicio_imagen_post', true);
    $plantilla_actual = get_post_meta($post->ID, '_servicio_template', true);
    $orden_servicio = get_post_meta($post->ID, '_servicio_orden', true);

    if ($orden_servicio === '') {
        $orden_servicio = 0; // Valor por defecto
    }

    wp_nonce_field('guardar_configuracion_servicio', 'servicio_nonce');
    ?>
    <p>
        <label>
            <input type="checkbox" name="servicio_mostrar_en_servicios" value="1" <?php checked($mostrar_en_servicios, 1); ?>>
            Show in Services
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" id="activar_banner" name="servicio_banner_activado" value="1" <?php checked($banner_activado, 1); ?>>
            Add Banner
        </label>
    </p>

    <p id="banner_selector" style="display: <?php echo $banner_activado ? 'block' : 'none'; ?>;">
        <label for="servicio_banner">Banner Image:</label><br>
        <input type="hidden" name="servicio_banner" id="servicio_banner" value="<?php echo esc_attr($imagen_banner); ?>">
        <button class="button servicio_subir_banner">Select Image</button>
        <br>
        <img id="preview_banner" src="<?php echo esc_url($imagen_banner); ?>" style="max-width: 100%; margin-top: 10px; <?php echo empty($imagen_banner) ? 'display:none;' : ''; ?>">
    </p>

    <p>
        <label for="servicio_imagen_post">Featured Service Image:</label><br>
        <input type="hidden" name="servicio_imagen_post" id="servicio_imagen_post" value="<?php echo esc_attr($imagen_post); ?>">
        <button class="button servicio_subir_imagen_post">Select Image</button>
        <br>
        <img id="preview_imagen_post" src="<?php echo esc_url($imagen_post); ?>" style="max-width: 100px; margin-top: 10px; <?php echo empty($imagen_post) ? 'display:none;' : ''; ?>">
    </p>

    <p>
        <label for="plantilla_servicio">Service Template:</label><br>
        <?php
        $templates = array(); 
        $plantillas_disponibles = registrar_plantillas_personalizadas($templates);
        ?>
        <select name="plantilla_servicio" id="plantilla_servicio">
            <option value="">Default Template</option>
            <?php foreach ($plantillas_disponibles as $archivo => $nombre) : ?>
                <option value="<?php echo esc_attr($archivo); ?>" <?php selected($plantilla_actual, $archivo); ?>><?php echo esc_html($nombre); ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="servicio_orden">Service Order:</label><br>
        <input type="number" name="servicio_orden" id="servicio_orden" value="<?php echo esc_attr($orden_servicio); ?>" min="0" style="width: 100px;">
    </p>

    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;

            $('#activar_banner').change(function() {
                if($(this).is(':checked')) {
                    $('#banner_selector').show();
                } else {
                    $('#banner_selector').hide();
                    $('#servicio_banner').val('');
                    $('#preview_banner').hide();
                }
            });

            $('.servicio_subir_banner').click(function(e) {
                e.preventDefault();
                mediaUploader = wp.media({
                    title: 'Select Banner Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#servicio_banner').val(attachment.url);
                    $('#preview_banner').attr('src', attachment.url).show();
                });
                mediaUploader.open();
            });

            $('.servicio_subir_imagen_post').click(function(e) {
                e.preventDefault();
                mediaUploader = wp.media({
                    title: 'Select Featured Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#servicio_imagen_post').val(attachment.url);
                    $('#preview_imagen_post').attr('src', attachment.url).show();
                });
                mediaUploader.open();
            });
        });
    </script>
    <?php
}
function agregar_metabox_servicio_galeria() {
    add_meta_box(
        'servicio_galeria',
        'Image Gallery',
        'mostrar_metabox_servicio_galeria',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'agregar_metabox_servicio_galeria');
function mostrar_metabox_servicio_galeria($post) {
    wp_enqueue_media(); // Cargar la biblioteca de medios

    $galeria_ids = get_post_meta($post->ID, '_servicio_galeria_ids', true) ?: [];

    ?>
    <p>
        <button class="button servicio_subir_galeria">Add to Gallery</button>
    </p>
    <div id="galeria_preview">
        <?php
        if (!empty($galeria_ids)) {
            foreach ($galeria_ids as $id) {
                echo '<div class="galeria_item" data-id="' . esc_attr($id) . '">';
                echo wp_get_attachment_image($id, 'thumbnail');
                echo '<button class="button remove_image" data-id="' . esc_attr($id) . '">X</button>';
                echo '</div>';
            }
        }
        ?>
    </div>
    <input type="hidden" name="servicio_galeria_ids" id="servicio_galeria_ids" value="<?php echo esc_attr(implode(',', $galeria_ids)); ?>">

    <script>
        jQuery(document).ready(function($) {
            var frame;

            $('.servicio_subir_galeria').on('click', function(e) {
                e.preventDefault();

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: 'Select Gallery Images',
                    button: { text: 'Add to Gallery' },
                    multiple: true
                });

                frame.on('select', function() {
                    var selection = frame.state().get('selection');
                    var ids = $('#servicio_galeria_ids').val().split(',').filter(Boolean); // Obtener los IDs existentes
                    selection.map(function(attachment) {
                        attachment = attachment.toJSON();
                        ids.push(attachment.id); // Agregar el nuevo ID
                        $('#galeria_preview').append('<div class="galeria_item"><img src="' + attachment.sizes.thumbnail.url + '" /><button class="button remove_image" data-id="' + attachment.id + '">X</button></div>');
                    });
                    $('#servicio_galeria_ids').val(ids.join(',')); // Actualizar el campo oculto
                });

                frame.open();
            });

            $('#galeria_preview').on('click', '.remove_image', function() {
                var idToRemove = $(this).data('id');
                var ids = $('#servicio_galeria_ids').val().split(',').filter(Boolean);
                ids = ids.filter(function(id) {
                    return id != idToRemove;
                });
                $('#servicio_galeria_ids').val(ids.join(','));
                $(this).parent().remove();
            });

            // Hacer sortable la galería
            $('#galeria_preview').sortable({
                items: '.galeria_item',
                cursor: 'move',
                update: function(event, ui) {
                    let nuevosIds = [];
                    $('#galeria_preview .galeria_item').each(function() {
                        nuevosIds.push($(this).data('id'));
                    });
                    $('#servicio_galeria_ids').val(nuevosIds.join(','));
                }
            });

        });
    </script>
    <style>
        #galeria_preview .galeria_item {
            border: 1px solid #ccc;
            padding: 5px;
            background: #f9f9f9;
            position: relative;
            margin: 5px; 
            cursor: move;
            display: inline-grid;
        }

        #galeria_preview .galeria_item .remove_image {
            position: absolute;
            top: 2px;
            right: 2px;
            z-index: 10;
        }
    </style>

    <?php
}
function cargar_sortable_para_servicio($hook) {
    global $post;

    if ($hook === 'post.php' || $hook === 'post-new.php') {
        if ($post && $post->post_type === 'service') {
            wp_enqueue_script('jquery-ui-sortable');
        }
    }
}
add_action('admin_enqueue_scripts', 'cargar_sortable_para_servicio');

/* Guardar en los el servicio*/
function guardar_configuracion_servicio($post_id) {
    if (!isset($_POST['servicio_nonce']) || !wp_verify_nonce($_POST['servicio_nonce'], 'guardar_configuracion_servicio')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, '_servicio_mostrar_en_servicios', isset($_POST['servicio_mostrar_en_servicios']) ? 1 : 0);
    update_post_meta($post_id, '_servicio_banner_activado', isset($_POST['servicio_banner_activado']) ? 1 : 0);
    update_post_meta($post_id, '_servicio_banner', isset($_POST['servicio_banner']) ? $_POST['servicio_banner'] : '');
    update_post_meta($post_id, '_servicio_imagen_post', isset($_POST['servicio_imagen_post']) ? $_POST['servicio_imagen_post'] : '');
    update_post_meta($post_id, '_servicio_galeria_ids', array_filter(explode(',', (isset($_POST['servicio_galeria_ids']) ? $_POST['servicio_galeria_ids'] : ''))));
    update_post_meta($post_id, '_servicio_template', sanitize_text_field($_POST['plantilla_servicio']));
    update_post_meta($post_id, '_servicio_orden', (isset($_POST['servicio_orden']) && $_POST['servicio_orden'] !== '' ? intval($_POST['servicio_orden']) : 0));
}
add_action('save_post', 'guardar_configuracion_servicio');
