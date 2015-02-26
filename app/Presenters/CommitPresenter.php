<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 * (c) Joseph Cohen <joseph.cohen@dinkbit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * This is the commit presenter class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 * @author Joseph Cohen <joseph.cohen@dinkbit.com>
 */
class CommitPresenter extends BasePresenter implements Arrayable
{
    /**
     * Get the commit status summary.
     *
     * @return string
     */
    public function summary()
    {
        switch ($this->wrappedObject->status) {
            case 1:
                return 'PASSED';
            case 2:
                return 'FAILED';
            case 3:
                return 'ERRORED';
            case 4:
                return 'MISCONFIGURED';
            default:
                return 'PENDING';
        }
    }

    /**
     * Get the commit's repo shorthand id.
     *
     * @return string
     */
    public function shorthandId()
    {
        return substr($this->wrappedObject->id, 0, 6);
    }

    /**
     * Get the commit's style check executed time.
     *
     * @return string
     */
    public function excecutedTime()
    {
        // if analysis is pending or errored, then we don't have a time
        if ($this->wrappedObject->status !== 1 || $this->wrappedObject->status !== 2) {
            return '-';
        }

        $seconds = $this->wrappedObject->time;

        // first we calculate milliseconds and seconds
        $milliseconds = str_replace("0.", '', $seconds - floor($seconds));
        $seconds = $seconds % 3600;

        // if seconds is more than a minute
        if ($seconds >= 60) {
            return gmdate('i:s', $seconds).' min';
        } elseif ($seconds < 60 && $seconds != 0) {
            $time = gmdate('s', $seconds);

            if ($milliseconds) {
                $time .= '.'.$milliseconds;
            }

            return $time.' sec';
        } else {
            return '0.'.round($milliseconds, 2).' sec';
        }
    }

    /**
     * Get the commit's time ago.
     *
     * @return string
     */
    public function timeAgo()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    /**
     * Get the commit's created time ISO.
     *
     * @return string
     */
    public function createdAtToISO()
    {
        return $this->wrappedObject->created_at->toIso8601String();
    }

    /**
     * Convert presented commit to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'             => $this->wrappedObject->id,
            'repo_id'        => $this->wrappedObject->repo_id,
            'repo_name'      => $this->wrappedObject->repo->name,
            'message'        => $this->wrappedObject->message,
            'description'    => $this->wrappedObject->description(),
            'status'         => $this->wrappedObject->status,
            'summary'        => $this->summary(),
            'timeAgo'        => $this->timeAgo(),
            'shorthandId'    => $this->shorthandId(),
            'excecutedTime'  => $this->excecutedTime(),
            'createdAtToISO' => $this->createdAtToISO(),
            'link'           => route('commit_path', $this->wrappedObject->id),
        ];
    }
}
