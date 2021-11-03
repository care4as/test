<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
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

        $roleArray = $this->getRoles();

        // dd($roleArray);
        $users = $this->getUnfilteredUsers();

        if($employeeState == 'active'){
            $users = $this->refineUserlistActive($users);
        }
        if($employeeState == 'inactive'){
            $users = $this->refineUserlistInactive($users);
        }
        if($project != null && $project != 'all'){
            $users = $this->refineUserlistProject($users, $project);
        }
          dd($users);
        //users erstellen und anschließend nach bedarf durch verschiedene filter laufen lassen, wodurch nutzer entfernt werden

        //dd($users);

        return view('usermanagement.userlist', compact('users', 'defaultVariables', 'roleArray'));
    }

    public function getRoles(){
        $roles = DB::table('roles')
        ->get()
        ->toArray();

        $rights = DB::table('rights')
        ->get()
        ->toArray();

        $roleRights = DB::table('roles_has_rights')
        ->get()
        ->toArray();

        $roleArray = array();
        //fill roles
        foreach($roles as $keyRole => $role){
            $role = (array) $role;
            $roleArray[$role['name']] = null;

            foreach($rights as $keyRight => $right){
                $right = (array) $right;
                $roleArray[$role['name']]['rights'][$right['id']]['name'] = $right['name'];
                $roleArray[$role['name']]['rights'][$right['id']]['has_right'] = false;

                foreach($roleRights as $keyRoleRight => $roleRight){
                    $roleRight = (array) $roleRight;
                    if($roleRight['role_id'] == $role['id'] && $roleRight['rights_id'] == $right['id']){
                        $roleArray[$role['name']]['rights'][$right['id']]['has_right'] = true;
                    }
                }
            }
        }

        //dd($currentRight);
        //dd($roleArray);
        return $roleArray;
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
                $user['abteilung_id'] = 'Keine Angabe';
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
            DB::table('users')->updateOrInsert(
                [
                  'ds_id' => $user['ds_id']
                ],
                [
                'name' => $user['agent_id'],
                'project' => $user['projekt_id'],
                'department' => $user['abteilung_id'],
                'team' => $user['team'],
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
        $tracking_id = request('tracking_id');

        DB::table('users')->updateOrInsert(
            [
              'ds_id' => $ds_id
            ],
            [
            '1u1_person_id' => $person_id,
            '1u1_agent_id' => $agent_id,
            '1u1_sse_name' => $sse_id,
            'kdw_tracking_id' => $tracking_id,
            ]
          );

        return redirect()->back();
    }

    public function updateUserPassword(){
        $ds_id = request('ds_id');
        $new_password = request('new_password');

        DB::table('users')->updateOrInsert(
            [
              'ds_id' => $ds_id
            ],
            [
                'password' => Hash::make($new_password),
            ]
          );

        return redirect()->back();
    }

    public function updateUserRole(){
        $ds_id = request('ds_id');
        $new_role = request('new_role');
        if($new_role == 'null'){
            $new_role = null;
        }

        DB::table('users')->updateOrInsert(
            [
              'ds_id' => $ds_id
            ],
            [
                'role' => $new_role,
            ]
          );

        return redirect()->back();
    }

    public function getUnfilteredUsers(){
        $users = DB::table('users')
        ->where('name','!=','superuser')
        ->get()
        ->toArray();

        // dd($users);
        $kdwUsers = DB::connection('mysqlkdw')
        ->table('MA')
        ->get()
        ->toArray();

        $userArray = array();

        foreach($users as $key => $entry){
            $entry = (array) $entry;

            foreach($kdwUsers as $keyKdw => $entryKdw){
                $entryKdw = (array) $entryKdw;
                if ($entryKdw['ds_id'] == $entry['ds_id']){
                    $entry['entry_date'] = $entryKdw['eintritt'];
                    $entry['leave_date'] = $entryKdw['austritt'];
                    $entry['work_hours'] = $entryKdw['soll_h_day'];
                    $entry['work_location'] = $entryKdw['standort'];
                    $entry['lastname'] = $entryKdw['familienname'];
                    $entry['firstname'] = $entryKdw['vorname'];
                    $entry['full_name'] = $entryKdw['familienname'] . ', ' . $entryKdw['vorname'];
                    $entry['birthdate'] = $entryKdw['geburt'];
                    $entry['gender'] = $entryKdw['geschlecht'];
                    $entry['zipcode'] = $entryKdw['plz'];
                    $entry['location'] = $entryKdw['ort'];
                    $entry['street'] = $entryKdw['strasse'];
                    $entry['phone'] = $entryKdw['telefon'];
                    $entry['mobile'] = $entryKdw['handy'];
                    $entry['mail'] = $entryKdw['email'];
                }
            }
            $userArray[] = $entry;
        }
        return $userArray;
    }

    public function refineUserlistActive($userlist){

        foreach($userlist as $key => $entry) {
            if(isset($entry['leave_date']))
            {
              if (($entry['leave_date'] < today()) && $entry['leave_date'] != null) {
                  unset($userlist[$key]);
              }
            }
        }
        return $userlist;
    }

    public function refineUserlistInactive($userlist){
        foreach($userlist as $key => $entry) {
          if(isset($entry['leave_date']))
          {
            if (($entry['leave_date'] > today()) || $entry['leave_date'] == null) {
                unset($userlist[$key]);
            }
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
