<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserListController extends Controller
{
    public function load(){
        $userList = $this->getUserData();
        $departmentList = $this->getDepartmentList();
        $projectList = $this->getProjectList();
        $refinedUserList = $this->refineUserList($userList, $departmentList, $projectList);

        //dd($refinedUserList);
        return view('userlist', compact('refinedUserList'));
    }

    public function getUserData(){
        $userData = DB::connection('mysqlkdw')
        ->table('MA')
        ->get();

        $userList = json_decode($userData, true);
        return $userList;
    }

    public function getDepartmentList(){
        $departmentData = DB::connection('mysqlkdw')
        ->table('abteilungen')
        ->get();

        $departmentList = json_decode($departmentData, true);
        $refinedDepartmentList = array();
        foreach($departmentList as $key => $data){
            $refinedDepartmentList['ds_id'][$data['ds_id']]['bezeichnung'] = $data['bezeichnung'];
        }
        return $refinedDepartmentList;
    }

    public function getProjectList(){
        $projektData = DB::connection('mysqlkdw')
        ->table('projekte')
        ->get();

        $projectList = json_decode($projektData, true);
        $refinedProjektList = array();
        foreach($projectList as $key => $data){
            $refinedProjektList['ds_id'][$data['ds_id']]['bezeichnung'] = $data['bezeichnung'];
        }
        return $refinedProjektList;
    }

    public function refineUserList($userList, $departmentList, $projectList){
        for($i = 0; $i < count($userList); $i++){
            $status;
            $today = date("Y-m-d");

            if(($userList[$i]['austritt'] > $today) || $userList[$i]['austritt'] == ''){
                $status = 'active';
            } else {
                $status = 'inactive';
            }
            
            $refinedUserList[$status][$i]['ds_id'] = $userList[$i]['ds_id'];
            $refinedUserList[$status][$i]['kdw_id'] = $userList[$i]['pers_nr'];
            $refinedUserList[$status][$i]['kdw_kennung'] = $userList[$i]['agent_id'];
            $refinedUserList[$status][$i]['vorname'] = $userList[$i]['vorname'];
            $refinedUserList[$status][$i]['name'] = $userList[$i]['familienname'];
            $refinedUserList[$status][$i]['projekt_id'] = $userList[$i]['projekt_id'];
            if($refinedUserList[$status][$i]['projekt_id'] != 0){
                $refinedUserList[$status][$i]['projekt_kennzeichnung'] = $projectList['ds_id'][$refinedUserList[$status][$i]['projekt_id']]['bezeichnung'];
            } else {
                $refinedUserList[$status][$i]['projekt_kennzeichnung'] = '';
            }
            $refinedUserList[$status][$i]['funktions_id'] = $userList[$i]['abteilung_id'];
            $refinedUserList[$status][$i]['funktions_kennzeichnung'] = $departmentList['ds_id'][$refinedUserList[$status][$i]['funktions_id']]['bezeichnung'];
            $refinedUserList[$status][$i]['plz'] = $userList[$i]['plz'];
            $refinedUserList[$status][$i]['ort'] = $userList[$i]['ort'];
            $refinedUserList[$status][$i]['strasse'] = $userList[$i]['strasse'];
            $refinedUserList[$status][$i]['geburtstag'] = $userList[$i]['geburt'];
            $refinedUserList[$status][$i]['geschlecht'] = $userList[$i]['geschlecht'];
            $refinedUserList[$status][$i]['telefon'] = $userList[$i]['telefon'];
            $refinedUserList[$status][$i]['handy'] = $userList[$i]['handy'];
            $refinedUserList[$status][$i]['email'] = $userList[$i]['email'];
            $refinedUserList[$status][$i]['eintritt'] = $userList[$i]['eintritt'];
            $refinedUserList[$status][$i]['austritt'] = $userList[$i]['austritt'];
            $refinedUserList[$status][$i]['soll_h_day'] = $userList[$i]['soll_h_day'];
            $refinedUserList[$status][$i]['soll_h_woche'] = $refinedUserList[$status][$i]['soll_h_day'] * 5;
            $refinedUserList[$status][$i]['fte'] = $refinedUserList[$status][$i]['soll_h_day'] * 5 / 40;
        }
        //dd($refinedUserList);
        return $refinedUserList;
    }
}

