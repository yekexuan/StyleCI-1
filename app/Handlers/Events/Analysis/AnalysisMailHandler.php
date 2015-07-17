<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Analysis;

use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the analysis mail handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisMailHandler
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
     * Create a new analysis mail handler instance.
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
     * Handle the analysis has completed event.
     *
     * @param \StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent $event
     *
     * @return void
     */
    public function handle(AnalysisHasCompletedEvent $event)
    {
        $analysis = $event->analysis;

        if ($analysis->status < 3 || $analysis->pr) {
            return;
        }

        $repo = $analysis->repo;

        $mail = [
            'repo'    => $repo->name,
            'commit'  => $analysis->message,
            'link'    => route('analysis_path', AutoPresenter::decorate($analysis)->id),
        ];

        switch ($analysis->status) {
            case 3:
            case 4:
            case 5:
                $status = 'failed';
                $mail['status'] = 'Analysis Failed';
                break;
            case 6:
                $status = 'misconfigured';
                $mail['status'] = 'Analysis Misconfigured';
                break;
            case 7:
                $status = 'access';
                $mail['status'] = 'Analysis Errored';
                break;
            case 8:
                $status = 'timeout';
                $mail['status'] = 'Analysis Timed Out';
                break;
            default:
                $status = 'errored';
                $mail['status'] = 'Analysis Errored';
        }

        foreach ($this->userRepository->collaborators($repo) as $user) {
            $mail['email'] = $user->email;
            $mail['name'] = AutoPresenter::decorate($user)->first_name;
            $this->mailer->queue(["emails.html.{$status}", "emails.text.{$status}"], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}
