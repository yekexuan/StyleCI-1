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

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use StyleCI\StyleCI\Models\Commit;

/**
 * This is the commit controller class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class CommitController extends AbstractController
{
    /**
     * Handles the request to show a commit.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return \Illuminate\View\View
     */
    public function handleShow(Commit $commit)
    {
        // We first get the original and modified file names from the diff.
        preg_match_all('/\-\-\-\sa\/(.*?.*)/i', $commit->diff, $originalNames);
        preg_match_all('/\+\+\+\sb\/(.*?.*)/i', $commit->diff, $modifiedNames);

        $fileNames = [];

        // If the file name was modified we show the change.
        foreach ($originalNames[1] as $key => $originalName) {
            if ($originalName != $modifiedNames[1][$key]) {
                $fileNames[] = $originalName.' -> '.$modifiedNames[1][$key];
            } else {
                $fileNames[] = $originalName;
            }
        }

        // Then we split the diff into files.
        $extractedFiles = preg_split("/\s+?diff ?/", ltrim($commit->diff));

        $files = [];

        // Match file names with files.
        foreach ($extractedFiles as $index => $file) {
            $files[$fileNames[$index]] = 'diff '.$file;
        }

        return View::make('commit', compact('commit', 'files'));
    }

    /**
     * Handles the request to show a commit diff.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDiff(Commit $commit)
    {
        return Response::make($commit->diff)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * Handles the request to download a commit diff.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDiffDownload(Commit $commit)
    {
        return Response::make($commit->diff)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename=patch.txt');
    }
}
