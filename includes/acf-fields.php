<?php

defined( 'ABSPATH' ) || exit;


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'events_group',
    'title' => 'Pola wydarzeń',
    'fields' => array (
          array (
            'key' => 'field_data_event',
            'label' => 'Data wydarzenia',
            'name' => 'data_event',
            'type' => 'date_time_picker',
        ),
        array (
            'key' => 'field_limit_event',
            'label' => 'Limit uczestników',
            'name' => 'limit_event',
            'type' => 'number',
        ),
        array (
            'key' => 'field_opis_event',
            'label' => 'Opis/Szczegóły',
            'name' => 'opis_event',
            'type' => 'textarea',
        )
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'event',
            ),
        ),
    ),
));

endif;