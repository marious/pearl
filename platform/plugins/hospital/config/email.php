<?php

return [
    'name'        => 'plugins/contact::contact.settings.email.title',
    'description' => 'plugins/contact::contact.settings.email.description',
    'templates'   => [
        'notice' => [
            'title'       => 'plugins/contact::contact.settings.email.templates.notice_title',
            'description' => 'plugins/contact::contact.settings.email.templates.notice_description',
            'subject'     => 'New contact from {{ site_title }}',
            'can_off'     => true,
        ],
    ],
    'variables'   => [
        'appointment_name'    => 'الاسم',
        'appointment_department' => 'القسم',
        'appointment_email'   => 'البريد الالكترونى',
        'appointment_phone'   => 'رقم الهاتف',
        'appointment_message' => 'الرسالة',
    ],
];
