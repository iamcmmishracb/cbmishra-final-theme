<?php
// ============================================================
// ADMIN COLUMNS — Hire Submissions
// ============================================================
add_filter( 'manage_hire_submission_posts_columns', function( $cols ) {
    return [
        'cb'       => $cols['cb'],
        'title'    => 'Submitted',
        'name'     => 'Name',
        'email'    => 'Email',
        'company'  => 'Company',
        'phone'    => 'Phone',
        'service'  => 'Service',
        'budget'   => 'Budget',
        'timeline' => 'Timeline',
        'desc'     => 'Description',
        'date'     => 'Date',
    ];
});

add_action( 'manage_hire_submission_posts_custom_column', function( $col, $post_id ) {
    $map = [
        'name'     => '_hire_name',
        'email'    => '_hire_email',
        'company'  => '_hire_company',
        'phone'    => '_hire_phone',
        'service'  => '_hire_service',
        'budget'   => '_hire_budget',
        'timeline' => '_hire_timeline',
        'desc'     => '_hire_desc',
    ];
    if ( isset( $map[ $col ] ) ) {
        $val = get_post_meta( $post_id, $map[ $col ], true );
        if ( $col === 'email' && $val ) {
            echo '<a href="mailto:' . esc_attr( $val ) . '">' . esc_html( $val ) . '</a>';
        } elseif ( $col === 'desc' ) {
            echo esc_html( wp_trim_words( $val, 12, '...' ) );
        } else {
            echo esc_html( $val ?: '—' );
        }
    }
}, 10, 2 );

// Make hire submissions sortable/wider
add_filter( 'manage_hire_submission_posts_sortable_columns', function( $cols ) {
    $cols['name']  = 'name';
    $cols['email'] = 'email';
    return $cols;
});

// ============================================================
// ADMIN COLUMNS — Appointments
// ============================================================
add_filter( 'manage_appointment_posts_columns', function( $cols ) {
    return [
        'cb'      => $cols['cb'],
        'title'   => 'Appointment',
        'name'    => 'Name',
        'email'   => 'Email',
        'company' => 'Company',
        'date'    => 'Preferred Date',
        'time'    => 'Time (IST)',
        'topic'   => 'Topic',
        'desc'    => 'Notes',
        'date'    => 'Submitted',
    ];
});

add_action( 'manage_appointment_posts_custom_column', function( $col, $post_id ) {
    $map = [
        'name'    => '_appt_name',
        'email'   => '_appt_email',
        'company' => '_appt_company',
        'appt_date' => '_appt_date',
        'time'    => '_appt_time',
        'topic'   => '_appt_topic',
        'desc'    => '_appt_desc',
    ];
    if ( isset( $map[ $col ] ) ) {
        $val = get_post_meta( $post_id, $map[ $col ], true );
        if ( $col === 'email' && $val ) {
            echo '<a href="mailto:' . esc_attr( $val ) . '">' . esc_html( $val ) . '</a>';
        } elseif ( $col === 'desc' ) {
            echo esc_html( wp_trim_words( $val, 10, '...' ) );
        } else {
            echo esc_html( $val ?: '—' );
        }
    }
}, 10, 2 );

// ============================================================
// META BOX: Show full submission details on edit screen
// ============================================================
add_action( 'add_meta_boxes', function() {
    add_meta_box( 'hire_details', 'Submission Details', function( $post ) {
        $fields = [
            'Name'        => get_post_meta( $post->ID, '_hire_name',     true ),
            'Email'       => get_post_meta( $post->ID, '_hire_email',    true ),
            'Company'     => get_post_meta( $post->ID, '_hire_company',  true ),
            'Phone'       => get_post_meta( $post->ID, '_hire_phone',    true ),
            'Service'     => get_post_meta( $post->ID, '_hire_service',  true ),
            'Budget'      => get_post_meta( $post->ID, '_hire_budget',   true ),
            'Timeline'    => get_post_meta( $post->ID, '_hire_timeline', true ),
            'Description' => get_post_meta( $post->ID, '_hire_desc',     true ),
        ];
        echo '<table class="form-table">';
        foreach ( $fields as $label => $val ) {
            if ( ! $val ) continue;
            echo '<tr><th style="width:120px">' . esc_html( $label ) . '</th>';
            echo '<td>' . ( $label === 'Email'
                ? '<a href="mailto:' . esc_attr( $val ) . '">' . esc_html( $val ) . '</a>'
                : '<pre style="white-space:pre-wrap;margin:0;font-family:inherit;">' . esc_html( $val ) . '</pre>'
            ) . '</td></tr>';
        }
        echo '</table>';
    }, 'hire_submission', 'normal', 'high' );

    add_meta_box( 'appt_details', 'Appointment Details', function( $post ) {
        $fields = [
            'Name'     => get_post_meta( $post->ID, '_appt_name',    true ),
            'Email'    => get_post_meta( $post->ID, '_appt_email',   true ),
            'Company'  => get_post_meta( $post->ID, '_appt_company', true ),
            'Date'     => get_post_meta( $post->ID, '_appt_date',    true ),
            'Time'     => get_post_meta( $post->ID, '_appt_time',    true ),
            'Topic'    => get_post_meta( $post->ID, '_appt_topic',   true ),
            'Notes'    => get_post_meta( $post->ID, '_appt_desc',    true ),
        ];
        echo '<table class="form-table">';
        foreach ( $fields as $label => $val ) {
            if ( ! $val ) continue;
            echo '<tr><th style="width:100px">' . esc_html( $label ) . '</th>';
            echo '<td>' . ( $label === 'Email'
                ? '<a href="mailto:' . esc_attr( $val ) . '">' . esc_html( $val ) . '</a>'
                : '<pre style="white-space:pre-wrap;margin:0;font-family:inherit;">' . esc_html( $val ) . '</pre>'
            ) . '</td></tr>';
        }
        echo '</table>';
    }, 'appointment', 'normal', 'high' );
});
