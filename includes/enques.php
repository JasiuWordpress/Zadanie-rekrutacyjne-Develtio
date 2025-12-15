<?php


defined( 'ABSPATH' ) || exit;


add_action('wp_enqueue_scripts', 'dl_enqueue_bootstrap');

function dl_enqueue_bootstrap() {

    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [],
        '5.3.3'
    );


    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        [],
        '5.3.3',
        true
    );

    wp_enqueue_script(
        'event_register-js',
        plugin_dir_url(__FILE__) . 'assets/js/event-register.js',
        [],
        null,
        true
    );

    wp_localize_script('event_register-js', 'EventRegister', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('dl_register_nonce')
    ]);

}
