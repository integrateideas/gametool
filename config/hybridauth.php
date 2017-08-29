<?php

use Cake\Core\Configure;

return [
    'HybridAuth' => [
        'providers' => [
            'Facebook' => [
                'enabled' => true,
                'keys' => [
                    'id' => '1834569253520164',
                    'secret' => '2a174781bb06e0096f6c3aa0b8edc9f0'
                ],
                'scope' => 'email, user_about_me, user_birthday, user_hometown'
            ]
        ],
        'debug_mode' => Configure::read('debug'),
        'debug_file' => LOGS . 'hybridauth.log',
    ]
];

?>