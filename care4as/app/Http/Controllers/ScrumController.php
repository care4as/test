<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ScrumController extends Controller
{
    public function init(){
        $scrum_data = DB::table('it_kanban_board')
        ->get()
        ->toArray();

        //dd($scrum_data);

        $scrum_entries = array();
        foreach($scrum_data as $key => $entry){
            $entry = (array) $entry;

            $scrum_entries[$entry['status']][$entry['id']]['id'] = $entry['id'];
            $scrum_entries[$entry['status']][$entry['id']]['title'] = $entry['title'];
            $scrum_entries[$entry['status']][$entry['id']]['description'] = $entry['description'];
            $scrum_entries[$entry['status']][$entry['id']]['status'] = $entry['status'];
            $scrum_entries[$entry['status']][$entry['id']]['priority'] = $entry['priority'];
            $scrum_entries[$entry['status']][$entry['id']]['due_date'] = $entry['due_date'];
            $scrum_entries[$entry['status']][$entry['id']]['reviser'] = $entry['reviser'];
        }

        //dd($scrum_entries);

        return view('scrum.itkanbanboard', compact('scrum_entries'));
    }

    public function add(){
        $newEntry = array();

        $newEntry['status'] = request('status');
        $newEntry['priority'] = request('priority');
        $newEntry['due_date'] = request('due_date');
        $newEntry['reviser'] = request('reviser');
        $newEntry['title'] = request('title');
        $newEntry['description'] = request('description');

        DB::table('it_kanban_board')->insertOrIgnore($newEntry);

        return redirect()->back();
    }

    public function update(){
        $newEntry = array();

        $newEntry['id'] = request('id');
        $newEntry['status'] = request('status');
        $newEntry['priority'] = request('priority');
        $newEntry['due_date'] = request('due_date');
        $newEntry['reviser'] = request('reviser');
        $newEntry['title'] = request('title');
        $newEntry['description'] = request('description');

        DB::table('it_kanban_board')
            ->where('id', $newEntry['id'])
            ->update(
            [
                'status' => $newEntry['status'],
                'priority' => $newEntry['priority'],
                'due_date' => $newEntry['due_date'],
                'reviser' => $newEntry['reviser'],
                'title' => $newEntry['title'],
                'description' => $newEntry['description'],
            ]
        );

        return redirect()->back();
    }

    public function delete(){
        DB::table('it_kanban_board')
        ->where('id', request('id'))
        ->delete();
        
        return redirect()->back();
    }

}