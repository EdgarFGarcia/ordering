<?php

namespace App\Http\Controllers;


use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response AS Response2;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Http\JsonResponse;

class ApiAuthController extends PublicController
{

    public function validateGuestPromoCode()
    {
//        dd(Input::all());
        $getPromoCodeId = Input::get('promoCodeId');

        $getGuestPromoCode = DB::connection('mysqlrms')->table('tbl_guest_promo_code')->where("id",$getPromoCodeId)->first();
        if($getGuestPromoCode){
            $seriesId = $getGuestPromoCode->seriesid;
            $controlno = $getGuestPromoCode->controlno;
            $roomno = $getGuestPromoCode->roomno;

            $promo_code = $getGuestPromoCode->promo_code;
            $promo_code_type = $getGuestPromoCode->promo_code_type;
            $promo_code_value = $getGuestPromoCode->promo_code_value;

//            $checkIfValid = $this->checkIfRoomIsValidTemp($roomno,$controlno);

//            if($checkIfValid) {
            if($promo_code_type=="ITEM"){
                $getItems1 = DB::connection("mysqlrms")->table("tbl_guest_promo_code_item")->where("promo_code",$promo_code)->get();
                foreach($getItems1 as $aRowI){
                    $item_no = $aRowI->item_no;
                    $checkItemNo = DB::connection("mysqlhms")->table("tbl_postrans_temp")
                        ->where("room_no",$roomno)
                        ->where("ControlNo",$controlno)
                        ->where("itemno",$item_no)
                        ->first();
                    if(!$checkItemNo){
                        return Response2::json(array("status"=>"Item(s) not tally on POS"));
                    }
                }

            } else {
                $getDiscountdetails = DB::connection("mysqlhms")
                    ->table("tblpostingdiscount_temp")
                    ->where("SeriesID",$seriesId)
                    ->where("ControlNo",$controlno)
                    ->where("RoomNo",$roomno)
                    ->where("discCode",$promo_code)
                    ->first();
                if(!$getDiscountdetails){
                    $getDiscountdetails = DB::connection("mysqlhms")
                        ->table("tblpostingdiscount")
                        ->where("SeriesID",$seriesId)
                        ->where("ControlNo",$controlno)
                        ->where("RoomNo",$roomno)
                        ->where("discCode",$promo_code)
                        ->first();
                }
                if($getDiscountdetails) {
                    if($promo_code_type=="ROOM DISC. BY %") {
                        $cashierDisc = $getDiscountdetails->discPer;
                        if($cashierDisc!=$promo_code_value) {
                            return Response2::json(array("status"=>"Room Disc by % is not tally on POS"));
                        }

                    } else if($promo_code_type=="ROOM DISC. BY AMOUNT") {
                        $cashierDisc = $getDiscountdetails->DiscountAmount;
                        if($cashierDisc!=$promo_code_value) {
                            return Response2::json(array("status"=>"Room Disc by Amount is not tally on POS"));
                        }
                    }
                } else {
                    return Response2::json(array("status"=>"Promo code not yet on POS"));
                }

            }
//            } else {
//                return Response::json(array("status"=>"Room already check outå"));
//            }

        } else {
            return Response2::json(array("status"=>"Invalid Code"));
        }
        return Response2::json(array("status"=>"Success"));


    }


    public function loadGuestOrder()
    {

        $pending = DB::connection("mysqlrms")
            ->table("tbl_guest_order")
            ->where("status","1")
            ->where("controlno","<>","TO")
            ->select(DB::raw("
                 DISTINCT 
                    transno,
                    controlno,
                    roomno,
                    remarks,
                    order_sound
            "))
            ->orderBy("id","ASC")
            ->get();
        $dataMain = [];
        $triggerSound = 1;
        foreach ($pending as $aRow) {
            $transno = $aRow->transno;
            $controlno = $aRow->controlno;
            $roomno = $aRow->roomno;
            $remarks = $aRow->remarks;
            $order_sound = $aRow->order_sound;

            $dataItems = [];

            $pendingD = DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("transno",$transno)
                ->where("controlno",$controlno)
                ->where("roomno",$roomno)
                ->where("status","1")
                ->get();

            if($order_sound==0){
                $triggerSound = 0;
            }

            DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("transno",$transno)
                ->where("controlno",$controlno)
                ->where("roomno",$roomno)
                ->where("status","1")
                ->update(array("order_sound"=>1));

            $dataMain[] = array(
                "transno" => $transno,
                "controlno" => $controlno,
                "roomno" => $roomno,
                "remarks" => $remarks,
                "order_sound" => $order_sound,
                "itemList" => $pendingD
            );
        }

        $dataPromoCode = [];
        $loadPromoCode = DB::connection("mysqlrms")
            ->table("tbl_guest_promo_code")
            ->where("status","0")
            ->get();
        foreach ($loadPromoCode as $aRowPromoCode) {
            if($aRowPromoCode->order_sound==0){
                $triggerSound = 0;
            }
            DB::connection("mysqlrms")
                ->table("tbl_guest_promo_code")
                ->where("id",$aRowPromoCode->id)
                ->update(array("order_sound"=>1));

            $promoCodeDetails = "";

            $promoCodeType = $aRowPromoCode->promo_code_type;
            $promoCodeValue = $aRowPromoCode->promo_code_value;

            $promoCodeRoomType = "";

            $getRoomType = DB::connection("mysqlrms")->table("tbl_guest_promo_code_roomtype")->where("promo_code",$aRowPromoCode->promo_code)->get();

            foreach($getRoomType as $aRow1) {
                $roomType = $aRow1->room_type;
                $promoCodeRoomType = $promoCodeRoomType.$roomType." <br/>";
            }


            if($promoCodeType=="ITEM"){
                $items = "";

                $getItem = DB::connection("mysqlrms")->table("tbl_guest_promo_code_item")->where("promo_code",$aRowPromoCode->promo_code)->get();

                foreach ($getItem as $aRow2) {
                    $item_no = $aRow2->item_no;
                    $item_name = $aRow2->item_name;
                    $items = $items."<b>".$item_name."</b></br>";
                }

                $promoCodeDetails = $items;


            } else if($promoCodeType=="ROOM DISC. BY %") {
                $promoCodeDetails = "<b>".$promoCodeValue."%</b> Discount on room charge <br/> Room Type: ".$promoCodeRoomType;
            } else if($promoCodeType=="ROOM DISC. BY AMOUNT") {
                $promoCodeDetails = "<b>".$promoCodeValue." pesos</b> Discount on room charge <br/> Room Type: <b>".$promoCodeRoomType."</b>";
            }

            $dataPromoCode[] = array(
                "id"=>$aRowPromoCode->id,
                "RoomNo"=>$aRowPromoCode->roomno,
                "DiscountCode"=>$aRowPromoCode->promo_code,
                "PromoCodeDetails" => $promoCodeDetails
            );
        }
        $pendCheckOut = DB::connection("mysqlrms")->table("tbl_guest_request_checkout")
            ->where("status","0")
            ->get();
        $dataCheckOut = [];
        foreach ($pendCheckOut as $arrow) {
            $id = $arrow->id;
            $order_sound = $arrow->order_sound;
            if($order_sound==0){
                $triggerSound = 0;
            }
            DB::connection("mysqlrms")
                ->table("tbl_guest_request_checkout")
                ->where("id",$id)
                ->update(array("order_sound"=>1));

            $roomno = $arrow->roomno;
            $dataCheckOut[] = array(
                "id"=>$id,
                "roomno"=>$roomno
            );
        }

        $data = array(
            "guestRequest" => $dataMain,
            "guestRequestPromoCode" => $dataPromoCode,
            "guestRequestCheckOut" => $dataCheckOut,
            "triggerSound" => $triggerSound
        );
        return Response2::json($data);
    }
    public function loadEmployeeOrder()
    {

        $pending = DB::connection("mysqlrms")
            ->table("tbl_guest_order")
            ->where("status","1")
            ->where("controlno","TO")
            ->select(DB::raw("
                 DISTINCT 
                    transno,
                    controlno,
                    roomno,
                    remarks,
                    order_sound
            "))
            ->orderBy("id","ASC")
            ->get();
//        dd($pending);
        $dataMain = [];
        $triggerSound = 1;
        foreach ($pending as $aRow) {
            $transno = $aRow->transno;
            $controlno = $aRow->controlno;
            $roomno = $aRow->roomno;
            $remarks = $aRow->remarks;
            $order_sound = $aRow->order_sound;

            $employeeName = "";
            if(intval($roomno)>=10000){
                $getEmployeeName = DB::connection("mysqlhms")
                    ->table("tblcustemployee")
                    ->where("empID",$roomno)
                    ->where("empStat","Active")
                    ->first();
                if($getEmployeeName) {
                    $employeeName = $roomno.": ".$getEmployeeName->empName;
                } else {
                    $getEmpoyeeInfo = DB::connection("mysqlitd")
                        ->table("vc_employees")
                        ->where("username",$roomno)
                        ->first();
                    DB::connection("mysqlhms")
                        ->table("tblcustemployee")
                        ->insert(array(
                            "empID" => $getEmpoyeeInfo->username,
                            "empLName" => $getEmpoyeeInfo->lname,
                            "empFName" => $getEmpoyeeInfo->fname,
                            "empName" => $getEmpoyeeInfo->lname.", ".$getEmpoyeeInfo->fname,
                            "empAddress" => $getEmpoyeeInfo->locale,
                            "empStat" => 'Active'
                        ));
                    $employeeName = $getEmpoyeeInfo->username.": ".$getEmpoyeeInfo->lname.", ".$getEmpoyeeInfo->fname;
                }

            }

            $dataItems = [];

            $pendingD = DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("transno",$transno)
                ->where("controlno",$controlno)
                ->where("roomno",$roomno)
                ->where("status","1")
                ->get();

            if($order_sound==0){
                $triggerSound = 0;
            }

            DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("transno",$transno)
                ->where("controlno",$controlno)
                ->where("roomno",$roomno)
                ->where("status","1")
                ->update(array("order_sound"=>1));

            $dataMain[] = array(
                "transno" => $transno,
                "controlno" => $controlno,
                "roomno" => $roomno,
                "employeeName" => $employeeName,
                "remarks" => $remarks,
                "order_sound" => $order_sound,
                "itemList" => $pendingD
            );
        }




        $data = array(
            "employeeRequest" => $dataMain,
            "triggerSound" => $triggerSound
        );
        return Response2::json($data);
    }

    public function disapprovedGuestOrder()
    {
        $transno = Input::get("transno");
        $controlno = Input::get("controlno");
        $roomno = Input::get("roomno");
        DB::connection("mysqlrms")
            ->table("tbl_guest_order")
            ->where("transno",$transno)
            ->where("controlno",$controlno)
            ->where("roomno",$roomno)
            ->update(array(
                "status" => "3",

            ));
        return Response2::json(array("status"=>"Success"));
    }
    public function removePromoCode()
    {
        $getId = Input::get("getid");
        DB::connection("mysqlrms")
            ->table("tbl_guest_promo_code")
            ->where("id",$getId)
            ->update(array(
                "status" => "1",

            ));
        return Response2::json(array("status"=>"Success"));
    }
    public function removeCheckOut()
    {
        $getId = Input::get("getid");
        DB::connection("mysqlrms")
            ->table("tbl_guest_request_checkout")
            ->where("id",$getId)
            ->update(array(
                "status" => "1",

            ));
        return Response2::json(array("status"=>"Success"));
    }
    public function employeeRemoveOrder()
    {
        $transno = Input::get("transno");
        $controlno = Input::get("controlno");
        $roomno = Input::get("roomno");
        DB::connection("mysqlrms")
            ->table("tbl_guest_order")
            ->where("transno",$transno)
            ->where("controlno",$controlno)
            ->where("roomno",$roomno)
            ->update(array(
                "status" => "3",

            ));
        return Response2::json(array("status"=>"Success"));
    }
    public function approvedGuestOrder()
    {
        $transno = Input::get("transno");
        $controlno = Input::get("controlno");
        $roomno = Input::get("roomno");

        $checkIfOpen = DB::connection("mysqlhms")
            ->table("tblroom")
            ->where("RoomNo",$roomno)
            ->first();
        if($checkIfOpen->xAct=="1"){
            return Response2::json(array("status"=>"Room in use on POS (Please close the ROOM details)"));
        }

        $checkIfValid = $this->checkIfRoomIsValidTemp($roomno,$controlno);

        if($checkIfValid) {
            $pending = DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("transno",$transno)
                ->where("controlno",$controlno)
                ->where("roomno",$roomno)
                ->get();

            foreach ($pending as $aRow) {
                $id = $aRow->id;
                $transno = $aRow->transno;
                $controlno = $aRow->controlno;
                $roomno = $aRow->roomno;
                $item_no = $aRow->item_no;
                $item_name = $aRow->item_name;
                $qty = $aRow->qty;
                $notes = $aRow->remarks;


                $getItemDetails = DB::connection("mysqlhms")
                    ->table("tbl_itemlist")
                    ->where("item_no",$item_no)
                    ->where("ItemStat","Active")
                    ->first();

                $getRoomDetails = DB::connection("mysqlhms")
                    ->table("tblroom")
                    ->where("RoomNo",$roomno)
                    ->first();
                $shiftno =  DB::connection("mysqlhms")->table("tblshift")->orderBy("id","DESC")->limit(1)->first();

                $getlastTrans = DB::connection("mysqlhms")->table("tbltransactionposting")->orderBy("id","DESC")->limit(1)->first();

//                $transno = "POS2".$transno."-".$controlno;

                $getDdate = DB::select(DB::raw("SELECT now() as now1"));
                $getDdateVal = "";
                foreach ($getDdate as $getD) {
                    $getDdateVal = $getD->now1;
                }

                DB::connection("mysqlhms")
                    ->table("tblsoa")
                    ->where("ControlNo",$controlno)
                    ->delete();
                DB::connection("mysqlhms")
                    ->table("tblroom")
                    ->where("RoomNo",$roomno)
                    ->update(array(
                        "CRoom_Stat" => "2"
                    ));

                $data = array(
                    "TransNo" => $transno,
                    "room_no" => $roomno,
                    "ControlNo" => $controlno,
                    "notes" => $notes,
                    "itemno" => $item_no,
                    "itemname" => $item_name,
                    "qty" => $qty,
                    "cost" => $getItemDetails->unit_cost,
                    "price" => $getItemDetails->unit_price,
                    "classification" => $getItemDetails->classification,
                    "category" => $getItemDetails->category,
                    "Bump" => "0",
                    "xDate" => $getDdateVal,
                    "xTime" => $getDdateVal,
                    "ShiftNo" => $shiftno->shiftNo,
                    "xUser" => $getlastTrans->xuser,
                    "Cashier" => $getlastTrans->Cashier,
                    "xStat" => 'Printed',
                    "MachineNo" => "2",
                    "orgMachineNo" => "2",
                    "orderTaker" => Auth::user()->username,
                    "Area" => $getRoomDetails->RoomArea,
                );

                $getId = DB::connection("mysqlhms")
                    ->table("tbl_postrans_temp")
                    ->insertGetId($data);
                $data = array(
                    "id" => $getId,
                    "TransNo" => $transno,
                    "room_no" => $roomno,
                    "ControlNo" => $controlno,
                    "notes" => $notes,
                    "itemno" => $item_no,
                    "itemname" => $item_name,
                    "qty" => $qty,
                    "cost" => $getItemDetails->unit_cost,
                    "price" => $getItemDetails->unit_price,
                    "classification" => $getItemDetails->classification,
                    "category" => $getItemDetails->category,
                    "Bump" => "0",
                    "xDate" => $getDdateVal,
                    "xTime" => $getDdateVal,
                    "ShiftNo" => $shiftno->shiftNo,
                    "xUser" => $getlastTrans->xuser,
                    "Cashier" => $getlastTrans->Cashier,
                    "xStat" => 'Printed',
                    "MachineNo" => "2",
                    "orgMachineNo" => "2",
                    "orderTaker" => Auth::user()->username,
                    "Area" => $getRoomDetails->RoomArea,
                );
                DB::connection("mysqlhms")
                    ->table("tbl_postrans_kds")
                    ->insert($data);
                DB::connection("mysqlrms")
                    ->table("tbl_guest_order")
                    ->where("id",$id)
                    ->update(array(
                        "status" => "2",

                    ));

            }
        } else {
            DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("transno",$transno)
                ->where("controlno",$controlno)
                ->where("roomno",$roomno)
                ->update(array(
                    "status" => "2",

                ));
            return Response2::json(array("status"=>"Failed"));
        }




        return Response2::json(array("status"=>"Success"));

    }

    public function saveFeedback()
    {
        $roomNo = Input::get("roomNo");
        $serviceRating = Input::get("serviceRating");
        $roomRating = Input::get("roomRating");
        $foodRating = Input::get("foodRating");
        $feedbackRemarks = Input::get("feedbackRemarks");
        //javier
        $checkIfRoomIsValid = $this->checkIfRoomIsValidTemp($roomNo,'');
        if($checkIfRoomIsValid){
            $roomNo = $checkIfRoomIsValid->RoomNo;
            $controlNo = $checkIfRoomIsValid->ControlNo;


        }

        return Response2::json(array("status"=>"Success"));
    }
    


    function checkIfRoomIsValidTemp($roomNoMD5,$controlno)
    {
        if($controlno==''){
            $checkIfIn = DB::connection("mysqlhms")
                ->table("tblcustomerinfo_temp")
                ->whereRaw("
                    RoomNo = '".$roomNoMD5."' 
                ")
                ->first();
        } else {

            $checkIfIn = DB::connection("mysqlhms")
                ->table("tblcustomerinfo_temp")
                ->whereRaw("
                    RoomNo = '".$roomNoMD5."' 
                    AND ControlNo = '".$controlno."'
                ")
                ->first();
        }
        if(!$checkIfIn){
            $checkIfIn = DB::table("users")
                ->whereRaw("
                    username = '".$roomNoMD5."'
                ")
                ->select(DB::raw("username AS RoomNo, 'TO' AS ControlNo"))
                ->first();
        }
        return $checkIfIn;
    }

    public function loadRoom()
    {
//        $pending = DB::connection("mysqlhms")->table("tblroom")->orderBy("last_checkOut","DESC")->get();
        $pending = DB::connection("mysqlhms")->table("tblroom")->orderBy("RoomNo","ASC")->get();
        $data = array("room"=>$pending);

        return Response2::json($data);
    }

    public function loadRoomTransaction()
    {
        $roomNo = Input::get('roomNo');

        $pending = DB::connection("mysqlhms")
            ->select(DB::raw("
                SELECT SeriesID,ControlNo,RoomNo,DateIn,DateOut,TimeIn,TimeOut
                FROM 
                  tblcustomerinfo
                WHERE RoomNo = '$roomNo'
                ORDER BY DateOut DESC, TimeOut DESC LIMIT 3
            "));

        return Response2::json(array("rooms"=>$pending));

    }

    public function saveGuestFeedbackCashier()
    {
//        dd(Input::all());
        $seriesid = Input::get("seriesid");
        $controlno = Input::get("controlno");
        $roomno = Input::get("roomno");
        $feedType = Input::get("feedType");
        $feedSubType = Input::get("feedSubType");
        $feedRemarks = Input::get("feedRemarks");

        $checkifExist = DB::connection("mysqlrms")
            ->table("tbl_guest_feedback_cashier")
            ->where("seriesno",$seriesid)
            ->where("controlno",$controlno)
            ->where("roomno",$roomno)
            ->where("feedback_type",$feedType)
            ->where("feedback_subtype",$feedSubType)
            ->first();
        if($checkifExist){
            DB::connection("mysqlrms")
                ->table("tbl_guest_feedback_cashier")
                ->where("seriesno",$seriesid)
                ->where("controlno",$controlno)
                ->where("roomno",$roomno)
                ->where("feedback_type",$feedType)
                ->where("feedback_subtype",$feedSubType)
                ->update(array(
                    "feedback_type"=>$feedType,
                    "feedback_desc"=>$feedRemarks
                ));
        } else {
            DB::connection("mysqlrms")
                ->table("tbl_guest_feedback_cashier")
                ->insert(array(
                    "seriesno" => $seriesid,
                    "controlno" => $controlno,
                    "roomno" => $roomno,
                    "feedback_type" => $feedType,
                    "feedback_subtype" => $feedSubType,
                    "feedback_desc" => $feedRemarks,
                    "createdby" => Auth::user()->username
                ));
        }


    }
    public function loadGuestFeedbackByTypeOrSubtype()
    {
        $getType = Input::get("getType");
        $getSubtype = Input::get("getSubtype");
        $seriesId = Input::get("seriesid");
        $roomNo = Input::get("roomno");
        $controlNo = Input::get("controlno");
//        dd(Input::all());
        $pendingA = DB::connection("mysqlrms")
            ->table("tbl_guest_feedback_cashier")
            ->where("seriesno", $seriesId)
            ->where("controlno", $controlNo)
            ->where("roomno", $roomNo)
            ->where("feedback_type", $getType)
            ->where("feedback_subtype", $getSubtype)
            ->first();

        $remarks = "";
        if($pendingA) {
            $remarks = $pendingA->feedback_desc;
        }
        return Response2::json(array("remarks"=>$remarks));

    }
    public function loadGuestFeedback()
    {
        $seriesId = Input::get("seriesId");
        $roomNo = Input::get("roomNo");
        $controlNo = Input::get("controlNo");

        $service = $this->getGuestFeedbackByType($roomNo,$controlNo,$seriesId,"Service");
        $room = $this->getGuestFeedbackByType($roomNo,$controlNo,$seriesId,"Room");
        $food = $this->getGuestFeedbackByType($roomNo,$controlNo,$seriesId,"Food");


        $pendingA = DB::connection("mysqlrms")
            ->table("tbl_guest_feedback_cashier")
            ->where("seriesno", $seriesId)
            ->where("controlno", $controlNo)
            ->where("roomno", $roomNo)
            ->first();
//        dd($pendingA);
        $feedType = "";
        $feedSubType = "";
        $feedRemarks = "";
        if($pendingA){

            $feedType = $pendingA->feedback_type;
            $feedSubType = $pendingA->feedback_subtype;
            $feedRemarks = $pendingA->feedback_desc;
        }

//        dd($service);
        $data = array(
            "SeriesId" => $seriesId,
            "RoomNo" => $roomNo,
            "ControlNo" => $controlNo,
            "Room" => $service->roomno,
            "ServiceStar" => $service->rating_value,
            "ServiceRemarks" => $service->rating_remarks,
            "RoomStar" => $room->rating_value,
            "RoomRemarks" => $room->rating_remarks,
            "FoodStar" => $food->rating_value,
            "FoodRemarks" => $food->rating_remarks,
            "guestFeedType" => $feedType,
            "guestFeedSubType" => $feedSubType,
            "guestFeedRemarks" => $feedRemarks,
        );
        return Response2::json($data);


    }

    function getGuestFeedbackByType($roomNo,$controlNo,$seriesId,$ratingType)
    {
        $pending = DB::connection("mysqlrms")
            ->table("tbl_guest_feedback")
            ->where("roomno",$roomNo)
            ->where("controlno",$controlNo)
            ->where("seriesid",$seriesId)
            ->where("rating_type",$ratingType)
            ->first();
        if($pending){
            return $pending;
        } else {
//            $datata = '{"roomno":'.$roomNo.'}';

//            $pending1 = [];
//            $pending1->roomno = $roomNo;
//            $pending1->controlno = $controlNo;
//            $pending1->seriesid = $seriesId;
//            $pending1->rating_type = $ratingType;
//            $pending1->rating_value = "0";
//            $pending1->rating_remarks = "";
//            return json_encode($pending1);

            $pending = collect(DB::select(DB::raw(" SELECT 
            '$roomNo' AS roomno,
            '$controlNo' AS controlno,
            '$seriesId' AS seriesid,
            '$ratingType' AS rating_type,
            '0' AS rating_value,
            '' AS rating_remarks")))->first();
            return $pending;
//            return (array(
//                "roomno" => $roomNo,
//                "controlno" => $controlNo,
//                "seriesid" => $seriesId,
//                "rating_type" => $ratingType,
//                "rating_value" => "0",
//                "rating_remarks" => ""
//            ));
        }
    }

    public function changeQTYbyId()
    {
        $getType = Input::get("getType");
        $getId = Input::get("getId");

        if($getType=="ADD"){
            DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("id",$getId)
                ->update(array(
                    "qty" => DB::raw("qty+1")
                ));

        } else if($getType=="SUB") {
            $checkifZero = DB::connection("mysqlrms")
                    ->table("tbl_guest_order")
                    ->where("id",$getId)
                    ->first();
            if($checkifZero) {
                if($checkifZero->qty-1 <= 0){
                    DB::connection("mysqlrms")
                        ->table("tbl_guest_order")
                        ->where("id",$getId)
                        ->delete();
                }
            }
            DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("id",$getId)
                ->update(array(
                    "qty" => DB::raw("qty-1")
                ));
        } else {
            DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->where("id",$getId)
                ->delete();
        }

    }

    public function loadGuestOrderHistory()
    {
        $startdate = Input::get("startdate");
        $enddate = Input::get("enddate");

        $pending = DB::connection("mysqlrms")
            ->table("tbl_guest_order")
            ->whereRaw("DATE(datecreated) BETWEEN '$startdate' AND '$enddate' AND controlno <> 'TO' ")
            ->orderBy("datecreated","DESC")
            ->get();

        return Response2::json(array("content"=>$pending));
    }
    public function loadGuestPromoHistory()
    {
        $startdate = Input::get("startdate");
        $enddate = Input::get("enddate");

        $pending1 = DB::connection("mysqlrms")
            ->select(DB::raw("
                SELECT 
                 seriesid AS seriesid,
                 roomno AS roomno,
                 promo_code AS discountCode,
                 datecreated AS datecreated
                FROM tbl_guest_promo_code
                WHERE DATE(datecreated) BETWEEN '$startdate' AND '$enddate' 
                ORDER BY id DESC
            "));
        $pending2 = DB::connection("mysqlrms")
            ->select(DB::raw("
                SELECT 
                 seriesid AS seriesid,
                 controlno AS controlno,
                 roomno AS roomno,
                 promo_code AS promo_code,
                 promo_code_type AS promo_code_type,
                 promo_code_value AS promo_code_value,
                 datecreated AS datecreated
                FROM tbl_guest_promo_code
                WHERE DATE(datecreated) BETWEEN '$startdate' AND '$enddate' 
                ORDER BY id DESC
            "));
        
        $content2 = [];
        foreach($pending2 as $aRow2) {

            $seriesid = $aRow2->seriesid;
            $roomno = $aRow2->roomno;
            $controlno = $aRow2->controlno;
            $discountCode = $aRow2->promo_code;
            $promo_code_type = $aRow2->promo_code_type;
            $promo_code_value = $aRow2->promo_code_value;
            $datecreated = $aRow2->datecreated;
            if($promo_code_type=="ROOM DISC. BY AMOUNT"){
                $checkifExiston = DB::connection("mysqlhms")
                    ->table("tblpostingdiscount_temp")
                    ->where("SeriesID",$seriesid)
                    ->where("discType","By Amount")
                    ->where("discCode",$discountCode)
                    ->where("DiscountAmount",$promo_code_value)
                    ->first();
                if(!$checkifExiston){
                    $checkifExiston = DB::connection("mysqlhms")
                        ->table("tblpostingdiscount")
                        ->where("SeriesID",$seriesid)
                        ->where("discType","By Amount")
                        ->where("discCode",$discountCode)
                        ->where("DiscountAmount",$promo_code_value)
                        ->first();
                }
            } else if($promo_code_type=="ROOM DISC. BY %"){
                $checkifExiston = DB::connection("mysqlhms")
                    ->table("tblpostingdiscount_temp")
                    ->where("SeriesID",$seriesid)
                    ->where("discType","By Percentage")
                    ->where("discCode",$discountCode)
                    ->where("discPer",$promo_code_value)
                    ->first();
                if(!$checkifExiston){
                    $checkifExiston = DB::connection("mysqlhms")
                        ->table("tblpostingdiscount")
                        ->where("SeriesID",$seriesid)
                        ->where("discType","By Percentage")
                        ->where("discCode",$discountCode)
                        ->where("discPer",$promo_code_value)
                        ->first();
                }
            } else {
                $pendinggetItem = DB::connection("mysqlrms")
                    ->select(DB::raw("
                    SELECT 
                     seriesid AS seriesid,
                     controlno AS controlno,
                     roomno AS roomno,
                     promo_code AS promo_code,
                     item_no AS item_no,
                     item_name AS item_name
                    FROM tbl_guest_promo_code_item
                    WHERE seriesid = '$seriesid' AND controlno = '$controlno'
                    ORDER BY id DESC
                "));
                foreach ($pendinggetItem as $aRow11) {
                    $item_no = $aRow11->item_no;

                    $checkItem = DB::connection("mysqlhms")->table("tbl_postrans_temp")->where("ControlNo",$controlno)->where("itemno",$item_no)->first();
                    if(!$checkItem){
                        $checkItem = DB::connection("mysqlhms")->table("tbl_postransd")->where("ControlNo",$controlno)->where("item_no",$item_no)->first();
                    }
                    if(!$checkItem){
                        $checkifExiston = false;
                    }
                }
            }

            if(!$checkifExiston){
                $content2[] = array(
                    "seriesid" => $seriesid,
                    "roomno" => $roomno,
                    "discountCode" => $discountCode,
                    "datecreated" => $datecreated
                );
            }
        }

        $pending3 = DB::connection("mysqlhms")
            ->select(DB::raw("
                SELECT 
                 SeriesID AS seriesid,
                 RoomNo AS roomno,
                 discCode AS discountCode,
                 discType AS discountType,
                 DiscountAmount AS discountAmount,
                 discPer AS discountPer,
                 compDate AS datecreated
                FROM tblpostingdiscount 
                WHERE DATE(xdate) BETWEEN '$startdate' AND '$enddate' 
                AND LEFT(discCode,2) = 'VC' 
                ORDER BY id DESC 
            "));
        if(!$pending3){
            $pending3 = DB::connection("mysqlhms")
                ->select(DB::raw("
                SELECT 
                 SeriesID AS seriesid,
                 RoomNo AS roomno,
                 discCode AS discountCode,
                 discType AS discountType,
                 DiscountAmount AS discountAmount,
                 discPer AS discountPer,
                 compDate AS datecreated
                FROM tblpostingdiscount_temp
                WHERE DATE(xdate) BETWEEN '$startdate' AND '$enddate' 
                AND LEFT(discCode,2) = 'VC' 
                ORDER BY id DESC 
            "));
        }

        $content3 = [];
        foreach($pending3 as $aRow3){
            $seriesid = $aRow3->seriesid;
            $roomno = $aRow3->roomno;
            $discountCode = $aRow3->discountCode;
            $discountType = $aRow3->discountType;
            $discountAmount = $aRow3->discountAmount;
            $discountPer = $aRow3->discountPer;
            $datecreated = $aRow3->datecreated;
            if($discountType=="By Amount"){
                $checkifExiston = DB::connection("mysqlrms")
                    ->table("tbl_guest_promo_code")
                    ->where("seriesid",$seriesid)
                    ->where("promo_code",$discountCode)
                    ->where("promo_code_type","ROOM DISC. BY AMOUNT")
                    ->where("promo_code_value",$discountAmount)
                    ->first();
            } else if($discountType=="By Percentage"){
                $checkifExiston = DB::connection("mysqlrms")
                    ->table("tbl_guest_promo_code")
                    ->where("seriesid",$seriesid)
                    ->where("promo_code",$discountCode)
                    ->where("promo_code_type","ROOM DISC. BY %")
                    ->where("promo_code_value",$discountPer)
                    ->first();
            }

            if(!$checkifExiston){
                $content3[] = array(
                    "seriesid" => $seriesid,
                    "roomno" => $roomno,
                    "discountCode" => $discountCode,
                    "datecreated" => $datecreated
                );
            }
        }
        return Response2::json(array("content1"=>$pending1,"content2"=>$content2,"content3"=>$content3));
    }

    public function loadGuestFeedbackHistory()
    {
        $startdate = Input::get("startdate");
        $enddate = Input::get("enddate");

        $pending1 = DB::connection("mysqlrms")
            ->table("tbl_guest_feedback")
            ->leftjoin("hms.tblcustomerinfo AS b","tbl_guest_feedback.seriesid","=","b.SeriesID")
            ->whereRaw("DATE(datecreated) BETWEEN '$startdate' AND '$enddate' ")
            ->orderBy("tbl_guest_feedback.datecreated","DESC")
            ->get();
        $pending2 = DB::connection("mysqlrms")
            ->table("tbl_guest_feedback_cashier")
            ->leftjoin("hms.tblcustomerinfo AS b","tbl_guest_feedback_cashier.seriesno","=","b.SeriesID")
            ->whereRaw("DATE(datecreated) BETWEEN '$startdate' AND '$enddate' ")
            ->orderBy("tbl_guest_feedback_cashier.datecreated","DESC")
            ->get();
//        $pending2 = DB::connection("mysqlrms")
//            ->table("tbl_guest_feedback_cashier")
//            ->whereRaw("DATE(datecreated) BETWEEN '$startdate' AND '$enddate' ")
//            ->orderBy("id","DESC")
//            ->get();
        $pending3 = DB::connection("mysqlhms")
            ->select(DB::raw("
                SELECT * FROM (select
                    tblcustomerinfo.roomno as room,
                    tblcustomerinfo.controlno as controlno,
                    tblcustomerinfo.seriesid as seriesid,
                    tblcustomerinfo.DateOut as DateOut,
                    tblcustomerinfo.TimeOut as TimeOut
                    from tbltransactionposting inner join tblcustomerinfo on tbltransactionposting.ControlNo = tblcustomerinfo.ControlNo where
                    tblcustomerinfo.Stat = 'C/OUT' and
                    (tbltransactionposting.Description <> 'Advanced Deposit'
                    AND tbltransactionposting.xdate Between '".$startdate."' and '".$enddate."'
                    AND tbltransactionposting.voidStat = '')
                    OR (tbltransactionposting.Description = 'Advanced Deposit'
                    AND tbltransactionposting.usedADV = 'True'
                    AND tbltransactionposting.xdate Between '".$startdate."' and '".$enddate."'
                    AND tbltransactionposting.voidStat = '' ) union all
                select
                    tblcustomerinfo.roomno as room,
                    tblcustomerinfo.controlno as controlno,
                    tblcustomerinfo.seriesid as seriesid,
                    tblcustomerinfo.DateOut as DateOut,
                    tblcustomerinfo.TimeOut as TimeOut
                    from tbltransactionpostingfoc inner join tblcustomerinfo on tbltransactionpostingfoc.ControlNo = tblcustomerinfo.ControlNo where
                    tblcustomerinfo.Stat = 'C/OUT' and
                    (tbltransactionpostingfoc.Description <> 'Advanced Deposit'
                    AND tbltransactionpostingfoc.xdate Between '".$startdate."' and '".$enddate."'
                    AND tbltransactionpostingfoc.voidStat = '')
                    OR (tbltransactionpostingfoc.Description = 'Advanced Deposit'
                    AND tbltransactionpostingfoc.usedADV = 'True'
                    AND tbltransactionpostingfoc.xdate Between '".$startdate."' and '".$enddate."'
                    AND tbltransactionpostingfoc.voidStat = '' ) 
                ) table1 
                WHERE seriesid NOT IN (SELECT seriesno FROM vc_rms.tbl_guest_feedback_cashier WHERE DATE(datecreated) BETWEEN '$startdate' AND '$enddate' )
                ORDER BY DateOut DESC,TimeOut DESC
            "));
//        dd($pending3);
        return Response2::json(array("content1"=>$pending1,"content2"=>$pending2,"content3"=>$pending3));
    }


    public function loadEmployeeOrderHistory()
    {
        $startdate = Input::get("startdate");
        $enddate = Input::get("enddate");

        $pending = DB::connection("mysqlrms")
            ->table("tbl_guest_order AS a")
            ->leftjoin("hms.tblcustemployee AS b","a.roomno","=","b.empID")
            ->whereRaw("DATE(a.datecreated) BETWEEN '$startdate' AND '$enddate' AND a.controlno = 'TO' ")
            ->orderBy("a.datecreated","DESC")
            ->get();
//        dd($pending);
        return Response2::json(array("content"=>$pending));
    }

}
