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
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Models\Repo;
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
        $repo = $analysis->repo;

        if (!$analysis->branch) {
            return;
        }

        if ($analysis->status === 2) {
            $this->notifySuccess($analysis, $repo);
        } elseif ($analysis->status > 2 && !$analysis->pr) {
            $this->notifyNotSuccess($analysis, $repo);
        }
    }

    /**
     * Notify collaborators of successful analyses.
     *
     * We only notify them if the previous analysis of this branch failed, or
     * if this was the first analysis of this branch.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     * @param \StyleCI\StyleCI\Models\Repo     $repo
     *
     * @return void
     */
    public function notifySuccess(Analysis $analysis, Repo $repo)
    {
        $previous = Repo::analyses()->where('branch', $repo->branch)->where('id', '<', $analysis->id)->latest()->first();

        if (!$previous) {
            $status = 'first';
        } elseif ($previous->status < 3) {
            $status = 'passed';
        }

        $mail = [
            'repo'   => $repo->name,
            'commit' => $analysis->message,
            'branch' => $analysis->branch,
            'link'   => route('analysis_path', AutoPresenter::decorate($analysis)->id),
            'status' => 'Analysis Passed';
        ];

        foreach ($this->userRepository->collaborators($repo) as $user) {
            $mail['email'] = $user->email;
            $mail['name'] = AutoPresenter::decorate($user)->first_name;
            $this->mailer->queue(["emails.html.{$status}", "emails.text.{$status}"], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }

    /**
     * Notify collaborators of unsuccessful analyses.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     * @param \StyleCI\StyleCI\Models\Repo     $repo
     *
     * @return void
     */
    public function notifyNotSuccess(Analysis $analysis, Repo $repo)
    {
        $mail = [
            'repo'   => $repo->name,
            'commit' => $analysis->message,
            'branch' => $analysis->branch,
            'link'   => route('analysis_path', AutoPresenter::decorate($analysis)->id),
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
