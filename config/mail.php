<?php

return [
    'mail' => [
        'from' => [
            'address' => getenv('MAIL_FROM_EMAIL'),
            'name'    => getenv('MAIL_FROM_NAME')
        ],
    ]
];