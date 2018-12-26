<?php

namespace Huangdijia\Mxtong\Console;

use Illuminate\Console\Command;

class SendCommand extends Command
{
    protected $signature   = 'mxtong:send {mobile : Mobile Number} {message : Message Content}';
    protected $description = 'Send a message by mxtong';

    public function handle()
    {
        $mobile  = $this->argument('mobile');
        $message = $this->argument('message');
        $mxtong  = app('sms.mxtong');

        if (!$mxtong->send($mobile, $message)) {
            $this->error($mxtong->getError(), 1);
            return;
        }

        $this->info('send success!', 0);
    }
}
