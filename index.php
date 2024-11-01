<?php

/**
 * Plugin Name: Simplify Post Taxonomy
 * Plugin URI: http://souravmondal.co.in
 * Description: Create custom post type and custom taxonomy with plugin.
 * Version: 2.0.0
 * Author: Sourav Mondal
 * Author URI: http://souravmondal.co.in
 * Tags: custom post type creator,custom taxonomy creator,custom post type plugin,custom posts,custom taxonomy,post plugin
 * License: GPL2
 */
/** defining globals   */
define('CUSTOMPOST_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CUSTOMPOST_PLUGIN_URI', plugin_dir_path(__FILE__));

/*  loading scripts and styles */

function load_assets_custompost() {
    wp_enqueue_style('custompost_style', CUSTOMPOST_PLUGIN_URL . 'custompost-style.css');
    wp_enqueue_script('custompost_js_application', CUSTOMPOST_PLUGIN_URL . 'custompost-application.js', array('jquery'), "1.0.0", TRUE);
}

add_action('admin_enqueue_scripts', 'load_assets_custompost');

/* creating necessary tables in database */
add_action("init", "add_create_tables");

function add_create_tables() {
    global $wpdb;
    $sql_post_table = "CREATE TABLE 
            IF NOT EXISTS " . $wpdb->prefix . "custom_post_types (
            id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            name varchar(100),
            label varchar(150),
            description varchar(250),
            hierarchical varchar(10)
        )";
    $wpdb->query($sql_post_table);
    $sql_taxonomy_table = "CREATE TABLE 
            IF NOT EXISTS " . $wpdb->prefix . "custom_taxonomy_types (
            id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            slug varchar(100),
            label varchar(150),
            hierarchical varchar(10),
            post_type varchar(50)
        )";
    $wpdb->query($sql_taxonomy_table);
    wp_reset_query();
    $wpdb->flush();
}

/** adding admin menu page */
add_action('admin_menu', 'custom_post_menu_page');

function custom_post_menu_page() {
    add_menu_page('Custom Posts', 'Custom Posts', 'manage_options', CUSTOMPOST_PLUGIN_URI . 'admin-interface-custompost.php', '', CUSTOMPOST_PLUGIN_URL . 'icon.png', 6);
}

require_once CUSTOMPOST_PLUGIN_URI.'executes-posts-taxonomy.php';
