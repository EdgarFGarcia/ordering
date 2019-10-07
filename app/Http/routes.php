<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('dashboard', "PageAuthController@employeeDashboard");


Route::get('room/{roomno}', "PageController@home");
Route::get('myfoodlist/{roomno}', "PageController@myFoodList");
Route::get('/', "PageGuestController@login");
//Route::get('soa/{roomno}', "PageController@soa");


Route::post('loadCategory',"ApiController@loadCategory");
Route::post('loadItemListByCategory',"ApiController@loadItemListByCategory");
Route::post('loadOrderCart',"ApiController@loadOrderCart");
Route::post('loadMyOrder',"ApiController@loadMyOrder");
Route::post('loadVcInfo',"ApiController@loadVcInfo");
Route::post('saveCartOrder',"ApiController@saveCartOrder");
Route::post('submitPromoCode',"ApiController@submitPromoCode");
Route::post('loadPromoCode',"ApiController@loadPromoCode");
Route::post('loadMenuByClassification',"ApiController@loadMenuByClassification");
Route::post('requestcheckOut',"ApiController@requestcheckOut");


Route::post('loadGuestOrder',"ApiAuthController@loadGuestOrder");
Route::post('loadEmployeeOrder',"ApiAuthController@loadEmployeeOrder");
Route::post('approvedGuestOrder',"ApiAuthController@approvedGuestOrder");
Route::post('disapprovedGuestOrder',"ApiAuthController@disapprovedGuestOrder");

Route::post('employeeRemoveOrder',"ApiAuthController@employeeRemoveOrder");
Route::post('saveFeedback',"ApiAuthController@saveFeedback");
Route::post('loadRoom',"ApiAuthController@loadRoom");


Route::post('saveFeedbackStar',"ApiController@saveFeedbackStar");
Route::post('saveFeedbackRemarks',"ApiController@saveFeedbackRemarks");
Route::post('loadMyFeedback',"ApiController@loadMyFeedback");

Route::post('loadRoomTransaction','ApiAuthController@loadRoomTransaction');
Route::post('loadGuestFeedback','ApiAuthController@loadGuestFeedback');
Route::post('saveGuestFeedbackCashier','ApiAuthController@saveGuestFeedbackCashier');
Route::post('changeQTYbyId','ApiAuthController@changeQTYbyId');
Route::post('loadGuestFeedbackByTypeOrSubtype','ApiAuthController@loadGuestFeedbackByTypeOrSubtype');


Route::post('loadGuestOrderHistory','ApiAuthController@loadGuestOrderHistory');
Route::post('loadGuestFeedbackHistory','ApiAuthController@loadGuestFeedbackHistory');
Route::post('loadEmployeeOrderHistory','ApiAuthController@loadEmployeeOrderHistory');
Route::post('removePromoCode','ApiAuthController@removePromoCode');
Route::post('removeCheckOut','ApiAuthController@removeCheckOut');
Route::post('loadGuestPromoHistory','ApiAuthController@loadGuestPromoHistory');
Route::post('validateGuestPromoCode','ApiAuthController@validateGuestPromoCode');



Route::post('updateOrder',"ApiController@updateOrder");

Route::group(['namespace' => 'Auth', 'middleware' => ['web']], function () {

    Route::post('login', 'AuthController@postLogin');
    Route::get('logout', 'AuthController@logout');
    Route::get('tryAgain', 'AuthController@tryAgain');
});