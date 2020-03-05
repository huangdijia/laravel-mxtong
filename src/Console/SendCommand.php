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

        // try {
            $this->laravel->make('sms.mxtong')->send($mobile, $message);
        // } catch (\Exception $e) {
            // $this->error($e->getMessage(), 1);
            // return;
        // }

        $this->info('Send success!', 0);
    }
}
