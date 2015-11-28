<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Repo;

use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Events\Repo\RepoEventInterface;
use StyleCI\StyleCI\Events\Repo\RepoWasDisabledEvent;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the repo mail handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoMailHandler
{
    /**
     * The user repository instance.
     *
     * @var \StyleCI\StyleCI\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\MailQueue
     */
    protected $mailer;

    /**
     * Create a new repo mail handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     * @param \Illuminate\Contracts\Mail\MailQueue         $mailer
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, MailQueue $mailer)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    /**
     * Handle the repo event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\RepoEventInterface $event
     *
     * @return void
     */
    public function handle(RepoEventInterface $event)
    {
        $repo = $event->repo;
        $mail = ['repo' => $repo->name];

        if ($event instanceof RepoWasDisabledEvent) {
            $mail['subject'] = "[$repo->name] Disabled";
            $view = 'disabled';
        } else {
            $mail['subject'] = "[$repo->name] Enabled";
            $mail['link'] = route('repo', $repo->id);
            $view = 'enabled';
        }

        foreach ($this->userRepository->collaborators($repo) as $user) {
            $mail['email'] = $user->email;
            $mail['name'] = AutoPresenter::decorate($user)->first_name;
            $this->mailer->queue("emails.{$view}", $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}
