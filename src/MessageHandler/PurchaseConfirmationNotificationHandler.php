<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler
{
    public function __invoke(PurchaseConfirmationNotification $notification)
    {
        echo 'Creating a PDF contract note...';

        echo 'Emailing contract note to ' . $notification->getOrder()->getBuyer()->getEmail() . '<br>';
    }
}