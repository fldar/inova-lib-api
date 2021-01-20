<?php

namespace App\Service;

use Twig\Environment;

class MailService
{
    /** @var string  */
    public const
        SUBJECT_RECOVER = 'You have requested a recover password.',
        FROM_REVOCER = 'notapp202001@gmail.com'
    ;

    private Environment $twig;
    private \Swift_Mailer $mailer;

    /**
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     * @param string|null $to
     * @param string|null $domain
     * @param string|null $token
     * @return int
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendEmailRecoverPassword(?string $to, ?string $domain, ?string $token): int
    {
        return $this->mailer->send($this->getMessageRecoverPassword($to, $domain, $token));
    }

    /**
     * @param string|null $to
     * @param string|null $domain
     * @param string|null $token
     * @return \Swift_Message
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getMessageRecoverPassword(?string $to, ?string $domain, ?string $token): \Swift_Message
    {
        return (new \Swift_Message(self::SUBJECT_RECOVER))
            ->setFrom(self::FROM_REVOCER)
            ->setTo($to)
            ->setBody(
                $this->twig->render(
                    'mail/recover-password.html.twig',
                    ['url' => $domain . $token]
                ),
                'text/html'
            )
        ;
    }
}
