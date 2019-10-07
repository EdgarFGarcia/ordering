<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApiController extends PublicController
{
    public function requestcheckOut()
    {
//        dd(Input::all());
        $roomNo = Input::get('roomNo');
        $checkIfIn = $this->checkIfRoomIsValidTemp($roomNo);
        if($checkIfIn){
            $seriesId = $checkIfIn->SeriesID;
            $controlNo = $checkIfIn->ControlNo;
            $roomNoA = $checkIfIn->RoomNo;
            $checkIfSoa = DB::connection("mysqlhms")->table('tblroom')->where("RoomNo",$roomNoA)->where("Stat","SOA")->first();
            if(!$checkIfSoa){
                $checkIfEx = DB::connection("mysqlrms")->table('tbl_guest_request_checkout')
                    ->where("seriesid",$seriesId)
                    ->where("controlno",$controlNo)
                    ->where("roomno",$roomNoA)
                    ->first();
                if($checkIfEx){
                    DB::connection("mysqlrms")->table('tbl_guest_request_checkout')
                        ->where("seriesid",$seriesId)
                        ->where("controlno",$controlNo)
                        ->where("roomno",$roomNoA)
                        ->update(array(
                            "order_sound"=>"0",
                            "status"=>"0"
                        ));
                } else {
                    DB::connection("mysqlrms")->table('tbl_guest_request_checkout')
                        ->insert(array(
                            "seriesid" => $seriesId,
                            "controlno" => $controlNo,
                            "roomno" => $roomNoA
                        ));
                }
            }
        }

        return Response::json(array("status"=>"Success"));

    }
    public function loadMenuByClassification() {

        if(Auth::check()) {
            $pending = DB::connection("mysqlhms")
                ->select(DB::raw("
                SELECT DISTINCT classification  as classification
                FROM tbl_itemlist 
                WHERE ItemStat = 'Active' AND (category = 'EMPLOYEES MEAL' 
                OR subclass <> 'SYS')
                AND classification IN ('FOOD','BEVERAGES','BEER')
            "));
        } else {
            $pending = DB::connection("mysqlhms")
                ->select(DB::raw("
                SELECT DISTINCT classification 
                FROM tbl_itemlist 
                WHERE subclass <> 'SYS'
                AND classification IN ('FOOD','BEVERAGES','BEER')
                AND ItemStat = 'Active'
                ORDER BY CASE WHEN classification = 'FOOD' THEN 0 WHEN classification = 'BEER' THEN 1 ELSE 2 END ASC
            "));
        }
        $data = [];
        foreach ($pending as $aRow) {
            if(Auth::check()) {
                $getSubClass = DB::connection("mysqlhms")
                    ->select(DB::raw("
                SELECT DISTINCT subclass as subclass 
                FROM tbl_itemlist 
                WHERE (category = 'EMPLOYEES MEAL' OR subclass <> 'SYS') 
                AND classification = '$aRow->classification'
                AND ItemStat = 'Active'
                ORDER BY subclass ASC
            "));
            } else {
                $getSubClass = DB::connection("mysqlhms")
                    ->select(DB::raw("
                SELECT DISTINCT subclass 
                FROM tbl_itemlist 
                WHERE subclass <> 'SYS'
                AND classification = '$aRow->classification'
                AND ItemStat = 'Active'
                ORDER BY subclass ASC
            "));
            }

            $data[] = array(
                "classification"=>$aRow->classification,
                "subClass" => $getSubClass
            );
        }

        return Response::json(array("content"=>$data));
    }
    public function loadCategory()
    {

        if(Auth::check()) {
            $pending = DB::connection("mysqlhms")
                ->select(DB::raw("
                SELECT DISTINCT classification  as subclass
                FROM tbl_itemlist 
                WHERE ItemStat = 'Active' AND category = 'EMPLOYEES MEAL'
            "));
        } else {
            $pending = DB::connection("mysqlhms")
                ->select(DB::raw("
                SELECT DISTINCT subclass  as subclass
                FROM tbl_itemlist 
                WHERE ItemStat = 'Active' AND subclass <> 'SYS'
            "));
        }

        return Response::json(array("content"=>$pending));
    }
    public function loadItemListByCategory()
    {
        $category = Input::get("category");
        $roomNo = Input::get("roomNo");
        if($category==""){
//            $pending = DB::connection("mysqlhms")
//                ->table("tbl_itemlist")
//                ->where("ItemStat","Active")
//                ->orderBy("classification","ASC")
//                ->get();

            if(Auth::check()){
                $pending = DB::connection("mysqlhms")
                    ->select(DB::raw("
                    SELECT 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN 0 ELSE SUM(b.qty) END as orderCount,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN a.unit_price ELSE SUM(b.qty)*SUM(a.unit_price) END as orderPrice
                    FROM 
                      tbl_itemlist a 
                    LEFT JOIN 
                      vc_rms.tbl_guest_order b 
                    ON a.item_no = b.item_no AND MD5(CONCAT('victoriacourt',b.roomno)) = '".$roomNo."' AND b.status = 0
                    WHERE 
                      a.ItemStat = 'Active' 
                      AND (a.category = 'EMPLOYEES MEAL' OR a.subclass <> 'SYS')
                    GROUP BY 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price
                    ORDER BY 
                      CASE 
                          WHEN a.classification = 'FOOD' THEN 0 
                          WHEN a.classification = 'BEER' THEN 1
                          ELSE 2
                      END ASC,a.item_name ASC
                            
                "));
            } else {
                $pending = DB::connection("mysqlhms")
                    ->select(DB::raw("
                    SELECT 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN 0 ELSE SUM(b.qty) END as orderCount,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN a.unit_price ELSE SUM(b.qty)*SUM(a.unit_price) END as orderPrice
                    FROM 
                      tbl_itemlist a 
                    LEFT JOIN 
                      vc_rms.tbl_guest_order b 
                    ON a.item_no = b.item_no AND MD5(CONCAT('victoriacourt',b.roomno)) = '".$roomNo."' AND b.status = 0
                    WHERE 
                      a.ItemStat = 'Active' 
                      AND a.subclass <> 'SYS'
                    GROUP BY 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price
                    ORDER BY 
                      CASE 
                          WHEN a.classification = 'FOOD' THEN 0 
                          WHEN a.classification = 'BEER' THEN 1
                          ELSE 2
                      END ASC,a.item_name ASC
                            
                "));
            }


        } else {
//            $pending = DB::connection("mysqlhms")
//                ->table("tbl_itemlist")
//                ->where("category",$category)
//                ->where("ItemStat","Active")
//                ->orderBy("classification","ASC")
//                ->get();

            if(Auth::check()){
                $pending = DB::connection("mysqlhms")
                    ->select(DB::raw("
                    SELECT 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN 0 ELSE SUM(b.qty) END as orderCount,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN a.unit_price ELSE SUM(b.qty)*SUM(a.unit_price) END as orderPrice
                    FROM 
                      tbl_itemlist a 
                    LEFT JOIN 
                      vc_rms.tbl_guest_order b 
                    ON a.item_no = b.item_no AND MD5(CONCAT('victoriacourt',b.roomno)) = '".$roomNo."' AND b.status = 0
                    WHERE 
                      a.ItemStat = 'Active' 
                      AND a.subclass = '$category' 
                      AND (a.category = 'EMPLOYEES MEAL' OR a.subclass <> 'SYS')
                    GROUP BY 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price
                    ORDER BY 
                      CASE 
                          WHEN a.classification = 'FOOD' THEN 0 
                          WHEN a.classification = 'BEER' THEN 1
                          ELSE 2
                      END ASC,a.item_name ASC
                            
                "));
            } else {
                $pending = DB::connection("mysqlhms")
                    ->select(DB::raw("
                    SELECT 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN 0 ELSE SUM(b.qty) END as orderCount,
                      CASE WHEN ISNULL(SUM(b.qty)) THEN a.unit_price ELSE SUM(b.qty)*SUM(a.unit_price) END as orderPrice
                    FROM 
                      tbl_itemlist a 
                    LEFT JOIN 
                      vc_rms.tbl_guest_order b 
                    ON a.item_no = b.item_no AND MD5(CONCAT('victoriacourt',b.roomno)) = '".$roomNo."' AND b.status = 0
                    WHERE 
                      a.ItemStat = 'Active' 
                      AND a.subclass = '$category'
                    GROUP BY 
                      a.item_no,
                      a.item_name,
                      a.classification,
                      a.category,
                      a.unit_price
                    ORDER BY 
                      CASE 
                          WHEN a.classification = 'FOOD' THEN 0 
                          WHEN a.classification = 'BEER' THEN 1
                          ELSE 2
                      END ASC,a.item_name ASC
                            
                "));
            }

        }

        return Response::json(array("content"=>$pending));
    }

    public function updateOrder()
    {
        $roomNo = Input::get("roomNo");
        $itemNo = Input::get("itemNo");
        $qty = Input::get("qty");
        $currQty = "";
        $currPrice = "";
        $type = Input::get("type");
        $sta = "Success";
        //checking if room have guest
        $checkIfIn = $this->checkIfRoomIsValidTemp($roomNo);
        if($checkIfIn){
            //check if there a current or pending transaction: status = 0 means not yet order close, 1 means closed order
            $countIfExist = DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->whereRaw("
                        MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNo."' 
                        AND controlno = '".$checkIfIn->ControlNo."' 
                        AND status = 1
                    ")
                ->count();

            $getItemDetails = DB::connection("mysqlhms")
                ->table("tbl_itemlist")
                ->where('item_no',$itemNo)
                ->where('ItemStat',"Active")
                ->first();



            $checkIfItemExist = DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->whereRaw("
                        MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNo."' 
                        AND controlno = '".$checkIfIn->ControlNo."' 
                        AND status = 0 
                        AND item_no = '".$itemNo."'
                    ")
                ->first();
            if($checkIfItemExist){
                if($type=="ADD"){
                    DB::connection("mysqlrms")
                        ->table("tbl_guest_order")
                        ->where("controlno",$checkIfIn->ControlNo)
                        ->where("status","0")
                        ->where("item_no",$itemNo)
                        ->where("transno",$checkIfItemExist->transno)
                        ->update(array(
                            "qty" => DB::raw("qty+".$qty."  ")
                        ));
                } else {
                    $pendingGetVal = DB::connection("mysqlrms")
                        ->table("tbl_guest_order")
                        ->where("controlno",$checkIfIn->ControlNo)
                        ->where("status","0")
                        ->where("item_no",$itemNo)
                        ->where("transno",$checkIfItemExist->transno)->first();
                    if($pendingGetVal){
                        if($pendingGetVal->qty<=1){
                            DB::connection("mysqlrms")
                                ->table("tbl_guest_order")
                                ->where("controlno",$checkIfIn->ControlNo)
                                ->where("status","0")
                                ->where("item_no",$itemNo)
                                ->where("transno",$checkIfItemExist->transno)
                                ->delete();
                            $sta = $itemNo;
                        } else {
                            DB::connection("mysqlrms")
                                ->table("tbl_guest_order")
                                ->where("controlno",$checkIfIn->ControlNo)
                                ->where("status","0")
                                ->where("item_no",$itemNo)
                                ->where("transno",$checkIfItemExist->transno)
                                ->update(array(
                                    "qty" => DB::raw("qty-".$qty."  ")
                                ));
                        }

                    }
                }

                $getCurrentQuan = DB::connection("mysqlrms")
                    ->table("tbl_guest_order")
                    ->where("controlno",$checkIfIn->ControlNo)
                    ->where("status","0")
                    ->where("item_no",$itemNo)
                    ->where("transno",$checkIfItemExist->transno)
                    ->first();
                if($getCurrentQuan){
                    $getPrice = DB::connection("mysqlhms")->table("tbl_itemlist")->where("item_no",$getCurrentQuan->item_no)->first();
                    $currPrice =  $getCurrentQuan->qty*$getPrice->unit_price;
                    $currQty =  $getCurrentQuan->qty;
                }

            } else {


                $checkIfItemExist = DB::connection("mysqlrms")
                    ->table("tbl_guest_order")
                    ->whereRaw("
                        MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNo."' 
                        AND controlno = '".$checkIfIn->ControlNo."' 
                        AND status = 0 
                    ")
                    ->first();
                if($checkIfItemExist){
                    $transno = $checkIfItemExist->transno;
                } else {
                    $transno = "POS2".date('ymdHis')."-".str_pad($countIfExist+1,5,"0",STR_PAD_LEFT);
                }

                DB::connection("mysqlrms")
                    ->table("tbl_guest_order")
                    ->insert(array(
                        "transno" => $transno,
                        "controlno" => $checkIfIn->ControlNo,
                        "roomno" => $checkIfIn->RoomNo,
                        "item_no" => $itemNo,
                        "item_name" => $getItemDetails->item_name,
                        "qty" => $qty,
                    ));
                $getCurrentQuan = DB::connection("mysqlrms")
                    ->table("tbl_guest_order")
                    ->where("controlno",$checkIfIn->ControlNo)
                    ->where("status","0")
                    ->where("item_no",$itemNo)
                    ->where("transno",$transno)
                    ->first();
                if($getCurrentQuan){
                    $getPrice = DB::connection("mysqlhms")->table("tbl_itemlist")->where("item_no",$getCurrentQuan->item_no)->first();
                    $currPrice =  $getCurrentQuan->qty*$getPrice->unit_price;
                    $currQty =  $getCurrentQuan->qty;
                }
            }



        }


        return Response::json(array("status"=>$sta,"currQuan"=>$currQty,"currPrice"=>$currPrice));

    }
    function checkIfRoomIsValidTemp($roomNoMD5)
    {
        $checkIfIn = DB::connection("mysqlhms")
            ->table("tblcustomerinfo_temp")
            ->whereRaw("
                    MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNoMD5."'
                ")
            ->first();
        if(!$checkIfIn){
            $checkIfIn = DB::table("users")
                ->whereRaw("
                    MD5(CONCAT('victoriacourt',username)) = '".$roomNoMD5."'
                ")
                ->select(DB::raw("username AS RoomNo, 'TO' AS ControlNo"))
                ->first();
        }
        return $checkIfIn;
    }
    public function loadOrderCart()
    {
        $roomNo = Input::get("roomNo");

        $checkIfValid = $this->checkIfRoomIsValidTemp($roomNo);
        if($checkIfValid) {
            $pending = DB::connection("mysqlrms")
                ->select(DB::raw("
                    SELECT 
                     a.transno as transno,
                     a.controlno as controlno,
                     a.roomno as roomno,
                     a.item_no as item_no,
                     a.item_name as item_name,
                     a.qty as qty,
                     b.classification as classification,
                     a.status as status,
                     a.pos_status as pos_status,
                     SUM(a.qty*b.unit_price) as unit_price
                    FROM tbl_guest_order a
                    LEFT JOIN hms.tbl_itemlist b 
                    ON a.item_no = b.item_no 
                    WHERE MD5(CONCAT('victoriacourt',a.RoomNo)) = '".$roomNo."' 
                    AND a.status = 0 
                    AND b.ItemStat = 'Active' 
                    GROUP BY a.transno ,
                     a.controlno,
                     a.roomno,
                     a.item_no ,
                     a.item_name ,
                     a.qty ,
                     b.classification,
                     a.status ,
                     a.pos_status 
                "));

            return Response::json(array("content"=>$pending));
        }
    } 

    public function loadMyOrder()
    {
        $roomNo = Input::get('roomNo');
        $checkIfIn = $this->checkIfRoomIsValidTemp($roomNo);
      
        $data = [];
        $data2 = [];
        //get all pending for cashier approval or validation
        if(Auth::check()){
            $pendingCart = DB::connection('mysqlrms')
                ->select(DB::raw(
                    "
                      SELECT 
                      DISTINCT 
                      transno,
                      controlno,
                      roomno,remarks
                      FROM tbl_guest_order 
                      WHERE status = 1
                      AND MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNo."' ORDER BY id DESC limit 10
                  "
                ));
        } else {
            $pendingCart = DB::connection('mysqlrms')
                ->select(DB::raw(
                    "  
                      SELECT 
                      DISTINCT 
                      transno,
                      controlno,
                      roomno,remarks
                      FROM tbl_guest_order 
                      WHERE status = 1
                      AND MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNo."'  ORDER BY id DESC
                  "
                ));
        }


        foreach($pendingCart as $aRowCart){
            $controlNo = $aRowCart->controlno;
            $transNo = $aRowCart->transno;
            $totalPrice = "";
            $totalDisc = "";
            $finalTotal = "";
            $notes = $aRowCart->remarks;
            $pendingCartDetails = DB::connection('mysqlrms')
                ->select(DB::raw(
                    "  
                      SELECT 
                      transno AS TransNo,
                      roomno AS room_no,
                      controlno AS ControlNo,
                      item_no AS itemname,
                      item_name AS itemname,
                      qty AS qty,
                      '' as price,
                      '' as total,
                      '' as totalxdisc
                      FROM tbl_guest_order 
                      WHERE status = 1
                      AND controlno = '$controlNo'
                      AND transno = '$transNo'
                      AND MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNo."' 
                  "
                ));
            $dataDetails2 = [];
            foreach($pendingCartDetails as $aRowCartDetails) {
                $dataDetails2[] = $aRowCartDetails;
            }
//            dd("a");
            $data2[] = array(
                "transNo" =>$transNo,
                "totalPrice" =>$totalPrice,
                "totalDisc" =>$totalDisc,
                "finalTotal" =>$finalTotal,
                "notes" =>$notes,
                "dataDetails" => $dataDetails2
            );
        }


        if($checkIfIn){


          //get all pos process order
          $pending = DB::connection('mysqlhms')
              ->select(DB::raw(
                  "  
                      SELECT 
                      DISTINCT 
                      a.TransNo,
                      a.room_no,
                      a.ControlNo,
                      a.notes,
                      ROUND(SUM(a.qty*a.price),2) AS totalPrice,
                      ROUND(SUM(a.xdisc),2) AS totalDisc,
                      ROUND(SUM((a.qty*a.price)-xdisc),2) AS finalTotal
                      FROM tbl_postrans_kds a
                      WHERE 
                      itemStat = '0' 
                      AND MD5(CONCAT('victoriacourt',room_no)) = '$roomNo' 
                      AND ControlNo = '$checkIfIn->ControlNo'
                      GROUP BY a.TransNo,
                      a.room_no,
                      a.ControlNo
                  "
              ));
          if(!$pending){
              $pending = DB::connection('mysqlhms')
                  ->select(DB::raw(
                      "  
                      SELECT 
                      DISTINCT 
                      a.TransNo,
                      a.room_no,
                      a.ControlNo,
                      a.notes,
                      ROUND(SUM(a.qty*a.price),2) AS totalPrice,
                      ROUND(SUM(a.xdisc),2) AS totalDisc,
                      ROUND(SUM((a.qty*a.price)-xdisc),2) AS finalTotal
                      FROM tbl_postrans_kds a
                      WHERE 
                      itemStat = '0' 
                      AND MD5(CONCAT('victoriacourt',room_no)) = '$roomNo' 
                      GROUP BY a.TransNo,
                      a.room_no,
                      a.ControlNo
                  "
                  ));
              if(!$pending){
                  $pending = DB::connection('mysqlhms')
                      ->select(DB::raw(
                          "  
                      SELECT 
                      DISTINCT 
                      a.TransNo,
                      a.room_no,
                      a.ControlNo,
                      a.notes,
                      ROUND(SUM(a.qty*a.price),2) AS totalPrice,
                      ROUND(SUM(a.xdisc),2) AS totalDisc,
                      ROUND(SUM((a.qty*a.price)-xdisc),2) AS finalTotal
                      FROM tbl_postrans_kds a
                      WHERE 
                      itemStat = '0' 
                      AND ControlNo = '$checkIfIn->ControlNo'
                      GROUP BY a.TransNo,
                      a.room_no,
                      a.ControlNo
                  "
                      ));
              }
          }

          foreach ($pending as $aRow) {
              $controlNo = $checkIfIn->ControlNo;
              $transNo = $aRow->TransNo;
              $totalPrice = $aRow->totalPrice;
              $totalDisc = $aRow->totalDisc;
              $finalTotal = $aRow->finalTotal;
              $notes = $aRow->notes;
              $pendingDetail = DB::connection('mysqlhms')
                  ->select(DB::raw(
                      "
                      SELECT 
                      a.TransNo,
                      a.room_no,
                      a.ControlNo,
                      a.itemno,
                      a.itemname,
                      a.qty,
                      ROUND(a.price,2),
                      ROUND(a.qty*a.price,2) as total,
                      ROUND((a.qty*a.price)-(a.xdisc),2) as totalxdisc,
                      a.Bump,
                      a.itemStat 
                      FROM tbl_postrans_kds a
                      WHERE 
                      itemStat = '0' 
                      AND ControlNo = '$controlNo' 
                      AND TransNo = '$transNo'
                    "
                  ));
              if(!$pendingDetail){
                  $pendingDetail = DB::connection('mysqlhms')
                      ->select(DB::raw(
                          "
                      SELECT 
                      a.TransNo,
                      a.room_no,
                      a.ControlNo,
                      a.itemno,
                      a.itemname,
                      a.qty,
                      ROUND(a.price,2),
                      ROUND(a.qty*a.price,2) as total,
                      ROUND((a.qty*a.price)-(a.xdisc),2) as totalxdisc,
                      a.Bump,
                      a.itemStat 
                      FROM tbl_postrans_kds a
                      WHERE 
                      itemStat = '0' 
                      AND TransNo = '$transNo'
                    "
                      ));
              }
              $dataDetails = [];
              foreach($pendingDetail as $aRowDetail) {
                  $dataDetails[] = $aRowDetail;
              }
            $data[] = array(
                "transNo" =>$transNo,
                "totalPrice" =>$totalPrice,
                "totalDisc" =>$totalDisc,
                "finalTotal" =>$finalTotal,
                "notes" =>$notes,
                "dataDetails" => $dataDetails
            );


          }

        }


        return Response::json(array("content"=>$data,"contentCart"=>$data2));
    }


    public function loadVcInfo()
    {
        $roomNo = Input::get('roomNo');
        $pending = DB::connection("mysqlhms")
            ->table("tblmainsetup")
            ->first();
        $pendingRoom = $this->checkIfRoomIsValidTemp($roomNo);
        if(isset($pendingRoom->RoomCharges)){
            $pendingItemDetail = DB::connection('mysqlhms')
                ->select(DB::raw(
                    "
                      SELECT 
                      a.TransNo,
                      a.room_no,
                      a.ControlNo,
                      a.itemno,
                      a.itemname,
                      a.qty,
                      a.price,
                      a.qty*a.price as total,
                      (a.qty*a.price)-(a.xdisc) as totalxdisc,
                      a.Bump,
                      a.itemStat 
                      FROM tbl_postrans_kds a
                      WHERE 
                      itemStat = '0' 
                      AND ControlNo = '$pendingRoom->ControlNo' 
                    "
                ));

            if(!$pendingItemDetail) {
                $pendingItemDetail = DB::connection('mysqlhms')
                    ->select(DB::raw(
                        "
                      SELECT 
                      a.TransNo,
                      a.room_no,
                      a.ControlNo,
                      a.itemno,
                      a.itemname,
                      a.qty,
                      a.price,
                      a.qty*a.price as total,
                      (a.qty*a.price)-(a.xdisc) as totalxdisc,
                      a.Bump,
                      a.itemStat 
                      FROM tbl_postrans_kds a
                      WHERE 
                      itemStat = '0' 
                      AND MD5(CONCAT('victoriacourt',room_no)) = '$roomNo' 
                    "
                    ));
            }

            if($pending AND $pendingRoom){

                $getSoa = $this->getSoaDetails($pendingRoom->RoomNo,$pendingRoom->ControlNo);

                $soaNo = "";
                $freezeTime = "";
                $compDate = "";
                $printSOA = "";

                if($getSoa){
                    $soaNo = $getSoa->SOANo;
                    $freezeTime = $getSoa->freezeTime;
                    $compDate = $getSoa->compDate;
                    $printSOA = $getSoa->printSOA;
                }

                $itemArr = [];

                $totalSoa = 0;
                foreach($pendingItemDetail as $aRow){
                    $totalSoa = $totalSoa + $aRow->total;
                    $itemArr[] = array(
                        "itemQty" => $aRow->qty,
                        "itemName" => $aRow->itemname,
                        "itemTotal" => $aRow->total,
                        "itemTotalF" => $this->setNumberFormat($aRow->total)
                    );
                }
                $totalSoa = $totalSoa + $pendingRoom->RoomCharges;

                $getAdvanceDeposits = $this->getAdvanceDeposit($pendingRoom->SeriesID,$pendingRoom->RoomNo);

                $soaAdvanceDeposit = 0;
                if($getAdvanceDeposits){
                    $soaAdvanceDeposit =  $getAdvanceDeposits->amount;
                }
                $amountDue = $totalSoa - ($soaAdvanceDeposit+$pendingRoom->discountAmount+$this->getVatExempt($pendingRoom->SeriesID,$pendingRoom->RoomNo));
                $data = array(
                    "companyName" => $pending->CompanyName,
                    "companyAddress" => $pending->CompanyAddress,
                    "companyTel" => $pending->CompanyTel,
                    "companySerialNo" => $pending->SerialNo,
                    "companyTinNo" => $pending->TINNo,
                    "companyPermitNo" => $pending->PermitNo,
                    "companyAccreNo" => $pending->AccreNo,
                    "roomNo" => $pendingRoom->RoomNo,
                    "cashier" => $this->gethmsUname($pendingRoom->ProcessBy),
                    "username" => $pendingRoom->ProcessBy,
                    "soaDate" => $compDate,
                    "soaTime" => $freezeTime,
                    "soaNo" => $soaNo,
                    "soaDateIn" => $pendingRoom->DateIn." ".$pendingRoom->TimeIn,
                    "soaDateOut" => $pendingRoom->DateOut,
                    "soaDuration" => $pendingRoom->noOfDays." days ".$pendingRoom->totalHr." hours ".$pendingRoom->totalMin." mins ",
                    "soaRoomType" => $pendingRoom->RoomType,
                    "soaRoomCharge" => $this->setNumberFormat($pendingRoom->RoomCharges),
                    "soaItemList" => $itemArr,
                    "soaTotal" => $this->setNumberFormat($totalSoa),
                    "soaAdvanceDeposit" => $this->setNumberFormat($soaAdvanceDeposit),
                    "soaDiscountAmount" => $this->setNumberFormat($pendingRoom->discountAmount),
                    "soaVatExempt" => $this->getVatExempt($pendingRoom->SeriesID,$pendingRoom->RoomNo),
                    "soaAmountDue" => $this->setNumberFormat($amountDue),
                    "soaDiscountDetails" => $this->getDiscountDetails($pendingRoom->SeriesID,$pendingRoom->RoomNo),
                    "soaControlNo" => $pendingRoom->ControlNo
                );
                return Response::json($data);
            }
        }

    }

    public function setNumberFormat($value){
        return number_format($value,2,'.',',');
    }

    public function gethmsUname($username)
    {
        $pending = DB::connection('mysqlhms')
            ->table("tbluser")
            ->where("ulogname",$username)
            ->orderBy("id","DESC")
            ->first();
        return $pending->uName;
    }

    public function getSoaDetails($roomNo,$controlNo)
    {
        $pending = DB::connection("mysqlhms")
            ->table("tblsoa")
            ->where("RoomNo",$roomNo)
            ->where("ControlNo",$controlNo)
            ->orderBy("id","DESC")
            ->first();
        return $pending;

    }

    public function getAdvanceDeposit($seriesNo,$roomNo)
    {
        $pending = DB::connection("mysqlhms")
            ->table("tbladvancedeposit_temp")
            ->where("SeriesID",$seriesNo)
            ->where("RoomNo",$roomNo)
            ->select(DB::raw("SUM(Amount) AS amount"))
            ->orderBy("ID","DESC")
            ->first();
        return $pending;

    }
    public function getVatExempt($seriesNo,$roomNo)
    {
        $pending = DB::connection("mysqlhms")
            ->table("tblpostingdiscount_temp")
            ->where("SeriesID",$seriesNo)
            ->where("RoomNo",$roomNo)
            ->select(DB::raw("SUM(xVatExempt) as amount"))
            ->first();
        if($pending){
            return $pending->amount;
        } else {
            return 0;
        }
    }

    public function getDiscountDetails($seriesNo,$roomNo)
    {
        $pending = DB::connection("mysqlhms")
            ->table("tblpostingdiscount_temp")
            ->where("SeriesID",$seriesNo)
            ->where("RoomNo",$roomNo)
            ->select(DB::raw("DISTINCT discType,discCardNo,NoOfPAX,NoOfSenior"))
            ->get();
        $getData = [];
        foreach($pending as $aRow){
            $discType = $aRow->discType;
            $discCardNo = $aRow->discCardNo;
            $NoOfPAX = $aRow->NoOfPAX;
            $NoOfSenior = $aRow->NoOfSenior;
            $descriptionDisc = "";
            if($discType=="Senior Citizen") {
                $descriptionDisc = "No. of PAX : ".$NoOfPAX." No. of Senior ".$NoOfSenior;
            } else {
                $descriptionDisc = $discType." - ".$discCardNo;
            }
            $getData[] = array("discountDesc"=>$descriptionDisc);

        }
        return $getData;

    }

    public function loadPromoCode()
    {
        $roomNo = Input::get("roomNo");
        $pendingRoom = $this->checkIfRoomIsValidTemp($roomNo);
        if($pendingRoom){
            $roomNo = $pendingRoom->RoomNo;
            $roomType = $pendingRoom->RoomType;
            $controlno = $pendingRoom->ControlNo;
            $seriesID = $pendingRoom->SeriesID;
            $RateDesc = $pendingRoom->RateDesc;

            $pending = DB::connection("mysqlrms")
                ->table("tbl_guest_promo_code")
                ->where("seriesid",$seriesID)
                ->where("controlno",$controlno)
                ->orderBy("id","DESC")
                ->get();
            $mainData = [];
            foreach($pending as $aRow) {
                $checkIfApplied = DB::connection("mysqlhms")
                    ->table("tblpostingdiscount_temp")
                    ->where("SeriesID", $seriesID)
                    ->where("ControlNo", $controlno)
                    ->where("discType", $aRow->promo_code)
                    ->first();
//                dd($checkIfApplied);
                $status = "0";
                if($checkIfApplied) {
                    $status = "1";
                }

                $getItem = DB::connection("mysqlrms")->table("tbl_guest_promo_code_item")->where("promo_code",$aRow->promo_code)->get();

                $mainData[] = array(
                    "promo_code" => $aRow->promo_code,
                    "promo_code_type" => $aRow->promo_code_type,
                    "promo_code_value" => $aRow->promo_code_value,
                    "items" => $getItem,
                    "status" => $status,
                );
            }

            return Response::json(array("content"=>$mainData));
        }
    }

    public function submitPromoCode()
    {
        $roomNo = Input::get("roomNo");
        $promoCode = Input::get("promoCode");
        $pendingRoom = $this->checkIfRoomIsValidTemp($roomNo);
        $promoCode = str_replace("'","",$promoCode);

        $promoCodeVC = substr($promoCode,0,2);
//        if($promoCodeVC!="VC") {
//            return Response::json(array("status"=>"Promo Code is not valid"));
//        }

        if($pendingRoom) {
            $roomNo = $pendingRoom->RoomNo;
            $roomType = $pendingRoom->RoomType;
            $controlno = $pendingRoom->ControlNo;
            $seriesID = $pendingRoom->SeriesID;
            $RateDesc = $pendingRoom->RateDesc;

            $checkiFeXist1st = DB::connection("mysqlrms")
                ->table("tbl_guest_promo_code")
                ->where("seriesid",$seriesID)
                ->where("controlno",$controlno)
                ->where("promo_code",$promoCode)
                ->first();

            if($checkiFeXist1st) {
                return Response::json(array("status"=>"Promo Code Already Encoded"));
            } else {

                $getPromoCodeSettingsMain = DB::connection("mysqlrms")->table("tbl_promo_code")->where("promo_code",$promoCode)->first();
                $getPromoCodeSettingsItem = DB::connection("mysqlrms")->table("tbl_promo_code_item")->where("promo_code",$promoCode)->get();
                $getPromoCodeSettingsRoomType = DB::connection("mysqlrms")->table("tbl_promo_code_roomtype")->where("promo_code",$promoCode)->get();
                if($getPromoCodeSettingsMain){
                    $guestPromoCodeType = $getPromoCodeSettingsMain->promo_code_type;
                    $guestPromoCodeValue = $getPromoCodeSettingsMain->promo_code_value;

                    if($guestPromoCodeType!="ITEM"){
//                    dd($guestPromoCodeType);

                        $checkiFeXist2nd = DB::connection("mysqlrms")
                            ->table("tbl_guest_promo_code")
                            ->where("seriesid",$seriesID)
                            ->where("controlno",$controlno)
                            ->where("promo_code_type","like","%ROOM%")
                            ->first();

                        if($checkiFeXist2nd){
                            return Response::json(array("status"=>"1 promo code for room charge per check-in"));
                        }

                    }

                    $checkiFeXist3rd = DB::connection("mysqlrms")->table("tbl_promo_code_roomtype")->where("promo_code",$promoCode)->where("room_type","ALL")->first();

                    if(!$checkiFeXist3rd){
                        $checkiFeXist3rd = DB::connection("mysqlrms")->table("tbl_promo_code_roomtype")->where("promo_code",$promoCode)->where("room_type",$roomType)->first();
                    }

                    if(!$checkiFeXist3rd){
                        return Response::json(array("status"=>"promo code is not available on your current room type"));
                    }

                    DB::connection('mysqlrms')->table("tbl_guest_promo_code")
                        ->insert(array(
                            "seriesid" => $seriesID,
                            "controlno" => $controlno,
                            "roomno" => $roomNo,
                            "promo_code" => $promoCode,
                            "promo_code_type" => $guestPromoCodeType,
                            "promo_code_value" => $guestPromoCodeValue,
                        ));

                    foreach ($getPromoCodeSettingsItem as $aRow1) {
                        DB::connection('mysqlrms')->table("tbl_guest_promo_code_item")
                            ->insert(array(
                                "seriesid" => $seriesID,
                                "controlno" => $controlno,
                                "roomno" => $roomNo,
                                "promo_code" => $promoCode,
                                "item_no" => $aRow1->item_no,
                                "item_name" => $aRow1->item_name,
                            ));
                    }
                    foreach ($getPromoCodeSettingsRoomType as $aRow2) {
                        DB::connection('mysqlrms')->table("tbl_guest_promo_code_roomtype")
                            ->insert(array(
                                "seriesid" => $seriesID,
                                "controlno" => $controlno,
                                "roomno" => $roomNo,
                                "promo_code" => $promoCode,
                                "room_type" => $aRow2->room_type
                            ));
                    }
                } else {
                    return Response::json(array("status"=>"Invalid promo code"));
                }



            }

        }

        //javier

        return Response::json(array("status"=>"Success"));
    }
    public function saveCartOrder()
    {
        $roomNo = Input::get("roomNo");
        $notes = Input::get("notes");
        $notes = str_replace("'","",$notes);

        $pendingRoom = $this->checkIfRoomIsValidTemp($roomNo);

        if($pendingRoom) {
            $pendingRoomOrder = DB::connection("mysqlrms")
                ->table("tbl_guest_order")
                ->whereRaw("
                        MD5(CONCAT('victoriacourt',RoomNo)) = '".$roomNo."' 
                        AND controlno = '".$pendingRoom->ControlNo."' 
                        AND status = 0
                    ")
                ->get();

            foreach ($pendingRoomOrder as $aRow) {
                DB::connection("mysqlrms")
                    ->table("tbl_guest_order")
                    ->where("id",$aRow->id)
                    ->update(array(
                        "status" => "1",
                        "remarks" => $notes
                    ));
            }

        }






    }

    public function loadMyFeedback()
    {
        $roomNo = Input::get("roomNo");
        $checkIfRoomIsValid = $this->checkIfRoomIsValidTemp($roomNo);
        if($checkIfRoomIsValid) {
            $roomNo = $checkIfRoomIsValid->RoomNo;
            $controlNo = $checkIfRoomIsValid->ControlNo;
            $seriesId = $checkIfRoomIsValid->SeriesID;

            $serviceStar = $this->getGuestFeedbackValue("Service","STAR",$roomNo,$controlNo,$seriesId);
            $serviceRemarks = $this->getGuestFeedbackValue("Service","REMARKS",$roomNo,$controlNo,$seriesId);

            $roomStar = $this->getGuestFeedbackValue("Room","STAR",$roomNo,$controlNo,$seriesId);
            $roomRemarks = $this->getGuestFeedbackValue("Room","REMARKS",$roomNo,$controlNo,$seriesId);

            $foodStar = $this->getGuestFeedbackValue("Food","STAR",$roomNo,$controlNo,$seriesId);
            $foodRemarks = $this->getGuestFeedbackValue("Food","REMARKS",$roomNo,$controlNo,$seriesId);

            $data = array(
                "serviceStar" => $serviceStar,
                "serviceRemarks" => $serviceRemarks,
                "roomStar" => $roomStar,
                "roomRemarks" => $roomRemarks,
                "foodStar" => $foodStar,
                "foodRemarks" => $foodRemarks,
            );
            return Response::json($data);
        }

    }
    function getGuestFeedbackValue($ratingType,$typeField,$roomNo,$controlNo,$seriesId){
        if($typeField=="STAR"){
            $fieldValue = "0";
        } else {
            $fieldValue = "";
        }
        $getValue = DB::connection("mysqlrms")->table("tbl_guest_feedback")->where("roomno",$roomNo)
            ->where("controlno",$controlNo)
            ->where("seriesid",$seriesId)
            ->where("rating_type",$ratingType)
            ->first();
        if($getValue){
            if($typeField=="STAR"){
                $fieldValue = $getValue->rating_value;
            } else {
                $fieldValue =  $getValue->rating_remarks;
            }
        }
        return $fieldValue;

    }

    public function saveFeedbackStar()
    {
        $roomNo = Input::get("roomNo");
        $ratingType = Input::get("ratingType");
        $ratingValue = Input::get("ratingValue");
        //javier
        $checkIfRoomIsValid = $this->checkIfRoomIsValidTemp($roomNo);
//        dd($checkIfRoomIsValid);
        if($checkIfRoomIsValid){
            $roomNo = $checkIfRoomIsValid->RoomNo;
            $controlNo = $checkIfRoomIsValid->ControlNo;
            $seriesId = $checkIfRoomIsValid->SeriesID;

            $checkIfExist = DB::connection("mysqlrms")
                ->table("tbl_guest_feedback")
                ->where("roomno",$roomNo)
                ->where("controlno",$controlNo)
                ->where("seriesid",$seriesId)
                ->where("rating_type",$ratingType)
                ->first();
            if($checkIfExist){
                DB::connection("mysqlrms")
                    ->table("tbl_guest_feedback")
                    ->where("roomno",$roomNo)
                    ->where("controlno",$controlNo)
                    ->where("seriesid",$seriesId)
                    ->where("rating_type",$ratingType)
                    ->update(array(
                        "rating_value" => $ratingValue
                    ));
            } else {
                DB::connection("mysqlrms")
                    ->table("tbl_guest_feedback")
                    ->insert(array(
                        "roomno" => $roomNo,
                        "controlno" => $controlNo,
                        "seriesid" => $seriesId,
                        "rating_type" => $ratingType,
                        "rating_value" => $ratingValue
                    ));
            }
        }

        return Response::json(array("status"=>"Success"));
    }
    public function saveFeedbackRemarks()
    {
        $roomNo = Input::get("roomNo");
        $ratingType = Input::get("feedbackType");
        $ratingValue = Input::get("remarks");
        $ratingValue = str_replace("'","",$ratingValue);
        //javier
        $checkIfRoomIsValid = $this->checkIfRoomIsValidTemp($roomNo);
//        dd($checkIfRoomIsValid);
        if($checkIfRoomIsValid){
            $roomNo = $checkIfRoomIsValid->RoomNo;
            $controlNo = $checkIfRoomIsValid->ControlNo;
            $seriesId = $checkIfRoomIsValid->SeriesID;


            DB::connection("mysqlrms")
                ->table("tbl_guest_feedback")
                ->where("roomno",$roomNo)
                ->where("controlno",$controlNo)
                ->where("seriesid",$seriesId)
                ->where("rating_type",$ratingType)
                ->update(array(
                    "rating_remarks" => $ratingValue
                ));
        }

        return Response::json(array("status"=>"Success"));
    }




}
