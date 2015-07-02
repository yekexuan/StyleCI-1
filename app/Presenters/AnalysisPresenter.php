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
use StyleCI\Storage\Stores\StoreInterface;

/**
 * This is the analysis presenter class.
 *
 * @property int           $id
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
     * Get the analysis status summary.
     *
     * @return string
     */
    public function summary()
    {
        switch ($this->wrappedObject->status) {
            case 0:
                return 'PENDING';
            case 1:
                return 'RUNNING';
            case 2:
                return 'PASSED';
            case 3:
            case 4:
            case 5:
                return 'FAILED';
            case 6:
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
    public function description()
    {
        switch ($this->wrappedObject->status) {
            case 0:
                return 'The StyleCI analysis is pending';
            case 1:
                return 'The StyleCI analysis is running';
            case 2:
                return 'The StyleCI analysis has passed';
            case 3:
            case 4:
            case 5:
                return 'The StyleCI analysis has failed';
            case 6:
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
    public function icon()
    {
        if ($this->wrappedObject->status === 2) {
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
        if ($this->wrappedObject->status === 2) {
            return 'green';
        }

        if ($this->wrappedObject->status > 2) {
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
     * Get the raw diff.
     *
     * @return string|null
     */
    public function raw_diff()
    {
        if ($this->wrappedObject->status === 3 || $this->wrappedObject->status === 5) {
            return $this->storage->get($this->wrappedObject->id);
        }
    }

    /**
     * Get the diff split up to files.
     *
     * @return \StyleCI\StyleCI\Presenters\Diff
     */
    public function diff()
    {
        $diff = (string) $this->raw_diff();

        return new Diff(ltrim($diff));
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
            'error'          => $this->wrappedObject->error,
            'errors'         => $this->wrappedObject->errors,
            'status'         => $this->wrappedObject->status,
            'color'          => $this->color(),
            'summary'        => $this->summary(),
            'description'    => $this->description(),
            'icon'           => $this->icon(),
            'time_ago'       => $this->time_ago(),
            'github_id'      => $this->github_id(),
            'github_link'    => $this->github_link(),
            'created_at_iso' => $this->created_at_iso(),
            'link'           => route('analysis_path', $this->wrappedObject->id),
        ];
    }
}
