<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class PageAuthController extends PublicController
{
    public $this;
    public function __construct() {
        parent::__construct();
        ini_set('max_execution_time', 900);
        $this->middleware('auth');
    }

    public function employeeDashboard()
    {
        if(Auth::user()->role_id=="3"){
            return $this->theme->of("pages.employeeDashboard")->render();
        } else {
            dd("Cashier Account only");
        }
    }

}
