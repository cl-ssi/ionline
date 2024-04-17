<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IonlinePlusController extends Controller
{
    public function __invoke()
    {
        $login = DB::table('sessions')
            ->where('user_id', auth()->id())
            ->where('last_activity', '<', time() + 60 * 15)
            ->first();

        if($login) {
            return redirect(env('IONLINE_PLUS_URL').'/ionline/login/' . $login->id);
        }
        else {
            return redirect()->route('home');
        }
    }
}
