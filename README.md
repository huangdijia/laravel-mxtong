# SMS gateway for Mxtong

[![Latest Stable Version](https://poser.pugx.org/huangdijia/laravel-mxtong/version.png)](https://packagist.org/packages/huangdijia/laravel-mxtong)
[![Total Downloads](https://poser.pugx.org/huangdijia/laravel-mxtong/d/total.png)](https://packagist.org/packages/huangdijia/laravel-mxtong)

## Requirements

* PHP >= 7.0
* Laravel >= 5.5

## Installation

First, install laravel 5.5, and make sure that the database connection settings are correct.

~~~bash
composer require huangdijia/laravel-mxtong
~~~

Then run these commands to publish config

~~~bash
php artisan vendor:publish --provider="Huangdijia\Mxtong\MxtongServiceProvider"
~~~

## Configurations

~~~php
// config/mxtong.php
    'user_id'  => 'your user_id',
    'account'  => 'your account',
    'password' => 'your password',
~~~

## Usage

### As Facade

~~~php
use Huangdijia\Mxtong\Facades\Mxtong;

...

if (!Mxtong::send('mobile', 'some message')) {
    echo Mxtong::getError();
    echo Mxtong::getErrno();
} else {
    echo "send success";
}

~~~

### As Command

~~~bash
php artisan mxtong:send 'mobile' 'some message'
# send success
# or
# error
~~~

### As Helper

~~~php
if (!mxtong()->send('mobile', 'some message')) {
    echo mxtong()->getError();
    echo mxtong()->getErrno();
} else {
    echo "send success";
}
if (!$error = mxtong_send('mobile', 'some message')) {
    echo $error;
} else {
    echo "send success";
}
~~~

## Other

> * http://www.mxtong.net.cn/

## License

laravel-mxtong is licensed under The MIT License (MIT).