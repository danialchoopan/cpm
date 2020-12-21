<?php


namespace App\core\api;


use Mailgun\Mailgun;

class SendMailApi
{
    static public function MailTo($to, $subject, $text)
    {
        $mg = Mailgun::create($_ENV['MAILGUN_API_KEY']);
        $mg->messages()->send($_ENV['MAILGUN_DOMAIN_NAME'], [
            'from' => 'cardanial@danialchoopan.ir',
            'to' => $to,
            'subject' => $subject,
            'text' => $text
        ]);
    }
}