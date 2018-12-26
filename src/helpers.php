<?php
if (!function_exists('mitake')) {
    function mitake()
    {
        return app('sms.mitake');
    }
}

if (!function_exists('mitake_send')) {
    function mitake_send($mobile = '', $message = '')
    {
        return app('sms.mitake')->send($mobile, $message) ?: app('sms.mitake')->getError();
    }
}