<?php

namespace AppBundle\User\EventListener;

use AppBundle\User\Event\SendActivationCode;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendActivationCodeSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            SendActivationCode::class => 'onSendActivationCode',
        ];
    }

    public function onSendActivationCode(SendActivationCode $sendActivationCode)
    {
        dump($sendActivationCode);die;
    }
}