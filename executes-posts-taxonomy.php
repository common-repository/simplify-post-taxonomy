<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//creating post types
function create_custom_posttype() {
    /** defining wp global */
    global $wpdb;
    /** getting the list of registered post types from database */
    $sql_get_all_post_types = "SELECT * FROM " . $wpdb->prefix . "custom_post_types";
    $all_post_types = $wpdb->get_results($sql_get_all_post_types);
    if ($wpdb->num_rows > 0) {
        foreach ($all_post_types as $single_post_type) {
            $post_type_name = $single_post_type->name;
            register_post_type($post_type_name, array(
                'label' => $single_post_type->label,
                'description' => $single_post_type->description,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'hierarchical' => $single_post_type->hierarchical,
                'rewrite' => array('slug' => $post_type_name),
                'query_var' => true,
                'menu_position' => $single_post_type->menu_position,
                'supports' => array('title', 'editor', 'thumbnail'),
                'labels' => array(
                    'name' => $post_type_name,
                    'singular_name' => $post_type_name,
                    'menu_name' => $post_type_name,
                    'add_new' => 'Add ' . $post_type_name,
                    'add_new_item' => 'Add New ' . $post_type_name,
                    'edit' => 'Edit',
                    'edit_item' => 'Edit ' . $post_type_name,
                    'new_item' => 'New ' . $post_type_name,
                    'view' => 'View ' . $post_type_name,
                    'view_item' => 'View ' . $post_type_name,
                    'search_items' => 'Search ' . $post_type_name,
                    'not_found' => 'No ' . $post_type_name . ' Found',
                    'not_found_in_trash' => 'No ' . $post_type_name . ' Found in Trash',
                    'parent' => 'Parent ' . $post_type_name,
                ),
                    )
            );
        }
    }
}

/* calling the register custom post type function with action hook */
add_action('init', 'create_custom_posttype');

//registering taxonomies

function register_custom_taxonomy() {
    /** defining wp global */
    global $wpdb;
    /** getting the list of registered post types from database */
    $sql_get_all_taxonomy_types = "SELECT * FROM " . $wpdb->prefix . "custom_taxonomy_types";
    $all_taxonomy_types = $wpdb->get_results($sql_get_all_taxonomy_types);
    if ($wpdb->num_rows > 0) {
        foreach ($all_taxonomy_types as $single_taxonomy_type) {
            register_taxonomy($single_taxonomy_type->slug, $single_taxonomy_type->post_type, array(
                "hierarchical" => $single_taxonomy_type->hierarchical,
                "label" => $single_taxonomy_type->label,
                "singular_label" => $single_taxonomy_type->label,
                "public" => true,
                "rewrite" => array('slug' => $single_taxonomy_type->slug)
                    )
            );
        }
    }
}

/* calling the register custom taxonomy function with action hook */
add_action('init', 'register_custom_taxonomy');