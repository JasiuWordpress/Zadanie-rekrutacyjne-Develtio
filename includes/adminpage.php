<?php
add_action('admin_menu', 'event_manager_register_admin_page');

function event_manager_register_admin_page() {
    add_menu_page(
        'Event Manager',
        'Event Manager',
        'manage_options',
        'event-manager',
        'event_manager_admin_page',
        'dashicons-calendar-alt',
        20
    );
}

function event_manager_admin_page() {

    if (!current_user_can('manage_options')) {
        return;
    }

    echo '<div class="wrap">';
    echo '<h1>Event Manager</h1>';


    if (isset($_GET['event_id'])) {
        event_manager_show_event_entries((int) $_GET['event_id']);
    } else {
        event_manager_show_events_list();
    }

    echo '</div>';
}


function event_manager_show_events_list() {

    $events = get_posts([
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    if (!$events) {
        echo '<p>Brak wydarzeń.</p>';
        return;
    }

    echo '<table class="widefat fixed striped">';
    echo '<thead>
            <tr>
                <th>Tytuł</th>
                <th>Limit miejsc</th>
                <th>Zapisani</th>
                <th>Akcja</th>
            </tr>
          </thead><tbody>';

    foreach ($events as $event) {

        $limit = (int) get_post_meta($event->ID, 'limit_event', true);
        $registrations = get_post_meta($event->ID, 'event_registrations', true);

        if (!is_array($registrations)) {
            $registrations = [];
        }

        $count = count($registrations);

        $url = admin_url('admin.php?page=event-manager&event_id=' . $event->ID);

        echo '<tr>';
        echo '<td>' . esc_html($event->post_title) . '</td>';
        echo '<td>' . ($limit ?: '∞') . '</td>';
        echo '<td>' . $count . '</td>';
        echo '<td><a class="button" href="' . esc_url($url) . '">Zobacz zapisy</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}


function event_manager_show_event_entries($event_id) {

    $event = get_post($event_id);

    if (!$event || $event->post_type !== 'event') {
        echo '<p>Nieprawidłowe wydarzenie.</p>';
        return;
    }

    $registrations = get_post_meta($event_id, 'event_registrations', true);

    if (!is_array($registrations) || empty($registrations)) {
        echo '<p><strong>' . esc_html($event->post_title) . '</strong></p>';
        echo '<p>Brak zapisów.</p>';
        echo '<a href="' . admin_url('admin.php?page=event-manager') . '" class="button">← Wróć</a>';
        return;
    }

    echo '<h2>' . esc_html($event->post_title) . '</h2>';
    echo '<a href="' . admin_url('admin.php?page=event-manager') . '" class="button">← Wróć</a><br><br>';

    echo '<table class="widefat striped">';
    echo '<thead>
            <tr>
                <th>#</th>
                <th>Imię</th>
                <th>Email</th>
                <th>User ID</th>
                <th>Data</th>
            </tr>
          </thead><tbody>';

    foreach ($registrations as $index => $reg) {

        echo '<tr>';
        echo '<td>' . ($index + 1) . '</td>';
        echo '<td>' . esc_html($reg['name'] ?? '-') . '</td>';
        echo '<td>' . esc_html($reg['email'] ?? '-') . '</td>';

        $user_cell = '-';
        if (!empty($reg['user_id'])) {

            $user = get_user_by('id', (int) $reg['user_id']);

            if ($user) {
                $profile_url = admin_url('user-edit.php?user_id=' . $user->ID);
                $nickname    = $user->nickname ?: $user->user_login;

                $user_cell = '<a href="' . esc_url($profile_url) . '">'
                        . esc_html($nickname)
                        . '</a>';
            }
        }

        echo '<td>' . $user_cell . '</td>';

        echo '<td>' . esc_html($reg['time'] ?? '-') . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}
