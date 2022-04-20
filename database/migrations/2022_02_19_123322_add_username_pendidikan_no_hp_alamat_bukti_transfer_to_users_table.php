<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsernamePendidikanNoHpAlamatBuktiTransferToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('id_kelas');
            $table->string('pendidikan')->nullable()->after('nama');
            $table->string('no_hp')->nullable()->after('jk');
            $table->text('alamat')->nullable()->after('jk');
            $table->string('bukti_transfer')->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
