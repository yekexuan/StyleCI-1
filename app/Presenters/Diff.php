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

use ArrayAccess;
use Countable;
use Gitonomy\Git\Diff\FileChange;

/**
 * This is the diff class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class Diff implements ArrayAccess, Countable
{
    /**
     * The diff files.
     *
     * @var string[]
     */
    protected $files = [];

    /**
     * The count of additions on the diff.
     *
     * @var int
     */
    protected $additions = 0;

    /**
     * The count of deletions on the diff.
     *
     * @var int
     */
    protected $deletions = 0;

    /**
     * Creates a new diff instance.
     *
     * @param \Gitonomy\Git\Diff\File[] $files
     *
     * @return void
     */
    public function __construct(array $files)
    {
        $files = array_filter($files, function ($file) {
            return !$file->isBinary();
        });

        foreach ($files as $file) {
            $this->additions += $file->getAdditions();
            $this->deletions += $file->getDeletions();

            if ($file->isRename()) {
                $name = $file->getOldName().' -> '.$file->getNewName();
            } elseif ($file->isDeletion()) {
                $name = $file->getOldName();
            } else {
                $name = $file->getNewName();
            }

            $all = [];

            foreach ($file->getChanges() as $change) {
                foreach ($change->getLines() as $line) {
                    switch ($line[0]) {
                        case FileChange::LINE_REMOVE:
                            $content = '-';
                            break;
                        case FileChange::LINE_ADD:
                            $content = '+';
                            break;
                        default:
                            $content = ' ';
                    }

                    $all[] = $content.($line[1] ?: ' ');
                }

                $all[] = '  ';
            }

            $this->files[$name] = "  \n".trim(implode("\n", $all), "\n\r");
        }
    }

    /**
     * Get the diff files.
     *
     * @return string[]
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * Get the count of additions on the diff.
     *
     * @return int
     */
    public function additions()
    {
        return $this->additions;
    }

    /**
     * Get the count of deletions on the diff.
     *
     * @return int
     */
    public function deletions()
    {
        return $this->deletions;
    }

    /**
     * Get the count of files on the diff.
     *
     * @return int
     */
    public function count()
    {
        return count($this->files);
    }

    /**
     * Set a diff file.
     *
     * @param string $offset
     * @param string $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->files[] = $value;
        } else {
            $this->files[$offset] = $value;
        }
    }

    /**
     * Determine if the given file exists.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->files[$offset]);
    }

    /**
     * Unset a diff file.
     *
     * @param string $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->files[$offset]);
    }

    /**
     * Get a diff file.
     *
     * @param string $offset
     *
     * @return string|null
     */
    public function offsetGet($offset)
    {
        return isset($this->files[$offset]) ? $this->files[$offset] : null;
    }
}
