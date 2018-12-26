<?php

namespace Huangdijia\Mxtong;

class Mxtong
{
    private $config = [];
    private $apis   = [
        'send_sms'      => 'http://61.143.63.169:8080/GateWay/Services.asmx/DirectSend',
        'check_accinfo' => '',
    ];
    private $init = true;
    private $errno;
    private $error;

    public function __construct($config)
    {
        if (empty($config['user_id'])) {
            $this->error = "config mxtong.user_id is undefined";
            $this->errno = 101;
            $this->init  = false;
            
            return;
        }

        if (empty($config['account'])) {
            $this->error = "config mxtong.account is undefined";
            $this->errno = 101;
            $this->init  = false;
            
            return;
        }

        if (empty($config['password'])) {
            $this->error = "config mxtong.password is undefined";
            $this->errno = 102;
            $this->init  = false;
            
            return;
        }

        $this->config = $config;
    }

    public function send($mobile = '', $message = '')
    {
        if (!$this->init) {
            return false;
        }

        // 默认错误信息
        $this->error = null;
        $this->errno = null;

        if (!$this->checkMobile($mobile)) {
            return false;
        }

        if (!$this->checkMessage($message)) {
            return false;
        }
        $data = [
            'Phones'        => $mobile,
            'Content'       => $message,
            'SendTime'      => '',
            'UserId'        => $this->config['user_id'],
            'Account'       => $this->config['account'],
            'Password'      => $this->config['password'],
            'SendType'      => $this->config['send_type'] ?? 1,
            'PostFixNumber' => $this->config['post_fix_number'] ?? 1,
        ];

        $data     = http_build_query($data);
        $url      = $this->apis['send_sms'] ?? '';
        $response = Curl::Post($url, $data);

        if (false === $response) {
            $this->error = '請求失敗';
            $this->errno = 301;

            return false;
        }

        if ($response == '') {
            $this->error = '返回結果為空';
            $this->errno = 401;

            return false;
        }

        $XmlObj = false;

        try {
            $response = preg_replace('/<ROOT[^>]+>/', '<ROOT>', $response);
            $XmlObj   = simplexml_load_string($response);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            $this->errno = 402;

            return false;
        }

        if (false === $XmlObj || !is_object($XmlObj)) {
            $this->error = '返回結果解析錯誤';
            $this->errno = 402;

            return false;
        }

        if (!isset($XmlObj->RetCode) || $XmlObj->RetCode != 'Sucess') {
            $this->error = $XmlObj->Message;
            $this->errno = 402;

            return false;
        }

        if (isset($XmlObj->OKPhoneCounts) && 0 == $XmlObj->OKPhoneCounts) {
            $this->error = $XmlObj->Message;
            $this->errno = 403;

            return false;
        }

        return true;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getErrno()
    {
        return $this->errno;
    }

    private function checkMobile($mobile = '')
    {
        return preg_match('/^1\d{10}$/', $mobile);
    }

    private function checkMessage($message = '')
    {
        return !empty($message) ? true : false;
    }
}
