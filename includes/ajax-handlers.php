<?php

defined( 'ABSPATH' ) || exit;

add_action('wp_ajax_dl_register_form', 'handle_register_event');
add_action('wp_ajax_nopriv_dl_register_form', 'handle_register_event');



function handle_register_event() {


    if (
        !isset($_POST['nonce']) ||
        !wp_verify_nonce($_POST['nonce'], 'dl_register_nonce')
    ) {
        wp_send_json_error('Nieprawidłowy token bezpieczeństwa.');
    }


    if (!is_user_logged_in()) {
        wp_send_json_error('Użytkownik nie jest zalogowany.');
    }

    $user_id = get_current_user_id();


    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';


    if (empty($post_id) || empty($name) || empty($email) || !is_email($email)) {
        wp_send_json_error('Nieprawidłowe dane formularza.');
    }


    if(!get_post($post_id)){
         wp_send_json_error('Event nie istnieje');
    }


    




    $registrations = get_post_meta($post_id, 'event_registrations', true);
    if (!is_array($registrations)) {
        $registrations = [];
    }


    foreach ($registrations as $reg) {
        if (isset($reg['user_id']) && intval($reg['user_id']) === $user_id) {
            wp_send_json_error('Jesteś już zapisany na to wydarzenie.');
        }
    }

    $limit = get_field('limit_event', $post_id);

   if ( count($registrations) >= $limit ) {
    wp_send_json_error('Nie ma już miejsc');
    }    


    $registrations[] = [
        'name'    => $name,
        'email'   => $email,
        'user_id' => $user_id,
    ];

    update_post_meta($post_id, 'event_registrations', $registrations);

    wp_send_json_success([
        'message' => 'Zapisano pomyślnie!',
        'count'   => count($registrations),
    ]);
}
