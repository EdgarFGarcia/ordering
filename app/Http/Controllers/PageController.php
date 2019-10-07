<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageController extends PublicController
{
//    public function dashboard($roomNo)
//    {
//        $pending = DB::connection("mysqlhms")
//            ->table("tblroom")
//            ->whereRaw("md5(concat('victoriacourt',roomno)) = '".$roomNo."'")
//            ->first();
//        if($pending){
//            $checkIfIn = DB::connection("mysqlhms")
//                ->table("tblcustomerinfo_temp")
//                ->where("RoomNo",$pending->RoomNo)
//                ->first();
//            if(!$checkIfIn){
//                $data = array(
//                    "msg" => "This room is vacant"
//                );
//                return $this->theme->of('pages.noPermission',$data)->render();
//            }
//
//            $data = array(
//                "roomNo" => $roomNo
//            );
//            return $this->theme->of('pages.dashboard',$data)->render();
//        } else {
//            $data = array(
//                "msg" => "Permission Denied"
//            );
//
//        }
//        return $this->theme->of('pages.noPermission',$data)->render();
//    }
    public function home($roomNo)
    {
//        dd($roomNo);
        if($roomNo=="employee"){
            if(Auth::check()){

                $convertMd = DB::select(DB::raw("SELECT md5(concat('victoriacourt','".Auth::user()->username."')) as username"));
//                dd($convertMd[0]->username);
                $roomNo = $convertMd[0]->username;
                $data = array(
                    "roomNo" => $roomNo
                );
                return $this->theme->of('pages.home',$data)->render();
            } else {
                $data = array(
                    "msg" => "Permission Denied"
                );
            }
        } else {
            $pending = DB::connection("mysqlhms")
                ->table("tblroom")
                ->whereRaw("md5(concat('victoriacourt',roomno)) = '".$roomNo."'")
                ->first();
            if($pending){
                $checkIfIn = DB::connection("mysqlhms")
                    ->table("tblcustomerinfo_temp")
                    ->where("RoomNo",$pending->RoomNo)
                    ->first();
                if(!$checkIfIn){
                    $data = array(
                        "msg" => "This room is vacant"
                    );
                    return $this->theme->of('pages.noPermission',$data)->render();
                }

                $data = array(
                    "roomNo" => $roomNo
                );
                return $this->theme->of('pages.home',$data)->render();
            } else {
                $data = array(
                    "msg" => "Permission Denied"
                );

            }
        }

        return $this->theme->of('pages.noPermission',$data)->render();
    }
//    public function myFoodList($roomNo)
//    {
//        $pending = DB::connection("mysqlhms")
//            ->table("tblroom")
//            ->whereRaw("md5(concat('victoriacourt',roomno)) = '".$roomNo."'")
//            ->first();
//        if($pending){
//            $checkIfIn = DB::connection("mysqlhms")
//                ->table("tblcustomerinfo_temp")
//                ->where("RoomNo",$pending->RoomNo)
//                ->first();
//            if(!$checkIfIn){
//                $data = array(
//                    "msg" => "This room is vacant"
//                );
//                return $this->theme->of('pages.noPermission',$data)->render();
//            }
//
//            $data = array(
//                "roomNo" => $roomNo
//            );
//            return $this->theme->of('pages.myFoodList',$data)->render();
//        } else {
//            $data = array(
//                "msg" => "Permission Denied"
//            );
//
//        }
//        return $this->theme->of('pages.noPermission',$data)->render();
//    }

    


}
