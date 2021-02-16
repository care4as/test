<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\Right;


class RolesController extends Controller
{
    public function index()
    {
      $roles = Role::all();
      $rights = Right::all();

      return view('RoleIndex', compact('roles', 'rights'));
    }
    public function store(Request $request)
    {

      $request->validate([
        'rolename' => 'required | unique:roles,name',
        'rights' => 'required',
      ]);

      $role = new Role;
      $role->name = $request->rolename;
      $role->save();

      foreach($request->rights as $right)
      {
        DB::table('roles_has_rights')
        ->insert([
          'role_id' => $role->id,
          'rights_id' => $right,
        ]);
      }
      return redirect()->back();
    }
    public function delete($id)
    {
      Role::where('id',$id)->delete();
      DB::table('roles_has_rights')
      ->where('role_id',$id)
      ->delete();

      return redirect()->back();
    }
    public function show($id)
    {
      $role = Role::find($id);
      $rights = Right::all();
      $role->Rights();

      return view('roleShow', compact('role','rights'));
    }
    public function update($id, Request $request)
    {
      $role = Role::find($id);
      DB::table('roles_has_rights')->where('role_id', $id)->delete();

      foreach($request->rights as $rightid)
      {
        DB::table('roles_has_rights')->insert(
            [
            'role_id' => $role->id,
            'rights_id' => $rightid
            ]);
      }


      return redirect()->back();
    }
}
