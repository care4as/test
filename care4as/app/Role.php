<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    public function Rights()
    {
      // return $this->belongsToMany(Right::class, 'roles_has_rights', 'role_id', 'rights_id');
      $rightids = DB::table('roles_has_rights')->where('role_id',$this->id)->pluck('rights_id');
      $rights = DB::table('rights')->whereIn('id', $rightids)->pluck('name');
      $this->rights = $rights ;
    }
}
