<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * This is the analysis presenter class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class AnalysisPresenter extends BasePresenter implements Arrayable
{
    /**
     * Get the analysis status summary.
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
     * Get the analysis status icon.
     *
     * @return string
     */
    public function icon()
    {
        if ($this->wrappedObject->status == 1) {
            return 'fa fa-check-circle';
        }

        if ($this->wrappedObject->status > 2) {
            return 'fa fa-times-circle';
        }

        return 'fa fa-exclamation-circle';
    }

    /**
     * Get the analysis status color.
     *
     * @return string
     */
    public function color()
    {
        if ($this->wrappedObject->status === 1) {
            return 'green';
        }

        if ($this->wrappedObject->status > 1) {
            return 'red';
        }

        return 'grey';
    }

    /**
     * Get the github id.
     *
     * @return string
     */
    public function github_id()
    {
        if ($this->pr) {
            return '#'.$this->wrappedObject->pr;
        }

        return substr($this->wrappedObject->commit, 0, 6);
    }

    /**
     * Get the github link.
     *
     * @return string
     */
    public function github_link()
    {
        if ($this->pr) {
            return 'https://github.com/'.$this->wrappedObject->repo->name.'/pull/'.$this->wrappedObject->pr;
        }

        return 'https://github.com/'.$this->wrappedObject->repo->name.'/commit/'.$this->wrappedObject->commit;
    }

    /**
     * Get the analysis's time ago.
     *
     * @return string
     */
    public function time_ago()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    /**
     * Get the analysis's created time ISO.
     *
     * @return string
     */
    public function created_at_iso()
    {
        return $this->wrappedObject->created_at->toIso8601String();
    }

    /**
     * Get the diff splited to files.
     *
     * @return \StyleCI\StyleCI\Presenters\Diff
     */
    public function diff()
    {
        return new Diff($this->wrappedObject->diff);
    }

    /**
     * Get the analysis status description.
     *
     * @return string
     */
    public function description()
    {
        return $this->wrappedObject->description();
    }

    /**
     * Convert presented analysis to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'             => $this->wrappedObject->id,
            'commit'         => $this->wrappedObject->commit,
            'repo_id'        => $this->wrappedObject->repo_id,
            'repo_name'      => $this->wrappedObject->repo->name,
            'message'        => $this->wrappedObject->message,
            'description'    => $this->wrappedObject->description(),
            'error'          => $this->wrappedObject->error,
            'status'         => $this->wrappedObject->status,
            'color'          => $this->color(),
            'summary'        => $this->summary(),
            'icon'           => $this->icon(),
            'time_ago'       => $this->time_ago(),
            'github_id'      => $this->github_id(),
            'github_link'    => $this->github_link(),
            'created_at_iso' => $this->created_at_iso(),
            'link'           => route('analysis_path', $this->wrappedObject->id),
        ];
    }
}
