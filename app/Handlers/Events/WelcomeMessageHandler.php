<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Mail\Message;
use StyleCI\StyleCI\Events\UserHasSignedUpEvent;

/**
 * This is the welcome message handler class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class WelcomeMessageHandler implements ShouldBeQueued
{
    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * Create a new welcome message handler instance.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the user has signed up event.
     *
     * @param \StyleCI\StyleCI\Events\UserHasSignedUpEvent $event
     *
     * @return void
     */
    public function handle(UserHasSignedUpEvent $event)
    {
        $user = $event->user;

        $mail = [
            'name'    => explode(' ', $user->name)[0],
            'email'   => $user->email,
            'subject' => '[StyleCI] Welcome To StyleCI',
        ];

        $this->mailer->send(['html' => 'emails.welcome-html', 'text' => 'emails.welcome-text'], $mail, function (Message $message) use ($mail) {
            $message->to($mail['email'])->subject($mail['subject']);
        });
    }
}
