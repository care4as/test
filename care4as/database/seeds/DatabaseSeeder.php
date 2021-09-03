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
        $this->call(RightsSeeder::class);
    }

}
class UserSeeder extends Seeder
{

  function run()
  {
    if(DB::table('users')->where('role','superadmin')->exists())
    {
      DB::table('users')->where('role','superadmin')->delete();
    }
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

class RightsSeeder extends Seeder
{

  function run()
  {
    if(!DB::table('roles')->where('name','superadmin')->exists())
    {
      \DB::table('roles')->insert(
      [
        'name' => 'superadmin',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
     ]);
    }

    $rightsarray = array(
      'dashboard',
      'dashboardAdmin',
      'createUser',
      'updateUser',
      'indexUser',
      'indexCancels',
      'createCancels',
      'deleteCancels',
      'changeCancels',
      'importReports',
      'createMabel',
      'indexMabel',
      'deleteMabel',
      'createSurvey',
      'indexSurvey',
      'deleteSurvey',
      'sendReports',
      'indexFeedback',
      'changeConfig',
      'trainings',
      'presentation',
      'changeRole',
      'createRole',
      'analyzeCancels',
      'attendSurvey',
      'config',
      'deleteUser',
      'telefonicapause',
      'telefonica_config',
      'inventory',
      'controlling',
      'statistics',
    );
    $superadminid = DB::table('roles')->where('name','superadmin')->value('id');

    foreach ($rightsarray as  $right) {

    if(!\DB::table('rights')->where('name', $right)->exists())
    {
      $right = \DB::table('rights')->insert(
      [
        'name' => $right,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
     ]);
    }
    $rightsid = DB::getPdo()->lastInsertId();

    if(!\DB::table('roles_has_rights')->where('role_id',$superadminid)->where('rights_id',$rightsid)->exists())
     DB::table('roles_has_rights')
     ->insert([
       'role_id' => $superadminid,
       'rights_id' => $rightsid,
     ]);
    }
  }
}
/**
 *
 */
