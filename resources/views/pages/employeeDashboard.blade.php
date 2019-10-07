{!! Theme::asset()->add('angular-home-css',URL('/').'/themes/portal/assets/css/employeeDashboard.css') !!}
{!! Theme::asset()->add('angular-home',URL('/').'/themes/portal/assets/js/employeeDashboard.js') !!}

<style>
    .hidden {
        display: none !important;
    }
    .myOrderCard {
        background-image: url('{!! URL('img/note22.png') !!}') !important;
        background-size: 100% 100% !important;
        /*min-height: 24em !important;*/
        padding: 1em !important;
    }
</style>


<div ng-controller="homeController as homeControllerChild">

    <div id="modalHistoryGuestOrder" class="ui fullscreen modal">
        <div class="header">Guest Order History</div>
        <div class="content" style="min-height: 30em;max-height: 30em;overflow-y: auto;">
            <div class="ui top attached tabular menu">
                <a class="active item" data-tab="first">Guest Orders</a>
                <a class="item" data-tab="second">Guest Promo Codes</a>
            </div>
            <div class="ui bottom attached active tab segment" data-tab="first">
                <div class="ui labeled input">
                    <div class="ui label">
                        Start Date
                    </div>
                    <input id="guestOrderStartDate" type="text" placeholder="YYYY/MM/DD">
                </div>
                <div class="ui labeled input">
                    <div class="ui label">
                        End Date
                    </div>
                    <input id="guestOrderEndDate" type="text" placeholder="YYYY/MM/DD">
                </div>
                <button class="ui button" ng-click="loadGuestOrderHistory()">Load</button>
                <br/>
                <br/>
                <div>
                    <table class="ui table">
                        <thead>
                        <tr>
                            <th>ROOM</th>
                            <th>QTY</th>
                            <th>ITEM NAME</th>
                            <th>REMARKS</th>
                            <th>DATECREATED</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="historyGuestOrderD in historyGuestOrder">
                            <td><% historyGuestOrderD.roomno %></td>
                            <td><% historyGuestOrderD.qty %></td>
                            <td><% historyGuestOrderD.item_name %></td>
                            <td><% historyGuestOrderD.remarks %></td>
                            <td><% historyGuestOrderD.datecreated %></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="ui bottom attached tab segment" data-tab="second">
                <div class="ui labeled input">
                    <div class="ui label">
                        Start Date
                    </div>
                    <input id="guestPromoStartDate" type="text" placeholder="YYYY/MM/DD">
                </div>
                <div class="ui labeled input">
                    <div class="ui label">
                        End Date
                    </div>
                    <input id="guestPromoEndDate" type="text" placeholder="YYYY/MM/DD">
                </div>
                <button class="ui button" ng-click="loadGuestPromoCodeHistory()">Load</button>
                <br/>
                <br/>
                <div class="row uniform">
                    <div class="4u 12u(small)">
                        <h3>Promo Code History</h3>
                        <div class="ui info message">
                            {{--<i class="close icon"></i>--}}
                            <div class="header">
                                Infomation
                            </div>
                            <p>This table show all the Promo code inputed by guest
                            </p>
                        </div>
                        <table class="ui table">
                            <thead>
                            <tr>
                                <th>SERIES</th>
                                <th>ROOM</th>
                                <th>ITEM NAME</th>
                                <th>DATECREATED</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="historyGuestPromo1D in historyGuestPromo1">
                                <td><% historyGuestPromo1D.seriesid %></td>
                                <td><% historyGuestPromo1D.roomno %></td>
                                <td><% historyGuestPromo1D.discountCode %></td>
                                <td><% historyGuestPromo1D.datecreated %></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="4u 12u(small)">
                        <h3>Promo Code VS Disc. Room</h3>
                        <div class="ui info message">
                            {{--<i class="close icon"></i>--}}
                            <div class="header">
                                Infomation
                            </div>
                            <p>This table show all the Promo code inputed by guest but not encoded on the system
                            </p>
                        </div>
                        <table class="ui table">
                            <thead>
                            <tr>
                                <th>SERIES</th>
                                <th>ROOM</th>
                                <th>ITEM NAME</th>
                                <th>DATECREATED</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="historyGuestPromo2D in historyGuestPromo2">
                                <td><% historyGuestPromo2D.seriesid %></td>
                                <td><% historyGuestPromo2D.roomno %></td>
                                <td><% historyGuestPromo2D.discountCode %></td>
                                <td><% historyGuestPromo2D.datecreated %></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="4u 12u(small)">
                        <h3>Disc. Room VS Promo Code</h3>
                        <div class="ui info message">
                            {{--<i class="close icon"></i>--}}
                            <div class="header">
                                Infomation
                            </div>
                            <p>This table show all the Promo code inputed by cashier not by guest
                            </p>
                        </div>
                        <table class="ui table">
                            <thead>
                            <tr>
                                <th>SERIES</th>
                                <th>ROOM</th>
                                <th>ITEM NAME</th>
                                <th>DATECREATED</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="historyGuestPromo3D in historyGuestPromo3">
                                <td><% historyGuestPromo3D.seriesid %></td>
                                <td><% historyGuestPromo3D.roomno %></td>
                                <td><% historyGuestPromo3D.discountCode %></td>
                                <td><% historyGuestPromo3D.datecreated %></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
        <div class="actions">
            {{--<div class="ui approve button">Approve</div>--}}
            {{--<div class="ui button">Neutral</div>--}}
            <div class="ui cancel button">Close</div>
        </div>
    </div>

    <div id="modalHistoryGuestFeedback" class="ui fullscreen modal">
        <div class="header">Guest Feedback History</div>
        <div class="content" style="min-height: 30em;max-height: 30em;overflow-y: auto;">
            <div class="ui labeled input">
                <div class="ui label">
                    Start Date
                </div>
                <input id="guestFeedbackStartDate" type="text" placeholder="YYYY/MM/DD">
            </div>
            <div class="ui labeled input">
                <div class="ui label">
                    End Date
                </div>
                <input id="guestFeedbackEndDate" type="text" placeholder="YYYY/MM/DD">
            </div>
            <button class="ui button" ng-click="loadGuestFeedbackHistory()">Load</button>
            <br/>
            <br/>
            <div class="row uniform">
                <div class="6u 12u(small)">
                    <h1>GUEST FEEDBACK HISTORY</h1>
                    <table class="ui table">
                        <thead>
                        <tr>
                            <th>SERIESID</th>
                            <th>PLATENO</th>
                            <th>ROOMNO</th>
                            <th>TYPE</th>
                            <th>SUBTYPE</th>
                            <th>REMARKS</th>
                            <th>DATECREATED</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="historyGuestFeedback2D in historyGuestFeedback2">
                            <td><% historyGuestFeedback2D.SeriesID %></td>
                            <td><% historyGuestFeedback2D.PlateNo %></td>
                            <td><% historyGuestFeedback2D.RoomNo %></td>
                            <td><% historyGuestFeedback2D.feedback_type %></td>
                            <td><% historyGuestFeedback2D.feedback_subtype %></td>
                            <td><% historyGuestFeedback2D.feedback_desc %></td>
                            <td><% historyGuestFeedback2D.datecreated %></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="ui table">
                        <thead>
                        <tr>
                            <th>SERIESID</th>
                            <th>PLATENO</th>
                            <th>ROOMNO</th>
                            <th>TYPE</th>
                            <th>STAR</th>
                            <th>REMARKS</th>
                            <th>DATECREATED</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="historyGuestFeedback1D in historyGuestFeedback1">
                            <td><% historyGuestFeedback1D.SeriesID %></td>
                            <td><% historyGuestFeedback1D.PlateNo %></td>
                            <td><% historyGuestFeedback1D.RoomNo %></td>
                            <td><% historyGuestFeedback1D.rating_type %></td>
                            <td><% historyGuestFeedback1D.rating_value %></td>
                            <td><% historyGuestFeedback1D.rating_remarks %></td>
                            <td><% historyGuestFeedback1D.datecreated %></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="6u 12u(small)">
                    <h1>ROOM THAT DOESN'T HAVE A FEEDBACK</h1>
                    <table class="ui table">
                        <thead>
                        <tr>
                            <th>SERIESID</th>
                            <th>CONTROLNO</th>
                            <th>ROOMNO</th>
                            <th>DATEOUT</th>
                            <th>TIMEOUT</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="historyGuestFeedback3D in historyGuestFeedback3">
                            <td><% historyGuestFeedback3D.seriesid %></td>
                            <td><% historyGuestFeedback3D.controlno %></td>
                            <td><% historyGuestFeedback3D.room %></td>
                            <td><% historyGuestFeedback3D.DateOut %></td>
                            <td><% historyGuestFeedback3D.TimeOut %></td>
                            <td>
                                <button class="ui cancel button" ng-click="loadRoomFeedback(historyGuestFeedback3D.seriesid,historyGuestFeedback3D.room,historyGuestFeedback3D.controlno)">Feedback</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="actions">
            {{--<div class="ui approve button">Approve</div>--}}
            {{--<div class="ui button">Neutral</div>--}}
            <div class="ui cancel button">Close</div>
        </div>
    </div>
    <div id="modalHistoryEmployeeOrder" class="ui fullscreen modal">
        <div class="header">Guest Feedback History</div>
        <div class="content" style="min-height: 30em;max-height: 30em;overflow-y: auto;">
            <div class="ui labeled input">
                <div class="ui label">
                    Start Date
                </div>
                <input id="employeeOrderStartDate" type="text" placeholder="YYYY/MM/DD">
            </div>
            <div class="ui labeled input">
                <div class="ui label">
                    End Date
                </div>
                <input id="employeeOrderEndDate" type="text" placeholder="YYYY/MM/DD">
            </div>
            <button class="ui button" ng-click="loadEmployeeOrderHistory()">Load</button>
            <br/>
            <br/>
            <div>
                <table class="ui table">
                    <thead>
                    <tr>
                        {{--<th>SERIES</th>--}}
                        <th>EMPLOYEE NAME</th>
                        <th>QTY</th>
                        <th>ITEM NAME</th>
                        <th>REMARKS</th>
                        <th>DATECREATED</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="historyEmployeeOrderD in historyEmployeeOrder">
                        <td><% historyEmployeeOrderD.empName %></td>
                        <td><% historyEmployeeOrderD.qty %></td>
                        <td><% historyEmployeeOrderD.item_name %></td>
                        <td><% historyEmployeeOrderD.remarks %></td>
                        <td><% historyEmployeeOrderD.datecreated %></td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="actions">
            {{--<div class="ui approve button">Approve</div>--}}
            {{--<div class="ui button">Neutral</div>--}}
            <div class="ui cancel button">Close</div>
        </div>
    </div>






    <div class="ui top fixed menu">
        {{--<div ng-click="menuList()" class="item">--}}
        <div class="item">
            {{--<i class="align justify icon"></i>--}}
            <img class="ui middle aligned image" src="{!! URL('/img/logo.png') !!}" style="width: 1em;">
        </div>
        @if(Auth::user()->role_id=="3")
            <div class="item">
                GSS Dashboard
            </div>
        @endif
        @if(Auth::check())
            <div id="menuForFoodOrder" class="right menu menuOption">
                <a class="item" href="{!! URL('logout') !!}">
                    <i class="align log out icon"></i>Logout
                </a>
            </div>
        @endif

    </div>
    <div style="padding-top: 4em;">
        <div class="row uniform">
            <div class="12u 12u(small)" style="padding: 2em;">
                <div class="ui info message">
                    <audio id="AlertSound">
                        <source src="{!! URL('uploads/SonicRingSoundEffect.mp3') !!}" type="audio/mp3">
                        Your browser does not support the audio element.
                    </audio>
                    {{--<i class="close icon"></i>--}}
                    <div class="header">
                        FIRST IN FIRST OUT
                    </div>
                    <ul class="list">
                        <li>Priority the Request from 1 to 3</li>
                        <li>Employee's order must be encoded manually</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row uniform">
            <div class="4u 4u(small)" style="text-align: center;border: dotted #000000;">
                <h2 class="ui header">1. Guest Request</h2>
                <button class="ui button" ng-click="openModal('modalHistoryGuestOrder')">History</button>
                <div class="ui fluid card myOrderCard" style="text-align: left;" ng-repeat="guestRequestCheckOutD in guestRequestCheckOut">
                    <div class="content">
                        <div class="description">
                            <h2 class="header">Requesting for checkout Room: <% guestRequestCheckOutD.roomno %></h2>

                        </div>

                    </div>
                    <div class="ui bottom attached">
                        <div class="ui two buttons">
                            {{--<button ng-click="validateGuestPromoCode(guestRequestPromoCodeD.id)" ng-disabled="promoCodeGButton" class="ui green button">Validate</button>--}}
                            <button ng-click="removedGuestCheckOut(guestRequestCheckOutD.id)"  ng-disabled="checkOutGButton" class="ui red button">Remove</button>
                        </div>
                    </div>
                </div>
                <div class="ui fluid card myOrderCard" style="text-align: left;" ng-repeat="guestRequestPromoCodeD in guestRequestPromoCode">
                    <div class="content">
                        <div class="description">
                            <h2 class="header">Room <% guestRequestPromoCodeD.RoomNo %></h2>
                            <div class="ui middle aligned list">
                                <div class="item">
                                    <div class="content">
                                        PROMO CODE ENTERED : <b><% guestRequestPromoCodeD.DiscountCode %></b>
                                        <br/>
                                        <br/>
                                        CODE DETAILS: <br/>
                                        <p ng-bind-html="trustHtml(guestRequestPromoCodeD.PromoCodeDetails)"></p>

                                    </div>
                                </div>
                            </div>
                            <div class="ui icon message" ng-show="promoCodeGButton">
                                <i class="notched circle loading icon"></i>
                                <div class="content">
                                    <div class="header">
                                        Just one second
                                    </div>
                                    <p>Validating promo Code to POS.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="ui bottom attached">
                        <div class="ui two buttons">
                            {{--<button ng-click="validateGuestPromoCode(guestRequestPromoCodeD.id)" ng-disabled="promoCodeGButton" class="ui green button">Validate</button>--}}
                            <button ng-click="removedGuestPromoCode(guestRequestPromoCodeD.id)"  ng-disabled="promoCodeGButton" class="ui red button">Remove</button>
                        </div>
                    </div>
                </div>
                <div class="ui fluid card myOrderCard" style="text-align: left;" ng-repeat="guestRequestD in guestRequest">
                    <div class="content">
                        <div class="description">
                            <h2 class="header">Room <% guestRequestD.roomno %></h2>
                            <h4 class="header">TransNo <% guestRequestD.transno %></h4>
                            <div class="ui middle aligned list">
                                <div class="item">
                                    <div class="content">
                                        <div class="row uniforms" ng-repeat="itemListD in guestRequestD.itemList">
                                            <div class="1u 1u(small)"><% itemListD.qty %></div>
                                            <div class="7u 7u(small)"><% itemListD.item_name %></div>
                                            <div class="4u 4u(small)">
                                                <button ng-click="changeQuan('ADD',itemListD.id)">+</button>
                                                <button ng-click="changeQuan('SUB',itemListD.id)">-</button>
                                                <button ng-click="changeQuan('DEL',itemListD.id)">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="ui divider"></div>

                                    <div class="row uniforms">
                                        <div class="12u 12u(small)">Notes: <b><% guestRequestD.remarks %></b></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="ui bottom attached">
                        <div class="ui two buttons">
                            <div ng-click="approvedGuestOrder(guestRequestD.transno,guestRequestD.controlno,guestRequestD.roomno)" class="ui green button">Approve</div>
                            <div ng-click="disapprovedGuestOrder(guestRequestD.transno,guestRequestD.controlno,guestRequestD.roomno)" class="ui red button">Decline</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="4u 4u(small)" style="text-align: center;border: dotted #000000;">
                <h2 class="ui header">2. Guest Feedback</h2>
                <button class="ui button" ng-click="openModal('modalHistoryGuestFeedback')">History</button>
                <br>
                <br>
                <select id="guestRoomFeedbackCmbox" class="ui search dropdown" ng-enter="loadRoomTransactions()">
                    <option value="">Rooms</option>
                    <option value="<% roomListD.RoomNo %>" ng-repeat="roomListD in roomList"><% roomListD.RoomNo %></option>
                </select>
                <button class="ui button primary" ng-click="loadRoomTransactions()">Load</button>
                <br/>
                <br/>
                <div style="text-align: left;" ng-show="roomListGenerate">
                    <table class="ui table">
                        <thead>
                        <tr>
                            <th>SeriesNo</th>
                            <th>RoomNo</th>
                            <th>CheckOut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="roomsLastTransactionsD in roomsLastTransactions">
                            <td><% roomsLastTransactionsD.SeriesID %></td>
                            <td><% roomsLastTransactionsD.RoomNo %></td>
                            <td><% roomsLastTransactionsD.DateOut %> <% roomsLastTransactionsD.TimeOut %></td>
                            <td>
                                <button class="ui button secondary" ng-click="loadGuestFeedback(roomsLastTransactionsD.SeriesID,roomsLastTransactionsD.RoomNo,roomsLastTransactionsD.ControlNo)">View</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div style="text-align: left;" ng-show="roomGenerate">

                    <table class="ui table">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Rating</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><% guestFeedbackRoom %></td>
                                <td>Service</td>
                                <td><div id="serviceRating" class="ui large star rating" ></div></td>
                                <td><% guestFeedbackServiceRemarks %></td>
                            </tr>
                            <tr>
                                <td><% guestFeedbackRoom %></td>
                                <td>Room</td>
                                <td><div id="roomRating" class="ui large star rating" ></div></td>
                                <td><% guestFeedbackRoomRemarks %></td>
                            </tr>
                            <tr>
                                <td><% guestFeedbackRoom %></td>
                                <td>Food</td>
                                <td><div id="foodRating" class="ui large star rating" ></div></td>
                                <td><% guestFeedbackFoodRemarks %></td>
                            </tr>
                        </tbody>
                    </table>
                    <form id="servicefeedbackRemarks" class="ui form">
                        <label>Type</label>
                        <br/>
                        <select id="guestTypeFeedbackCmbox" class="ui search dropdown">
                            <option value="COMPLIMENT">COMPLIMENT</option>
                            <option value="COMPLAINT">COMPLAINT</option>
                            <option value="SUGGESTIONS">SUGGESTIONS</option>
                        </select>
                        <br/>
                        <br/>
                        <label>Sub Type</label>
                        <br/>
                        <select id="guestSubTypeFeedbackCmbox" class="ui search dropdown">
                            <option value="SERVICE">SERVICE</option>
                            <option value="ROOM">ROOM</option>
                            <option value="FOOD">FOOD</option>
                        </select>
                        <br/><br/>
                        <label>Remarks</label>

                        <textarea id="guestRemarksFeedback" name="feedbackRemarks" ng-focus="serviceButton = true"><% feedbackRemarks %></textarea>
                        <br/>
                        <br/>
                        <button class="ui button" ng-show="serviceButton" ng-click="saveFeedbackRemarks()">Save</button>
                    </form>


                </div>
            </div>
            <div class="4u 4u(small)" style="text-align: center;border: dotted #000000;">
                <h2 class="ui header">3. Employees Order</h2>
                <button class="ui button" ng-click="openModal('modalHistoryEmployeeOrder')">History</button>
                <div class="ui fluid card myOrderCard" style="text-align: left;" ng-repeat="employeeRequestD in employeeRequest">
                    <div class="content">
                        <div class="description">
                            {{--<h2 class="header">Name</h2>--}}
                            <h2 class="header"><% employeeRequestD.employeeName %></h2>
                            <h4 class="header">TransNo <% employeeRequestD.transno %></h4>
                            <div class="ui middle aligned list">
                                <div class="item">
                                    <div class="content">
                                        <div class="row uniforms" ng-repeat="itemListD in employeeRequestD.itemList">
                                            <div class="1u 1u(small)"><% itemListD.qty %></div>
                                            <div class="11u 11u(small)"><% itemListD.item_name %></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="ui divider"></div>

                                    <div class="row uniforms">
                                        <div class="12u 12u(small)">Notes: <b><% employeeRequestD.remarks %></b></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="ui bottom attached">
                        <div class="ui two buttons">
                            <div ng-click="removeEmployeeOrder(employeeRequestD.transno,employeeRequestD.controlno,employeeRequestD.roomno)" class="ui green button">Remove</div>
                            {{--<div ng-click="disapprovedGuestOrder(employeeRequestD.transno,employeeRequestD.controlno,employeeRequestD.roomno)" class="ui red button">Decline</div>--}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>






</div>

<script>
    $('.menu .item')
            .tab()
    ;
</script>
