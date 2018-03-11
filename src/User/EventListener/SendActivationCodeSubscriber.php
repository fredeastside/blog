<?php

namespace App\User\EventListener;

use App\User\Event\SendActivationCode;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class SendActivationCodeSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $templating;
    private $router;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            SendActivationCode::class => 'onSendActivationCode',
        ];
    }

    public function onSendActivationCode(SendActivationCode $sendActivationCode)
    {
        $url = $this->getActivationUrl($sendActivationCode->activationCode());

        $message = (new \Swift_Message('Подтверждение регистрации'))
            ->setFrom('robot@fredrsf.ru')
            ->setTo($sendActivationCode->email())
            ->setBody(
                $this->templating->render(
                    'Emails/registration.html.twig',
                    [
                        'url' => $url,
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    private function getActivationUrl(string $activationCode): string
    {
        return $this->router->generate(
            'registration_activation',
            [
                'activationCode' => $activationCode,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}