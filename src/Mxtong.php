<?php

namespace Huangdijia\Mxtong;

use Exception;
use Illuminate\Support\Facades\Http;

class Mxtong
{
    private $config = [];

    /**
     * Construct
     * @param array $config
     * @return void
     * @throws Exception
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        // fix
        if (!empty($this->config['api'])) {
            $this->config['api'] = 'http://61.143.63.169:8080/GateWay/Services.asmx/DirectSend';
        }
    }

    /**
     * Send
     * @param string $mobile
     * @param string $message
     * @return bool
     */
    public function send($mobile = '', $message = '')
    {
        throw_if(empty($this->config['user_id']), new Exception("Config 'mxtong.user_id' is undefined", 101));

        throw_if(empty($this->config['account']), new Exception("Config 'mxtong.account' is undefined", 102));

        throw_if(empty($this->config['password']), new Exception("Config 'mxtong.password' is undefined", 103));

        throw_if(!$this->checkMobile($mobile), new Exception("mobile is error", 1));

        throw_if(!$this->checkMessage($message), new Exception("message is error", 1));

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

        $response = Http::retries(3, 100)
            ->post($this->config['api'], $data)
            ->throw();

        if ($response->body() == '') {
            throw new Exception("Response body is empty!", 401);
        }

        $XmlObj = false;

        try {
            $response = preg_replace('/<ROOT[^>]+>/', '<ROOT>', $response->body());
            $XmlObj   = simplexml_load_string($response);
        } catch (Exception $e) {
            throw new Exception('Parse xml error:' . $e->getMessage(), 402);
        }

        throw_if(false === $XmlObj || !is_object($XmlObj),
            new Exception('Parse xml failed:' . $e->getMessage(), 402)
        );

        throw_if(!isset($XmlObj->RetCode) || $XmlObj->RetCode != 'Sucess',
            new Exception('Sended failed:' . $XmlObj->Message, 402)
        );

        throw_if(isset($XmlObj->OKPhoneCounts) && 0 == $XmlObj->OKPhoneCounts,
            new Exception('Sended all failed:' . $XmlObj->Message, 403)
        );

        return true;
    }

    /**
     * Check mobile
     * @param string $mobile
     * @return bool
     */
    private function checkMobile($mobile = '')
    {
        return preg_match('/^1\d{10}$/', $mobile) ? true : false;
    }

    /**
     * Check message
     * @param string $message
     * @return bool
     */
    private function checkMessage($message = '')
    {
        return !empty($message) ? true : false;
    }
}
