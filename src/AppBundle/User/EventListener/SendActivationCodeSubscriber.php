<?php

namespace AppBundle\User\EventListener;

use AppBundle\User\Event\SendActivationCode;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

class SendActivationCodeSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public static function getSubscribedEvents()
    {
        return [
            SendActivationCode::class => 'onSendActivationCode',
        ];
    }

    public function onSendActivationCode(SendActivationCode $sendActivationCode)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($sendActivationCode->email())
            ->setBody(
                $this->templating->render(
                    ':Emails:registration.html.twig',
                    [
                        'activationCode' => $sendActivationCode->activationCode(),
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}