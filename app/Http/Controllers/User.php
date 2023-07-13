<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class User extends Controller
{
    public function info(Request $request){

      $user=  Users::findOrFail($request->route('id'));
      $user=$user->toArray();
      unset($user['password']);
      return json_encode($user);
    }
}
