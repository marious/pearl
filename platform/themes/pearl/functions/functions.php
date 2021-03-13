<?php

register_page_template([
    'homepage' => __('Homepage')
]);

add_shortcode('featured-doctors', 'Featured Doctors', 'Featured Doctors', function () {
    return Theme::partial('short-codes.featured-doctors');
});

add_shortcode('department-services', 'Department Services', 'Department Services', function () {
    return Theme::partial('short-codes.departments-services');
});

add_shortcode('appointment-form', 'Appointment Form', 'Appointment Form', function () {
    return Theme::partial('short-codes.appointment');
});

add_shortcode('say-about-us', 'Say About', 'Say About', function () {
    return Theme::partial('short-codes.testimonial');
});

add_shortcode('all-doctors', 'All Doctors', 'All Doctors', function () {
    return Theme::partial('short-codes.all-doctors');
});

theme_option()
    ->setField([
        'id'         => 'site_description',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Site description'),
        'attributes' => [
            'name'    => 'site_description',
            'value'   => __('Leaders Group Company'),
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 255,
            ],
        ],
    ])
    ->setField([
        'id'         => 'primary_font',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'googleFonts',
        'label'      => __('Primary font'),
        'attributes' => [
            'name'  => 'primary_font',
            'value' => 'Roboto',
        ],
    ])
    ->setField([
        'id'         => 'copyright',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Copyright'),
        'attributes' => [
            'name'    => 'copyright',
            'value'   => '© '.date('Y').' Leaders Group All Right Reserved.',
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => __('Change copyright'),
                'data-counter' => 250,
            ]
        ],
        'helper' => __('Copyright on footer of site'),
    ])
    ->setField([
        'id'         => 'phone_number',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Phone number'),
        'attributes' => [
            'name'    => 'phone_number',
            'value'   => '0123 456 789',
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setField([
        'id'         => 'contact_email',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'email',
        'label'      => __('Email'),
        'attributes' => [
            'name'    => 'contact_email',
            'value'   => 'test@gmail.com',
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setField([
        'id'         => 'address',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Address'),
        'attributes' => [
            'name'    => 'address',
            'value'   => __('Here will be the address'),
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 255,
            ],
        ],
    ])
    ->setSection([
        'title'      => __('Social'),
        'desc'       => __('Social links'),
        'id'         => 'opt-text-subsection-social',
        'subsection' => true,
        'icon'       => 'fa fa-share-alt',
    ])
    ->setField([
        'id'         => 'facebook',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Facebook',
        'attributes' => [
            'name'    => 'facebook',
            'value'   => null,
            'options' => [
                'class'       => 'form-control',
                'placeholder' => 'https://facebook.com/@username',
            ],
        ],
    ])
    ->setField([
        'id'         => 'twitter',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Twitter',
        'attributes' => [
            'name'    => 'twitter',
            'value'   => null,
            'options' => [
                'class'       => 'form-control',
                'placeholder' => 'https://twitter.com/@username',
            ],
        ],
    ])
    ->setField([
        'id'         => 'youtube',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Youtube',
        'attributes' => [
            'name'    => 'youtube',
            'value'   => null,
            'options' => [
                'class'       => 'form-control',
                'placeholder' => 'https://youtube.com/@channel-url',
            ],
        ],
    ]);

if (is_plugin_active('simple-slider')) {
    add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
        return Theme::getThemeNamespace() . '::partials.short-codes.sliders';
    }, 120);
}

if (is_plugin_active('counter')) {
    add_filter(COUNTER_VIEW_TEMPLATE, function () {
        return Theme::getThemeNamespace() . '::partials.short-codes.counter';
    }, 120);
}

add_action('init', function () {
    config(['filesystems.disks.public.root' => public_path('storage')]);
}, 124);
