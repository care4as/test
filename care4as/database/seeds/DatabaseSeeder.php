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
      'name' => 'superuser',
      'password' => Hash::make('Care4Superadmin?'),
      'role' => 'superadmin',
      'status' => 1,
      'ds_id' => 0,
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
      'dashboard', //das Userdashboard für den Agenten
      'dashboardAdmin', //das Userdashboard für alle ab der Hierarchieebene FAP
      //'indexCancels',
      //'createCancels',
      //'deleteCancels',
      //'changeCancels',
      'reports_base', // Basiszugriff auf Reporte
      'reports_import', // Zugriff Reporte hochzuladen
      'reports_send', // Berechtigung Reporte zu versenden
      //'createMabel',
      //'indexMabel',
      //'deleteMabel',
      //'createSurvey',
      //'indexSurvey',
      //'deleteSurvey',
      //'indexFeedback',
      //'trainings',
      'presentation', // Zugriff auf Ansichten die für Präsentationszwecke erstellt werden
      //'analyzeCancels',
      //'attendSurvey',
      //'statistics',
      'config_base', // Basiszugriff auf die Konfiguration des Softwaretools
      'config_create_role', // Berechtigung neue Rollen anzulegen
      '1u1_dsl_base', //Basiszugriff für 1u1 DSL Retention
      '1u1_mobile_base', // Basiszugriff für 1u1 Mobile Retention
      '1u1_db', // Zugriff auf den Deckungsbeitrag der beiden Retention Projekte 1u1
      'telefonica_base', //Basiszugriff für Telefonica
      'telefonica_config',
      'controlling_base',
      'controlling_attainment', //Zugriff auf die Zielerreichung
      'controlling_revenuereport', //Zugriff auf die Umsatzmeldung
      'controlling_projectreport', //Zugriff auf die Projektmeldung
      'it_base', // Basiszugriff auf IT
      'it_scrum', // Zugriff auf das IT-Scrum Board
      'it_inventory', // Zugriff auf die Inventarverwaltung der IT
      'users_base',
      'users_userlist', // Zugriff auf die Mitarbeiterliste
      'users_update', // Berechtigung Mitarbeiterdaten zu ändern
      'users_change_role', // Berechtigung Mitarbeiterrollen zu ändern
      'users_reset_password', // Möglichkeit Mitarbeiterpasswörter zurückzusetzen
      'write_memos', //Möglichkeit Memorandas zu verfassen
      'wfm_base',
      'surveys',
      'survey_create',

    );
    $superadminid = DB::table('roles')->where('name','superadmin')->value('id');

    //Delete the old rights table, so the superuser doesnt have old rights
    DB::table('rights')->truncate();

    //inserts all the rights form the rightsarray into the database table rights and gives the right to the superadmin
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
