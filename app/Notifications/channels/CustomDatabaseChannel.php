<?php

namespace App\Notifications\channels;

use Illuminate\Notifications\Channels\DatabaseChannel as BaseDatabaseChannel;
use Illuminate\Notifications\Exceptions\CouldNotSendNotification;
use Log;
use Exception;

class CustomDatabaseChannel extends BaseDatabaseChannel
{
    public function send($notifiable, $notification)
    {
        try {
            // Attempt to send the notification
            return parent::send($notifiable, $notification);
        } catch (Exception $e) {


            throw $e;
        }
    }
}
