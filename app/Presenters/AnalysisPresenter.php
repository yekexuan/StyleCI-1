<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;
use StyleCI\Storage\Stores\StoreInterface;
use StyleCI\StyleCI\Models\Analysis;
use Vinkla\Hashids\Facades\Hashids;

/**
 * This is the analysis presenter class.
 *
 * @property string        $id
 * @property int           $repo_id
 * @property RepoPresenter $repo
 * @property string|null   $branch
 * @property int|null      $pr
 * @property string        $commit
 * @property string        $message
 * @property string|null   $error
 * @property array|null    $errors
 * @property int           $status
 * @property string        $summary
 * @property string        $description
 * @property string        $icon
 * @property string        $color
 * @property string        $github_id
 * @property string        $github_link
 * @property string        $time_ago
 * @property string        $created_at_iso
 * @property string|null   $raw_diff
 * @property bool          $has_diff
 * @property Diff          $diff
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class AnalysisPresenter extends BasePresenter implements Arrayable
{
    /**
     * The diff storage instance.
     *
     * @var \StyleCI\Storage\Stores\StoreInterface
     */
    protected $storage;

    /**
     * Create a new analysis presenter instance.
     *
     * @param \StyleCI\Storage\Stores\StoreInterface $storage
     * @param \StyleCI\StyleCI\Models\Analysis       $resource
     *
     * @return void
     */
    public function __construct(StoreInterface $storage, $resource)
    {
        $this->storage = $storage;
        parent::__construct($resource);
    }

    /**
     * Get the analysis hashids id.
     *
     * @return string
     */
    protected function id()
    {
        return Hashids::connection('analyses')->encode($this->wrappedObject->id);
    }

    /**
     * Get the analysis status summary.
     *
     * @return string
     */
    protected function summary()
    {
        switch ($this->wrappedObject->status) {
            case Analysis::PENDING:
                return 'PENDING';
            case Analysis::RUNNING:
                return 'RUNNING';
            case Analysis::PASSED:
                return 'PASSED';
            case Analysis::CS_ISSUES:
            case Analysis::SYNTAX_ISSUES:
            case Analysis::BOTH_ISSUES:
                return 'FAILED';
            case Analysis::CONFIG_ISSUES:
                return 'MISCONFIGURED';
            default:
                return 'ERRORED';
        }
    }

    /**
     * Get the status description.
     *
     * @return string
     */
    protected function description()
    {
        switch ($this->wrappedObject->status) {
            case Analysis::PENDING:
                return 'The StyleCI analysis is pending';
            case Analysis::RUNNING:
                return 'The StyleCI analysis is running';
            case Analysis::PASSED:
                return 'The StyleCI analysis has passed';
            case Analysis::CS_ISSUES:
            case Analysis::SYNTAX_ISSUES:
            case Analysis::BOTH_ISSUES:
                return 'The StyleCI analysis has failed';
            case Analysis::CONFIG_ISSUES:
                return 'The StyleCI analysis was misconfigured';
            default:
                return 'The StyleCI analysis has errored';
        }
    }

    /**
     * Get the analysis status icon.
     *
     * @return string
     */
    protected function icon()
    {
        switch ($this->wrappedObject->status) {
            case Analysis::PENDING:
            case Analysis::RUNNING:
                return 'fa fa-cog fa-spin';
            case Analysis::PASSED:
                return 'fa fa-check-circle';
            case Analysis::CS_ISSUES:
            case Analysis::SYNTAX_ISSUES:
            case Analysis::BOTH_ISSUES:
                return 'fa fa-times-circle';
            default:
                return 'fa fa-exclamation-circle';
        }
    }

    /**
     * Get the analysis status color.
     *
     * @return string
     */
    protected function color()
    {
        switch ($this->wrappedObject->status) {
            case Analysis::PENDING:
            case Analysis::RUNNING:
                return 'grey';
            case Analysis::PASSED:
                return 'green';
            default:
                return 'red';
        }
    }

    /**
     * Get the github id.
     *
     * @return string
     */
    protected function github_id()
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
    protected function github_link()
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
    protected function time_ago()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    /**
     * Get the analysis's created time ISO.
     *
     * @return string
     */
    protected function created_at_iso()
    {
        return $this->wrappedObject->created_at->toIso8601String();
    }

    /**
     * Is a diff present.
     *
     * @return bool
     */
    protected function has_diff()
    {
        return in_array($this->wrappedObject->status, Analysis::HAS_DIFF, true);
    }

    /**
     * Get the raw diff.
     *
     * @return string|null
     */
    protected function raw_diff()
    {
        if ($this->has_diff()) {
            return $this->storage->get($this->wrappedObject->id);
        }
    }

    /**
     * Get the diff split up to files.
     *
     * @return \StyleCI\StyleCI\Presenters\Diff
     */
    protected function diff()
    {
        $diff = $this->raw_diff();

        if (!is_string($diff)) {
            $diff = '';
        } else {
            $diff = ltrim($diff);
        }

        return new Diff($diff);
    }

    /**
     * Convert presented analysis to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'             => $this->id(),
            'commit'         => $this->wrappedObject->commit,
            'repo_id'        => $this->wrappedObject->repo_id,
            'repo_name'      => $this->wrappedObject->repo->name,
            'branch'         => $this->wrappedObject->branch,
            'pr'             => $this->wrappedObject->pr,
            'message'        => $this->wrappedObject->message,
            'status'         => $this->wrappedObject->status,
            'has_diff'       => $this->has_diff(),
            'color'          => $this->color(),
            'summary'        => $this->summary(),
            'description'    => $this->description(),
            'icon'           => $this->icon(),
            'time_ago'       => $this->time_ago(),
            'github_id'      => $this->github_id(),
            'github_link'    => $this->github_link(),
            'created_at_iso' => $this->created_at_iso(),
            'link'           => route('analysis', $this->id()),
        ];
    }
}
