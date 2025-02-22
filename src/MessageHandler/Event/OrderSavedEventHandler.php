<?php

namespace App\MessageHandler\Event;
use App\Message\Event\OrderSavedEvent;
use Mpdf\Mpdf;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class OrderSavedEventHandler implements MessageHandlerInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(OrderSavedEvent $event)
    {
        throw new \RuntimeException('Order could not be found');

        $mpdf = new mPDF();
        $content = "<h1>Contract Note for Order {$event->getOrderId()}</h1>";
        $content .= '<p>Total: <b>$1898.75</b></p>';

        $mpdf->writeHTML($content);
        $contractNotePdf = $mpdf->output('', 'S');

        echo 'Emailing contract note to ' . 'vankevychpetro@gmail.com' . '<br>';
        $email = (new Email())
            ->from('vankevychpetro@gmail.com')
            ->to('vankevychpetro@gmail.com')
            ->subject('Contract note for order ' . $event->getOrderId())
            ->text('Here is your contract note')
            ->attach($contractNotePdf, 'contract-note.pdf');

        $this->mailer->send($email);
    }
}