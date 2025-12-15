<?php

defined( 'ABSPATH' ) || exit;

function dl_create_account_page() {
    $option_key = 'dl_account_page_id';
    $page_id    = (int) get_option($option_key);

    if ( $page_id && get_post_status($page_id) ) {
        return;
    }

    $existing = get_page_by_path('moje-konto', OBJECT, 'page');
    if ( $existing ) {
        update_option($option_key, (int) $existing->ID);
        return;
    }

    $new_id = wp_insert_post(array(
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'post_title'   => 'Moje konto',
        'post_name'    => 'moje-konto',
        'post_content' => '[dl_profil]',
    ));

    if ( ! is_wp_error($new_id) && $new_id > 0 ) {
        update_option($option_key, (int) $new_id);
    }
}



/* logowanie i rejestracja */


add_action('admin_post_nopriv_dl_login', 'dl_handle_login');
add_action('admin_post_dl_login',        'dl_handle_login');

function dl_handle_login() {
	if ( ! isset($_POST['dl_nonce']) || ! wp_verify_nonce($_POST['dl_nonce'], 'dl_login') ) {
		$redirect = esc_url_raw($_POST['redirect_to'] ?? home_url('/'));
		wp_safe_redirect( add_query_arg('dl_err', 'nonce', $redirect) );
		exit;
	}

	$login    = sanitize_text_field($_POST['dl_login'] ?? '');
	$password = (string) ($_POST['dl_password'] ?? '');
	$redirect = esc_url_raw($_POST['redirect_to'] ?? home_url('/'));

    /* zeby nie dalo sie tedy logowac na admina bo raczej slabo bezpieczne */
    $u = get_user_by('login',$login);
    if(user_can($u, 'manage_options')){
        wp_safe_redirect( add_query_arg('dl_err', 'login', $redirect) );
		exit;
    }
    /* koniec sprawdzani czy admin */

	$user = wp_signon([
		'user_login'    => $login,
		'user_password' => $password,
		'remember'      => true,
	], false);

	if ( is_wp_error($user) ) {
		wp_safe_redirect( add_query_arg('dl_err', 'login', $redirect) );
		exit;
	}

	wp_safe_redirect($redirect);
	exit;
}


add_action('admin_post_nopriv_dl_register', 'dl_handle_register');
add_action('admin_post_dl_register',        'dl_handle_register');

function dl_handle_register() {
	if ( ! isset($_POST['dl_nonce']) || ! wp_verify_nonce($_POST['dl_nonce'], 'dl_register') ) {
		$redirect = esc_url_raw($_POST['redirect_to'] ?? home_url('/'));
		wp_safe_redirect( add_query_arg('dl_err', 'nonce', $redirect) );
		exit;
	}

	$login    = sanitize_user($_POST['dl_login'] ?? '');
	$email    = sanitize_email($_POST['dl_email'] ?? '');
	$password = (string) ($_POST['dl_password'] ?? '');
	$redirect = esc_url_raw($_POST['redirect_to'] ?? home_url('/'));

	if ( $login === '' || $email === '' || $password === '' ) {
		wp_safe_redirect( add_query_arg('dl_err', 'required', $redirect) );
		exit;
	}

	if ( username_exists($login) || email_exists($email) ) {
		wp_safe_redirect( add_query_arg('dl_err', 'exists', $redirect) );
		exit;
	}

	$user_id = wp_create_user($login, $password, $email);
	if ( is_wp_error($user_id) ) {
		wp_safe_redirect( add_query_arg('dl_err', 'register', $redirect) );
		exit;
	}

	
	wp_set_current_user($user_id);
	wp_set_auth_cookie($user_id, true);

	wp_safe_redirect($redirect);
	exit;
}


/* logowanie i rejestracj END */



/* jak user ktory nie jest adminem chce wejsc na wp-admin to redirect na moje-konto */
add_action('admin_init', 'de_konto_usera');

function de_konto_usera(){


	//requesty (zapisanie tez przekierowywalo wiec wykluczenie)
	if ( wp_doing_ajax() || (defined('DOING_CRON') && DOING_CRON) ) {
        return;
    }

	if(is_admin()){ 

			if(is_user_logged_in() && !current_user_can('manage_options')){
				$redirect_url = get_permalink( get_page_by_path( 'moje-konto' ) );
				wp_redirect( $redirect_url );
				exit;
					
			}

		}	

}

/* Ukrywanie ,,paska administratora" dla nie adminow */
add_action('after_setup_theme', function() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
});
