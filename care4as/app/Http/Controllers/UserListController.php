<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserListController extends Controller
{
    public function load(){
        $project = request('project');
        $employeeState = request('inputEmployee');

        $defaultVariables = array();
        $defaultVariables['project'] = $project;
        $defaultVariables['inputEmployee'] = $employeeState;

        //dd($defaultVariables);
                
        $users = $this->getUnfilteredUsers();
        //dd($users);
        if($employeeState == 'active'){
            $users = $this->refineUserlistActive($users);
        }
        if($employeeState == 'inactive'){
            $users = $this->refineUserlistInactive($users);
        }
        if($project != null && $project != 'all'){
            $users = $this->refineUserlistProject($users, $project);
        }

        //users erstellen und anschließend nach bedarf durch verschiedene filter laufen lassen, wodurch nutzer entfernt werden

        //dd($users);

        return view('usermanagement.userlist', compact('users', 'defaultVariables'));
    }

    public function syncUserlistKdw(){
        DB::disableQueryLog();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0'); // for infinite time of execution
        
        $userData = DB::connection('mysqlkdw')
        ->table('MA')
        ->get()
        ->toArray();

        $projectData = DB::connection('mysqlkdw')
        ->table('projekte')
        ->get()
        ->toArray(); 

        $projectDataArray = array();

        foreach($projectData as $key => $entry){
            $entry = (array) $entry;
            $projectDataArray[$entry['ds_id']] = $entry['bezeichnung'];
        }

        $departmentData = DB::connection('mysqlkdw')
        ->table('abteilungen')
        ->get()
        ->toArray(); 

        $departmentDataArray = array();

        foreach($departmentData as $key => $entry){
            $entry = (array) $entry;
            $departmentDataArray[$entry['ds_id']] = $entry['bezeichnung'];
        }

        $teamData = DB::connection('mysqlkdw')
        ->table('teams')
        ->get()
        ->toArray(); 

        $teamDataArray = array();

        foreach($teamData as $key => $entry){
            $entry = (array) $entry;
            $teamDataArray[$entry['ds_id']] = $entry['bezeichnung'];
        }

        $teamEmployeeData = DB::connection('mysqlkdw')
        ->table('teams_MA')
        ->get()
        ->toArray(); 

        $teamEmployeeDataArray = array();

        foreach($teamEmployeeData as $key => $entry){
            $entry = (array) $entry;
            $teamEmployeeDataArray[$entry['MA_id']] = $teamDataArray[$entry['team_id']];
        }

        foreach($userData as $key => $user) {
            $user = (array) $user;

            if($user['geburt'] == '0000-00-00'){
                $user['geburt'] = null;
            } else {
                $user['geburt'] = date_create_from_format('Y-m-d', $user['geburt']);
            }

            if($user['austritt'] != null) {
                $user['austritt'] = date_create_from_format('Y-m-d', $user['austritt']);
            }

            if($user['projekt_id'] != null && $user['projekt_id'] != 0){
                $user['projekt_id'] = $projectDataArray[$user['projekt_id']];
            } else {
                $user['projekt_id'] = null;
            }

            if($user['abteilung_id'] != null && $user['abteilung_id'] != 0){
                $user['abteilung_id'] = $departmentDataArray[$user['abteilung_id']];
            } else {
                $user['abteilung_id'] = null;
            }

            if(isset($teamEmployeeDataArray[$user['ds_id']])){
                $user['team'] = $teamEmployeeDataArray[$user['ds_id']];
            } else {
                $user['team'] = null;
            }
            if($user['geschlecht'] == 'M') {
                $user['geschlecht'] = 'Männlich';
            } else if($user['geschlecht'] == 'W'){
                $user['geschlecht'] = 'Weiblich';
            } else {
                $user['geschlecht'] = 'Divers';
            }
  
            //INSERT OR IGNORE
            DB::table('userlist')->updateOrInsert(
                [
                  'ds_id' => $user['ds_id']
                ],
                [
                'username' => $user['agent_id'],
                'password' => Hash::make('care4as2021!'),
                'lastname' => $user['familienname'],
                'firstname' => $user['vorname'],
                'full_name' => $user['familienname'] . ', ' . $user['vorname'],
                'gender' => $user['geschlecht'],
                'birthdate' => $user['geburt'],
                'zipcode' => intval($user['plz']),
                'location' => $user['ort'],
                'street' => $user['strasse'],
                'phone' => $user['telefon'],
                'mobile' => $user['handy'],
                'mail' => $user['email'],
                'work_location' => $user['standort'],
                'project' => $user['projekt_id'], 
                'department' => $user['abteilung_id'],
                'team' => $user['team'],
                'entry_date' => date_create_from_format('Y-m-d', $user['eintritt']),
                'leave_date' => $user['austritt'],
                'work_hours' => intval($user['soll_h_day']),
                ]
              );
        }

        //redirect back to userlist
        return redirect()->back();  
    }

    public function updateUser(){
        $ds_id = request('ds_id');
        $person_id = request('person_id');
        $agent_id = request('agent_id');
        $sse_id = request('sse_id');

        DB::table('userlist')->updateOrInsert(
            [
              'ds_id' => $ds_id
            ],
            [
            '1u1_person_id' => $person_id,
            '1u1_agent_id' => $agent_id,
            '1u1_sse_id' => $sse_id,
            ]
          );

        return redirect()->back(); 
    }

    public function getUnfilteredUsers(){
        $users = DB::table('userlist')
        ->get()
        ->toArray();

        $userArray = array();

        foreach($users as $key => $entry){
            $entry = (array) $entry;
            $userArray[] = $entry;
        }

        return $userArray;
    }

    public function refineUserlistActive($userlist){
        foreach($userlist as $key => $entry) {
            if (($entry['leave_date'] < today()) && $entry['leave_date'] != null) {
                unset($userlist[$key]);
            }

        }
        return $userlist;
    }

    public function refineUserlistInactive($userlist){
        foreach($userlist as $key => $entry) {
            if (($entry['leave_date'] > today()) || $entry['leave_date'] == null) {
                unset($userlist[$key]);
            }

        }
        return $userlist;
    }

    public function refineUserlistProject($userlist, $project){
        foreach($userlist as $key => $entry) {
            if ($entry['project'] != $project) {
                unset($userlist[$key]);
            }
        }
        return $userlist;
    }

}

