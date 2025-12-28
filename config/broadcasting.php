<?php

return [

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    'connections' => [

       'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,

        // Other broadcasting connections like Redis can be added here if needed
    ],
    ]

];
