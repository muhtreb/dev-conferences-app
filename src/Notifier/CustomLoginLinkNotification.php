<?php

namespace App\Notifier;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkNotification;

class CustomLoginLinkNotification extends LoginLinkNotification
{
    public function asEmailMessage(EmailRecipientInterface $recipient, ?string $transport = null): ?EmailMessage
    {
        $emailMessage = parent::asEmailMessage($recipient, $transport);

        /** @var TemplatedEmail $email */
        $email = $emailMessage->getMessage();
        $email->htmlTemplate('emails/custom_login_link_email.html.twig');

        return $emailMessage;
    }
}
