<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This is the create analyses table migration class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CreateAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('repo_id')->unsigned()->index();
            $table->string('branch')->nullable();
            $table->integer('pr')->unsigned()->nullable();
            $table->char('commit', 40);
            $table->string('message');
            $table->string('error')->nullable();
            $table->text('errors')->nullable();
            $table->tinyInteger('status')->unsigned()->index();
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
        Schema::drop('analyses');
    }
}
