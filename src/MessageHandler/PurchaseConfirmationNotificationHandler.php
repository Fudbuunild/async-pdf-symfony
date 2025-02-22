<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Mpdf\Mpdf;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(PurchaseConfirmationNotification $notification)
    {
        $mpdf = new mPDF();
        $content = "<h1>Contract Note for Order {$notification->getOrderId()}</h1>";
        $content .= '<p>Total: <b>$1898.75</b></p>';

        $mpdf->writeHTML($content);
        $contractNotePdf = $mpdf->output('', 'S');

        echo 'Emailing contract note to ' . 'vankevychpetro@gmail.com' . '<br>';
        $email = (new Email())
            ->from('vankevychpetro@gmail.com')
            ->to('vankevychpetro@gmail.com')
            ->subject('Contract note for order ' . $notification->getOrder()->getId())
            ->text('Here is your contract note')
            ->attach($contractNotePdf, 'contract-note.pdf');

        $this->mailer->send($email);
    }
}