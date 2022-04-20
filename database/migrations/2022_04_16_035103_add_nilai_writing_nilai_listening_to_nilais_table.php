<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNilaiWritingNilaiListeningToNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->integer('nilai_writing')->nullable()->after('nilai_reading');
            $table->integer('nilai_listening')->nullable()->after('nilai_writing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
