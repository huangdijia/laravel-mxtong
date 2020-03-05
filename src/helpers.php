<?php
if (!function_exists('mxtong')) {
    function mxtong()
    {
        return app('sms.mxtong');
    }
}

if (!function_exists('mxtong_send')) {
    function mxtong_send($mobile = '', $message = '')
    {
        return app('sms.mxtong')->send($mobile, $message);
    }
}
