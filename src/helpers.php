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

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string  $name
     * @return string
     */
    function config_path($name = '')
    {
        if (is_callable(app(), 'getConfigurationPath')) {
            return app()->getConfigurationPath($name);
        } elseif (app()->has('path.config')) {
            return app()->make('path.config') . ($name ? DIRECTORY_SEPARATOR . $name : $name);
        } else {
            return app()->make('path') . '/../config' . ($name ? DIRECTORY_SEPARATOR . $name : $name);
        }
    }
}
