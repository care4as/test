<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
    }

}
class UserSeeder extends Seeder
{

  function run()
  {
    \DB::table('users')->insert(
    [
      'name' => 'superuser987',
      'password' => Hash::make('test123'),
      'email' => 'testmail@test.de',
      'role' => 'superadmin',
      'email_verified_at' => Carbon::now(),
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),

   ]);
  }
}
/**
 *
 */
