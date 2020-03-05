<?php
return [
    'api'             => env('MXTONG_API', 'http://61.143.63.169:8080/GateWay/Services.asmx/DirectSend'),
    'user_id'         => env('MXTONG_USER_ID', ''),
    'account'         => env('MXTONG_ACCOUNT', ''),
    'password'        => env('MXTONG_PASSWORD', ''),
    'send_type'       => 1,
    'post_fix_number' => 1,
];
