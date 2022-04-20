<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\User');
        for ($i=0; $i < 1; $i++) {
            DB::table('users')->insert([
                'nama' 					=> 'Administrator',
                'username' 				=> 'admin',
                'no_induk' 				=> null,
                'jk' 					=> 'L',
                'no_hp' 				=> null,
                'pendidikan' 			=> null,
                'alamat' 				=> null,
                'status' 				=> 'A',
                'status_sekolah' 		=> 'Y',
                'status_ujian' 			=> null,
                'status_validasi' 		=> null,
                'email' 				=> 'admin@seenglish.com',
                'password' 				=> bcrypt(123456)
            ]);
        }
    }
}
