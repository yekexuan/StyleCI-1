<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\User;

use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Events\User\UserHasSignedUpEvent;

/**
 * This is the welcome message handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class WelcomeMessageHandler
{
    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\MailQueue
     */
    protected $mailer;

    /**
     * Create a new welcome message handler instance.
     *
     * @param \Illuminate\Contracts\Mail\MailQueue $mailer
     *
     * @return void
     */
    public function __construct(MailQueue $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the user has signed up event.
     *
     * @param \StyleCI\StyleCI\Events\User\UserHasSignedUpEvent $event
     *
     * @return void
     */
    public function handle(UserHasSignedUpEvent $event)
    {
        $user = $event->user;

        $mail = [
            'email'   => $user->email,
            'name'    => AutoPresenter::decorate($user)->first_name,
            'subject' => 'Welcome To StyleCI',
        ];

        $this->mailer->queue(['html' => 'emails.welcome-html', 'text' => 'emails.welcome-text'], $mail, function (Message $message) use ($mail) {
            $message->to($mail['email'])->subject($mail['subject']);
        });
    }
}
