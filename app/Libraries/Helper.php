<?php

namespace App\Libraries;


use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\PageMeta;
use stdClass;

class Helper
{


    public static function role($user)
    {
        $roles = $user->roles;

        foreach($roles as $role)
        {
            return $role->role;
        }
    }


    public static function checkRole($user)
    {
        $roles = $user->roles;

        foreach($roles as $role)
        {
            return $role;
        }
    }

}
