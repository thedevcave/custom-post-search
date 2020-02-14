<?php
/**
 * Properties Plugin Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @package PropertiesPlugin\Functions
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get template part.
 *
 * @param mixed  $slug Template slug.
 * @param string $name Template name (default: '').
 */
function prop_get_template_part( $slug, $name = '' ) {
    $cache_key = sanitize_key( implode( '-', array( 'template-part', $slug, $name ) ) );
    $template  = (string) wp_cache_get( $cache_key, 'properties' );

    if ( ! $template ) {
        if ( $name ) {
            $template = locate_template(
                array(
                    "{$slug}-{$name}.php",
                    "properties/{$slug}-{$name}.php",
                )
            );

            if ( ! $template ) {
                $fallback = PROP_PLUGIN_ABSPATH . "/templates/{$slug}-{$name}.php";
                $template = file_exists( $fallback ) ? $fallback : '';
            }
        }

        if ( ! $template ) {
            // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php.
            $template = locate_template(
                array(
                    "{$slug}.php",
                    PROP_PLUGIN_ABSPATH . "/templates/{$slug}.php",
                )
            );
        }

        wp_cache_set( $cache_key, $template, 'properties' );
    }

    // Allow 3rd party plugins to filter template file from their plugin.
    $template = apply_filters( 'prop_get_template_part', $template, $slug, $name );

    if ( $template ) {
        load_template( $template, false );
    }
}

/**
 * Get other templates (e.g. home attributes) passing attributes and including the file.
 *
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 */
function prop_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    $cache_key = sanitize_key( implode( '-', array( 'template', $template_name, $template_path, $default_path ) ) );
    $template  = (string) wp_cache_get( $cache_key, 'woocommerce' );

    if ( ! $template ) {
        $template = prop_locate_template( $template_name, $template_path, $default_path );
        wp_cache_set( $cache_key, $template, 'woocommerce' );
    }

    // Allow 3rd party plugin filter template file from their plugin.
    $filter_template = apply_filters( 'prop_get_template', $template, $template_name, $args, $template_path, $default_path );

    if ( $filter_template !== $template ) {
        if ( ! file_exists( $filter_template ) ) {
            /* translators: %s template */
            prop_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'woocommerce' ), '<code>' . $template . '</code>' ), '2.1' );
            return;
        }
        $template = $filter_template;
    }

    $action_args = array(
        'template_name' => $template_name,
        'template_path' => $template_path,
        'located'       => $template,
        'args'          => $args,
    );

    if ( ! empty( $args ) && is_array( $args ) ) {
        if ( isset( $args['action_args'] ) ) {
            prop_doing_it_wrong(
                __FUNCTION__,
                __( 'action_args should not be overwritten when calling prop_get_template.', 'woocommerce' ),
                '3.6.0'
            );
            unset( $args['action_args'] );
        }
        extract( $args ); // @codingStandardsIgnoreLine
    }

    do_action( 'prop_before_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );

    include $action_args['located'];

    do_action( 'prop_after_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );
}

/**
 * Like prop_get_template, but returns the HTML instead of outputting.
 *
 * @see prop_get_template
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 *
 * @return string
 */
function prop_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    ob_start();
    prop_get_template( $template_name, $args, $template_path, $default_path );
    return ob_get_clean();
}
/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @param string $template_name Template name.
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 * @return string
 */
function prop_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    if ( ! $template_path ) {
        $template_path = "properties/";
    }

    if ( ! $default_path ) {
        $default_path = PROP_PLUGIN_ABSPATH . '/templates/';
    }

    // Look within passed path within the theme - this is priority.
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name,
        )
    );

    // Get default template/.
    if ( ! $template ) {
        $template = $default_path . $template_name;
    }

    // Return what we found.
    return apply_filters( 'prop_locate_template', $template, $template_name, $template_path );
}