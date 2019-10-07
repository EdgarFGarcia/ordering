<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageGuestController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
        ini_set('max_execution_time', 900);
//        $this->middleware('auth');
        $this->middleware('guest');
    }

    public function login()
    {
        return $this->theme->of('pages.login')->render();
    }
}
