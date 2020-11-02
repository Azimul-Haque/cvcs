<?php

return [
    'store_id' => 'cvcsbd',
    'signature_key' => '4cde6ff3e7816ac461447af66baca194',
    'sandbox' => false,
    'redirect_url' => [
        'success' => [
            'route' => 'payment.success'
        ],
        'cancel' => [
            'route' => 'payment.cancel'
        ]
    ]
];
