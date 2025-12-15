<?php


defined( 'ABSPATH' ) || exit;

//Aktywacja cpt i taxonomii
add_action( 'init', 'dl_register_events_cpt_and_taxonomy' );

function dl_register_events_cpt_and_taxonomy() {

	register_post_type( 'event', [
		'labels' => [
			'name' => 'Wydarzenia',
			'singular_name' => 'Wydarzenie',
		],
		'public' => true,
		'show_in_rest' => true,
		'supports' => ['title', 'thumbnail'],
		'has_archive' => 'wydarzenia',  
		'rewrite' => [
			'slug' => 'wydarzenia',
		],
	] );

	register_taxonomy( 'city', ['event'], [
		'labels' => [
			'name' => 'Miasta',
			'singular_name' => 'Miasto',
		],
		'public' => true,
		'hierarchical' => false,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'rewrite' => [
			'slug' => 'miasto',
		],
	] );
}




//Tutaj zeby permalinki dzialaly odrazu
register_activation_hook( __FILE__, 'dl_flush' );

function dl_flush() {
    dl_register_events_cpt_and_taxonomy();
    flush_rewrite_rules();

}


/* template */


//single
add_filter('template_include', 'de_single_event_template', 99);

function de_single_event_template($template) {

    if (is_singular('event')) {
        $theme_template = locate_template('single-event.php');
        if ($theme_template) {
            return $theme_template;
        }

        $plugin_template = plugin_dir_path( __DIR__ ) . 'templates/single-event.php';
		if($plugin_template){
			return $plugin_template;
		}
		
    }

    return $template;
}



//archive
add_filter('template_include', 'de_archive_event_template', 99);

function de_archive_event_template($template) {

    if (is_post_type_archive('event')) {
        $theme_template = locate_template('archive-event.php');
        if ($theme_template) {
            return $theme_template;
        }

        $plugin_template = plugin_dir_path( __DIR__ ) . 'templates/archive-event.php';
		if($plugin_template){
			return $plugin_template;
		}
		
    }

    return $template;
}

