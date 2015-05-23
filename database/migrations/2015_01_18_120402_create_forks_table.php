<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 * (c) Joseph Cohen <joseph.cohen@dinkbit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This is the create forks table migration class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class CreateForksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forks', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();
            $table->bigInteger('repo_id')->unsigned()->index();
            $table->string('name', 128);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forks');
    }
}
