{!! Theme::asset()->add('angular-home-css',URL('/').'/themes/default/assets/css/home.css') !!}
{!! Theme::asset()->add('angular-home',URL('/').'/themes/default/assets/js/home.js') !!}



{{--{!! Theme::asset()->add('js-base64',URL('/').'/themes/default/assets/js/base64.js') !!}--}}
{{--{!! Theme::asset()->add('js-canvas2image.min',URL('/').'/themes/default/assets/js/canvas2image.min.js') !!}--}}
{{--{!! Theme::asset()->add('js-html2canvas',URL('/').'/themes/default/assets/js/html2canvas.js') !!}--}}
{{--<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>--}}
{{--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--}}
<style>
    .hidden {
        display: none !important;
    }
    .myOrderCard {
        background-image: url('../img/note22.png') !important;
        background-size: 100% 100% !important;
        min-height: 24em !important;
        padding: 1em !important;
    }
    .txtLeft {
        text-align: left;
        padding-left: 0px !important;
        padding-right: 0px !important;

    }
    .txtRight {
        text-align: right;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    .txtCenter {
        text-align: center;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    .NoTopNBot {
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    #cartFloat {
        background-color: #db2828;
        position: fixed;
        top: 20%;
        right: 0px;
        z-index: 99999;
        width: 4%;
        padding: 1em 0 1em 0;
        /*width: 50px;*/
        /*height: 50px;*/
        text-align: center;
        /*z-index: inherit;*/
        /*vertical-align: middle;*/
    }
    #categoryFloat {
        background-color: #2185d0;
        position: fixed;
        top: 30.3%;
        right: 0px;
        z-index: 99999;
        width: 4%;
        padding: 1em 0 1em 0;
        /*width: 50px;*/
        /*height: 50px;*/
        text-align: center;
        /*z-index: inherit;*/
        /*vertical-align: middle;*/
    }

    @media all and (max-width: 1440px) {
        #cartFloat {
            background-color: #db2828;
            position: fixed;
            top: 20%;
            right: 0px;
            z-index: 99999;
            width: 5%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
        #categoryFloat {
            background-color: #2185d0;
            position: fixed;
            top: 32%;
            right: 0px;
            z-index: 99999;
            width: 5%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
    }

    @media all and (max-width: 1024px) {
        #cartFloat {
            background-color: #db2828;
            position: fixed;
            top: 20%;
            right: 0px;
            z-index: 99999;
            width: 8%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
        #categoryFloat {
            background-color: #2185d0;
            position: fixed;
            top: 32%;
            right: 0px;
            z-index: 99999;
            width: 8%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
    }

    @media all and (max-width: 768px) {
        #cartFloat {
            background-color: #db2828;
            position: fixed;
            top: 20%;
            right: 0px;
            z-index: 99999;
            width: 10%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
        #categoryFloat {
            background-color: #2185d0;
            position: fixed;
            top: 32%;
            right: 0px;
            z-index: 99999;
            width: 10%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
    }

    @media all and (max-width: 425px) {
        #cartFloat {
            background-color: #db2828;
            position: fixed;
            top: 20%;
            right: 0px;
            z-index: 99999;
            width: 18%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
        #categoryFloat {
            background-color: #2185d0;
            position: fixed;
            top: 32%;
            right: 0px;
            z-index: 99999;
            width: 18%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
    }

    @media all and (max-width: 375px) {
        #cartFloat {
            background-color: #db2828;
            position: fixed;
            top: 20%;
            right: 0px;
            z-index: 99999;
            width: 20%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
        #categoryFloat {
            background-color: #2185d0;
            position: fixed;
            top: 32%;
            right: 0px;
            z-index: 99999;
            width: 20%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
    }

    @media all and (max-width: 320px) {
        #cartFloat {
            background-color: #db2828;
            position: fixed;
            top: 20%;
            right: 0px;
            z-index: 99999;
            width: 20%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
        #categoryFloat {
            background-color: #2185d0;
            position: fixed;
            top: 32%;
            right: 0px;
            z-index: 99999;
            width: 20%;
            padding: 1em 0 1em 0;
            /*width: 50px;*/
            /*height: 50px;*/
            text-align: center;
            /*z-index: inherit;*/
            /*vertical-align: middle;*/
        }
    }
    
</style>
<div ng-controller="homeController as homeControllerChild">

    <input type="hidden" id="roomNo" value="{!! $roomNo !!}" />
    <button id="bugfix" ng-click="" class="hidden"></button>


    <div id="cartFloat" class="menuOption hidden" style="color: white;" ng-click="showSubMenu('orderCart')" >
        <i class="large in cart icon"></i>
        <br/>
        CART (<% OrderItemListlength %>)
    </div>
    <div id="categoryFloat" class="menuOption hidden blue" style="color: white;" ng-click="showCategoryModal()" >
        <i class="large in book icon"></i>
        <br/>
        Menu
    </div>
    <div id="categoryModal" class="ui long test modal scrolling">
        <i class="close icon"></i>
        <div class="header">
            Menus
        </div>
        <div class="content scrollable" style="overflow-y: auto !important;height: 500px !important;">
            <div class="description">
                <div id="menuChoices" class="ui styled accordion">
                    <div ng-repeat="menuListArrD in menuListArr" style="overflow-y: auto;">
                        <div class="title">
                            <i class="dropdown icon"></i>
                            <%menuListArrD.classification%>
                        </div>
                        <div class="content">
                            <div class="ui divided selection list">
                                <a class="item" ng-repeat="menuItem in menuListArrD.subClass" ng-click="showFoodListByCategory(menuItem.subclass)">
                                    <div class="ui blue horizontal label"><% menuItem.subclass %></div>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="ui warning message">

                    <div class="header">
                        <i class="volume control phone icon"></i>
                        We will contact you shortly to verify your order
                    </div>
                    *Discounts will be applied on your final receipt
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                Close
            </div>
        </div>
    </div>
    <div id="finish" class="ui test modal scrolling">
        <i class="close icon"></i>
        <div class="header">
            Thank you
        </div>
        <div class="content scrollable" style="overflow: auto;">
            <div class="description">
                Thank you for using victoria court guest help desk <br/>

                <div class="ui warning message">

                    <div class="header">
                        <i class="volume control phone icon"></i>
                        We will contact you shortly to verify your order
                    </div>
                    *Discounts will be applied on your final receipt
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                Close
            </div>
        </div>
    </div>
    {{--Start Modal Cart--}}
    <div id="cartModal" class="ui long test modal scrolling">
        <i class="close icon"></i>
        <div class="header">
            Your Order Cart
        </div>
        <div class="content scrollable" style="overflow: auto;">
            <div class="description">
                <div class="ui large fluid middle aligned divided list ">
                    <div class="item" ng-repeat="itemListDetails2 in OrderItemList">
                        <div class="right floated content">
                            <button ng-click="selectOrder(itemListDetails2.item_no,'1','ADD')" ng-disabled="isDisabled" class="ui tiny label"><i class="align add icon" style="margin: 0px;"></i></button>
                            <span class="ui tiny" style="width: 16px;text-align: right;display: inline-block;"><% itemListDetails2.qty %></span>
                            <button ng-click="selectOrder(itemListDetails2.item_no,'1','SUB')" ng-disabled="isDisabled" class="ui tiny label"><i class="align minus icon" style="margin: 0px;"></i></button>
                            <div class="ui tiny label" style="width: 50px;text-align: right;">₱<% itemListDetails2.unit_price %></div>
                        </div>
                        <img class="ui avatar image" src="{!! URL('/img/noImage.png') !!}">
                        <div class="content">
                            <% itemListDetails2.classification %> - <% itemListDetails2.item_name %>
                            {{--<i class="tiny info circle icon"></i>--}}
                        </div>
                        {{--<div ng-init="$scope.totalUnit=1"></div>--}}
                    </div>
                    <div class="item">
                        <div class="right floated content">
                            <span>Total: </span>
                            <div class="ui tiny label">₱<% totalUnit() %></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="field">
                            <label>Notes / Request:</label>
                            <textarea name="empty" id="orderRemarks" style="width: 100%;" maxlength="100"></textarea>
                        </div>
                    </div>
                </div>
                <div class="ui warning message">

                    <div class="header">
                        <i class="volume control phone icon"></i>
                        We will contact you shortly after you finalized your order
                    </div>
                    *Discounts will be applied on your final receipt
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                Cancel
            </div>
            <button ng-click="submitOrder()" class="ui positive right labeled icon button">
                Submit Order
                <i class="checkmark icon"></i>
            </button>
        </div>
    </div>
    {{--End Modal Cart--}}

    {{--Start Loading--}}
    <div id="loading" class="ui fixed vertical hidden" style="width: 100%;padding-top: 18vh;text-align: center;">
        <img class="ui middle aligned large image" src="{!! URL('/img/vclogo30.png') !!}" style="margin: auto 0;">
    </div>
    {{--end loading--}}


    <div id="mainContent" class="hidden" style="">
        {{--Start Menu Bar--}}
        <div class="ui huge top fixed menu">
            {{--<div ng-click="menuList()" class="item">--}}
            <div ng-click="loadshow('dashboard','menuForDashboard')" class="item">
                {{--<i class="align justify icon"></i>--}}
                {{--<img class="ui middle aligned image" src="{!! URL('/img/logo.png') !!}" style="width: 1em;">--}}
                Home
            </div>
            <div id="categoryFoodlist" class="item fluid hidden">
                <div class="ui icon input" style="width: 12em !important;">
                    <i class="search icon"></i>
                    <input type="text" placeholder="Search..." ng-model="searchItem" id="searchItem" ng-keypress="loadAllItem()">
                </div>
            </div>
            {{--<div ng-click="loadshow('dashboard','menuForDashboard')" class="item">--}}
                {{--Dashboard--}}
            {{--</div>--}}
            <div id="menuForFoodOrder" class="right menu menuOption hidden">
                <div id="orderButton" ng-click="showSubMenu('orderCart')" class="item" data-content="Item Added"  data-position="bottom right">
                    <i class="align cart icon"></i>
                    <% OrderItemListlength %>
                </div>

                {{--<div id="categoryFoodlist" ng-click="showSubMenu('orderCategory')" class="item hidden">--}}
                    {{--<i class="align book icon"></i>Food Categogy--}}
                {{--</div>--}}
            </div>

            @if(Auth::check())
                <div id="menuForLogout" class="right menu menuOption">
                    <a class="item" href="{!! URL('logout') !!}">
                        <i class="align log out icon"></i>Logout
                    </a>
                </div>
            @endif
            <br/>

        </div>

        {{--End Menu Bar--}}
        {{--Start SideBar--}}
        {{--<div id="sideMenu" class="ui left fixed vertical menu hidden">--}}
            {{--<div class="item">--}}
                {{--<img class="ui middle aligned mini image" src="{!! URL('/img/logo.png') !!}">--}}
                {{--<span>Victoria Court</span>--}}
            {{--</div>--}}
            {{--<a class="item" ng-click="loadshow('dashboard','menuForDashboard')">Dashboard</a>--}}
            {{--<a class="item" ng-click="loadshow('foodList','menuForFoodOrder')" class="anim " href="#foodList">Food Order</a>--}}
            {{--<a class="item">My Orders</a>--}}
            {{--<a class="item">My Statement of Account</a>--}}
            {{--<a class="item">Guest Feedback</a>--}}
            {{--<a class="item">Offers</a>--}}
            {{--<a class="item">Promo Code</a>--}}
        {{--</div>--}}

        <br/>
        <br/>
        <br/>
        <br/>
        {{--End SideBar--}}

        {{--Start Dashboard--}}
        <div id="dashboard" class="mainDivHold">

            <div id="" class="ui container stackable one column grid items">
                <div class="item">
                    <div class="row uniform dashboardMenu clearfix" style="width: inherit;">

                        <div ng-click="loadshow('foodList','menuForFoodOrder')" class="6u 6u(small) anim " href="#foodList" style="background-color: #dd1021;">
                            <h2 class="ui center aligned icon header" style="color: white;">
                                <i class="food icon"></i>
                                Food Order
                            </h2>
                        </div>
                        <div ng-click="loadshow('offers','menuForFoodOrder')" class="6u 6u(small) anim " href="#offers" style="background-color: #F64747;">
                            <h2 class="ui center aligned icon header" style="color: white;">
                                <i class="tags icon"></i>
                                Promo
                            </h2>
                        </div>

                        <div ng-click="loadshow('soa','menuForFoodOrder')" class="6u 6u(small) anim " href="#soa" style="background-color: #22313F;">
                            <h2 class="ui center aligned icon header" style="color: white;">
                                <i class="calculator icon"></i>
                                Balance
                            </h2>
                        </div>
                        <div ng-click="loadshow('feedback','menuForFoodOrder')" class="6u 6u(small) anim " href="#feedback" style="background-color: #34495E;">
                            <h2 class="ui center aligned icon header" style="color: white;">
                                <i class="comments icon"></i>
                                Feedback
                            </h2>
                        </div>
                        <div ng-click="loadshow('myOrder','menuForFoodOrder')" class="6u 6u(small) anim " href="#myOrder" style="background-color: #D35400 ;">
                            <h2 class="ui center aligned icon header" style="color: white;">
                                <i class="shop icon"></i>
                                My Orders
                            </h2>
                        </div>
                        <div ng-click="loadshow('promo','menuForFoodOrder')" class="6u 6u(small) anim " href="#promo" style="background-color: #F39C12;">
                            <h2 class="ui center aligned icon header" style="color: white;">
                                <i class="code icon"></i>
                                Promo Code
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-show="dashboardOnly" class="ui container stackable one column grid items">
                <div class="column" style="text-align: center;">
                    <h1 class="ui header">We're turning 30.</h1>
                    <div class="sub header">
                        To thank you, we're giving away <br/>
                        30 iPhone 7 units for 2017.
                    </div>
                    <br>
                    <div class="description">
                        Check out our facebook and Instagram page <br/>
                        for the complete details and mechanics.
                    </div>
                    <div class="row uniform clearfix" style="width: inherit;">
                        <div class="6u 6u(small)">
                            <i class="blue facebook square icon"></i>
                            <div class="content">
                                <a href="https://www.facebook.com/VictoriaCourtPH/" target="_blank" class="header">VictoriaCourtPh</a>
                            </div>
                        </div>
                        <div class="6u 6u(small)">
                            <i class="brown instagram circle icon"></i>
                            <i class="blue twitter circle icon"></i>
                            <div class="content">
                                <a href="https://twitter.com/victoriacourtvc" target="_blank" class="header">victoriacourtvc</a>
                            </div>
                        </div>
                        <div class="6u 6u(small)">
                            <i class="red youtube circle icon"></i>
                            <div class="content">
                                <a href="https://www.youtube.com/feelthedistinction" target="_blank" class="header">feelthedistinction</a>
                            </div>
                        </div>
                        <div class="6u 6u(small)">
                            <i class="world icon"></i>
                            <div class="content">
                                <a href="http://www.victoriacourt.biz/" target="_blank" class="header">www.victoriacourt.biz</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--end dashboard--}}

        {{--Start Food Order Page--}}
        <div id="foodList" class="foodList mainDivHoldContent hidden">

            <div id="orderCategory" class="ui container stackable one column grid items hidden subMenuForFoodOrder">
                <div class="column">
                    <h2>Choose Food Category</h2>
                </div>
                <div class="column">
                    <button ng-click="showFoodListByCategory('Menu')" class="ui large label" style="margin: 3px;">
                        ALL
                    </button>
                    <button ng-click="showFoodListByCategory(categoryDetail.subclass)" ng-repeat="categoryDetail in category" class="ui large label" style="margin: 3px;">
                        <% categoryDetail.subclass %>
                    </button>
                </div>
            </div>


            <br/>
            <br/>
            <br/>
            <div class="ui">
                <div class="sixteen wide column" style="text-align: center;">
                    <h4 class="ui center aligned icon header" style="color:#dd1021;">
                        <i class="food icon"></i>
                        <% itemTitle %>
                    </h4>
                </div>
                {{--<div class="sixteen wide column" style="text-align: center;">--}}
                    {{--<div class="ui container stackable one column grid items">--}}
                        {{--<div class="column">--}}
                            {{--<div class="ui icon input fluid">--}}
                                {{--<i class="search icon"></i>--}}
                                {{--<input type="text" placeholder="Search..." ng-model="searchItem" id="searchItem" ng-keypress="loadAllItem()">--}}
                            {{--</div>--}}

                        {{--</div>--}}

                    {{--</div>--}}

                {{--</div>--}}
                <div class="sixteen wide column">
                    <div class="column">
                        <div class="ui container stackable one column grid items">
                            <div class="column">
                                <div class="ui menu" style="background-color: #e74c3c;">
                                    <div class="right menu">
                                        <a ng-click="convertLayout('convertLayoutGrid')" class="item"><i class="large grid layout icon" style="color:white;"></i></a>
                                        <a ng-click="convertLayout('convertLayoutList')" class="item"><i class="large list layout icon" style="color:white;"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="convertLayoutGrid" class="ui container stackable four column grid items">


                <div class="column" ng-repeat="itemListDetails in itemList2 | filter:searchItem as results  ">
                {{--<div class="column" ng-repeat="itemListDetails in itemList2 | filter:searchItem | filter:{classification: selectedCategory} ">--}}
                {{--<div class="column" ng-repeat="itemListDetails in itemList2 | filter:searchItem | filter:{classification: selectedCategory} ">--}}
                {{--<div class="column" ng-repeat="itemListDetails in itemList2 | filter:'BEER' | filter:'FOOD' ">--}}
                    <div class="ui fluid image" ng-init="myVarImage = '../uploads/fnb/'+itemListDetails.item_no+'.png'">
                        <div class="ui ribbon label" style="background-color: #e74c3c;color:white;">
                            <i class="spoon icon" style="color:white;"></i>
                            <% itemListDetails.classification %>
                        </div>
                        <img class="ui fluid" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" ng-src="<% myVarImage %>" onerror="anonImg(this)">
                    </div>
                    <div class="content">
                        <div class="header"><% itemListDetails.item_name %></div>
                        <div class="meta">
                            <span class="price">₱<% itemListDetails.unit_price %></span>

                            <span class="stay"></span>
                        </div>
                        <div class="description">
                            <p></p>
                        </div>
                        <div class="extra">
                            <button ng-show="!itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red button"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="add to cart icon" ng-show="!myVar"></i>Add to Cart</button>
                            {{--<button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green button"><i class="cart icon"></i>Checkout Order</button>--}}
                            {{--javier pogi--}}
                            <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui green button"><i class="add icon"></i></button>
                            <span ng-show="itemListArr[itemListDetails.item_no]" class="ui"><% itemListQuanArr[itemListDetails.item_no] %></span>
                            <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','SUB')" class="ui green button"><i class="minus icon"></i></button>
                            <span ng-show="itemListArr[itemListDetails.item_no]" class="price">Total: ₱<% itemListPriceArr[itemListDetails.item_no] %></span>
                        </div>
                    </div>
                </div>


            </div>
            <div id="convertLayoutList" class="ui container stackable one column grid items hidden">
                <div class="column">
                    <table class="ui celled table">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr></thead>
                        <tbody>
                            <tr ng-repeat="itemListDetails in itemList2 | filter:searchItem as results  ">
                                <td>
                                    <div class="ui ribbon label" style="background-color: #e74c3c;color:white;"><% itemListDetails.classification %></div>
                                </td>
                                <td><% itemListDetails.item_name %></td>
                                <td style="text-align: right;">₱<% itemListDetails.unit_price %></td>
                                {{--<td style="text-align: right;">₱<% itemListPriceArr[itemListDetails.item_no] %></td>--}}
                                <td>
                                    {{--<button id="O<%itemListDetails.item_no%>" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red label"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="cart icon" ng-show="!myVar"></i>Order</button>--}}
                                    {{--<button id="L<%itemListDetails.item_no%>" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green label hidden"><i class="cart icon"></i><% itemListDetails.orderCount %> Items</button>--}}
                                    {{--<button ng-show="!itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD');" class="ui red label"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="add to cart icon" ng-show="!myVar"></i>Add to Cart</button>--}}
                                    {{--<button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green label"><i class="cart icon"></i>Checkout Order</button>--}}
                                    {{--<button ng-click="" class="ui label"><i class="info icon"></i> Additional Information</button>--}}
                                    <button ng-show="!itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red button"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="add to cart icon" ng-show="!myVar"></i>Add to Cart</button>
                                    {{--<button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green button"><i class="cart icon"></i>Checkout Order</button>--}}
                                    {{--javier pogi--}}
                                    <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui green button"><i class="add icon"></i></button>
                                    <span ng-show="itemListArr[itemListDetails.item_no]" class="ui"><% itemListQuanArr[itemListDetails.item_no] %></span>
                                    <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','SUB')" class="ui green button"><i class="minus icon"></i></button>
                                    <span ng-show="itemListArr[itemListDetails.item_no]" class="price">Total: ₱<% itemListPriceArr[itemListDetails.item_no] %></span>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>


            <div class="ui">

                <div class="sixteen wide column" style="text-align: center;">
                    <div class="ui container stackable one column grid items">

                        <div class="column" ng-show="searchItem==''">
                            <div class="ui button" ng-class="{disabled:pager.currentPage === 1}" ng-click="setPage(pager.currentPage-1)">Prev</div>
                            <div class="ui label">Page: <% pager.currentPage %> / <% pager.totalPages %></div>
                            <div class="ui button" ng-class="{disabled:pager.currentPage === pager.totalPages}" ng-click="setPage(pager.currentPage+1)">Next</div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
        {{--End Food Order --}}

        <div id="myOrder" class="myOrder mainDivHoldContent hidden">
            <div class="ui grid">
                <div class="sixteen wide column" style="text-align: center;">
                    <h2 class="ui center aligned icon header" style="color: #F64747;">
                        <i class="shop icon"></i>
                        My Orders
                    </h2>
                    <div class="ui warning message">

                        <div class="header">
                            <i class="volume control phone icon"></i>
                            Don't hesitate to call us (Dial 0)
                        </div>
                        *Price and Discount will be updated on your final receipt
                    </div>
                </div>
                <div class="sixteen wide column" style="text-align: center;">
                    <div class="ui statistic">
                        <div class="label">
                            TOTAL
                        </div>
                        <div class="value">
                            ₱<% myOrderTotal() %>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui container stackable two column grid items">
                <div class="column" ng-repeat="myOrderListDetailsCart in myOrderListCart">
                    <div class="ui fluid card myOrderCard">
                      <div class="content">
                        {{--<button class="ui right floated labeled icon button">--}}
                          {{--<i class="bell icon"></i>--}}
                          {{--Follow up--}}
                        {{--</button>--}}
                        <div class="description">
                          <h2 class="header">Items <br/>(waiting for validation)</h2>
                          <div class="ui middle aligned list">
                              <div class="item" ng-repeat="myOrderListItemsCart in myOrderListDetailsCart.dataDetails">
                                <div class="content">
                                    <div class="row uniforms">
                                        <div class="1u 1u(small)"><%myOrderListItemsCart.qty%></div>
                                        <div class="11u 11u(small)"><%myOrderListItemsCart.itemname%></div>

                                    </div>
                                </div>
                              </div>
                              <div class="item">
                                  <div class="ui divider"></div>

                                  <div class="row uniforms">
                                      <div class="12u 12u(small)">Notes: <%myOrderListDetailsCart.notes%></div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        {{--<div class="extra content right" style="color:black; font-weight: bolder;">--}}
                            {{--<span class="right floated" style="text-align: right;">--}}
                                {{--TOTAL: ₱<%total%>--}}
                            {{--</span>--}}
                        {{--</div>--}}
                      </div>
                    </div>
                </div>
                <div class="column" ng-repeat="myOrderListDetails in myOrderList">
                    <div class="ui fluid card myOrderCard" ng-init="totalPerTran = 0">
                      <div class="content">
                        {{--<button class="ui right floated labeled icon button">--}}
                          {{--<i class="bell icon"></i>--}}
                          {{--Follow up--}}
                        {{--</button>--}}
                        <div class="description">
                          <h2 class="header">Items</h2>
                          <div class="ui middle aligned list">
                              <div class="item" ng-repeat="myOrderListItems in myOrderListDetails.dataDetails">
                                <div class="content">
                                    <div class="row uniforms">
                                        <div class="1u 1u(small)"><%myOrderListItems.qty%></div>
                                        <div class="5u 5u(small)"><%myOrderListItems.itemname%></div>
                                        <div class="4u 4u(small)">

                                            <div class="left floated content" style="margin: 0em;">
                                                <i class="thumbs down icon"></i>
                                            </div>
                                            <div class="left floated content" style="margin: 0em;">
                                                <div class="ui"><i class="thumbs up icon"></i></div>
                                            </div>

                                            <div class="left floated content" style="margin: 0em;">
                                                <div class="ui"><i class="heart icon"></i></div>
                                            </div>
                                        </div>
                                        <div class="1u 1u(small) txtRight" style="text-align: right;">₱</div>
                                        <div class="1u 1u(small) txtRight" style="text-align: right;"><%myOrderListItems.total%></div>
                                    </div>
                                </div>
                              </div>
                              <div class="item">
                                  <div class="ui divider"></div>
                                  <div class="row uniforms">
                                      <div class="1u 1u(small)">&nbsp;</div>
                                      <div class="5u 5u(small)">&nbsp;</div>
                                      <div class="4u 4u(small)" style="font-weight: bolder;">&nbsp;</div>
                                      <div class="1u 1u(small) txtRight" style="text-align: right;">₱</div>
                                      <div class="1u 1u(small) txtRight" style="text-align: right;"><%myOrderListDetails.totalPrice%></div>
                                  </div>
                                  <div class="row uniforms">
                                      <div class="1u 1u(small)">&nbsp;</div>
                                      <div class="5u 5u(small)">&nbsp;</div>
                                      <div class="4u 4u(small)" style="font-weight: bolder;">DISC:</div>
                                      <div class="1u 1u(small) txtRight" style="text-align: right;">₱</div>
                                      <div class="1u 1u(small) txtRight" style="text-align: right;">-<%myOrderListDetails.totalDisc%></div>
                                  </div>
                                  <div class="row uniforms">
                                      <div class="1u 1u(small)">&nbsp;</div>
                                      <div class="5u 5u(small)">&nbsp;</div>
                                      <div class="4u 4u(small)" style="font-weight: bolder;">TOTAL:</div>
                                      <div class="1u 1u(small) txtRight" style="text-align: right;">₱</div>
                                      <div class="1u 1u(small) txtRight" style="text-align: right;"><%myOrderListDetails.finalTotal%></div>
                                  </div>
                                  <div class="row uniforms">
                                      <div class="12u 12u(small)">Notes: <%myOrderListDetails.notes%></div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        {{--<div class="extra content right" style="color:black; font-weight: bolder;">--}}
                            {{--<span class="right floated" style="text-align: right;">--}}
                                {{--TOTAL: ₱<%total%>--}}
                            {{--</span>--}}
                        {{--</div>--}}
                      </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="soa" class="soa mainDivHoldContent hidden">
            <div class="ui grid">
                <div class="sixteen wide column" style="text-align: center;">
                    <h2 class="ui center aligned icon header">
                        <i class="barcode icon"></i>
                        Remaining Balance
                    </h2>
                    <div class="ui warning message">

                        <div class="header">
                            <i class="volume control phone icon"></i>
                            Don't hesitate to call us (Dial 0)
                        </div>
                        *Price and Discount will be updated on your final receipt
                    </div>
                </div>
                <div class="sixteen wide column">
                    <div class="ui success message" ng-show="showMsgBalance">
                        {{--<i class="close icon"></i>--}}
                        <div class="header">
                            Your request has been send
                        </div>
                        {{--<p>You may now log-in with the username you have chosen</p>--}}
                    </div>
                    {{--<button id="" class="ui button">Checking Out</button>--}}
                    <button class="ui center floated labeled icon button" ng-click="requestToCheckOut()" ng-disabled="requestToCheckOutButton">
                        <i class="bell icon"></i>
                        Request to check out
                    </button>
                    {{--<button id="exportToImageSoa" class="ui button">Download</button>--}}
                </div>
            </div>
            <div id="soaContent" style="padding: 0.5em;background-color: white;">
                <div  class="ui container" style="text-align: center;">
                    <br/>
                    <div class="ui medium header"><% companyName %></div>
                    <p class=""><% companyAddress %><br>
                        <% companyTel %><br>
                        SERIAL No.: <% companySerialNo %><br>
                        VAT REG TIN No.: <% companyTinNo %><br>
                        PERMIT No.: <% companyPermitNo %><br>
                    <div class="row uniform">
                        <div class="10u 10u(small) txtLeft">ROOM #</div>
                        <div class="2u 2u(small) txtRight"><% roomNo %></div>
                    </div>
                    <div class="row uniform">
                        <div class="10u 10u(small) txtLeft">
                            CASHIER : <% cashier %><br/>
                            <%soaDate%>
                        </div>
                        <div class="2u 2u(small) txtRight">
                            #<% username %><br/>
                            <%soaTime%>
                        </div>
                    </div>
                    <div class="ui divider"></div>
                    <div class="row uniform">
                        <div class="6u 6u(small) txtLeft">
                            Machine No: <br/>
                            Checked-In: <br/>
                            Checked-Out: <br/>
                            Duration: <br/>
                        </div>
                        <div class="6u 6u(small) txtRight">
                            WEB<br/>
                            <% soaDateIn %><br/>
                            <% soaDateOut %><br/>
                            <% soaDuration %><br/>
                        </div>
                    </div>
                    <div class="ui divider"></div>
                    <div class="row uniform">
                        <div class="2u 2u(small) txtCenter">QTY</div>
                        <div class="6u 6u(small) txtLeft">DESCRIPTION</div>
                        <div class="4u 4u(small) txtCenter">PRICE</div>
                    </div>
                    <div class="ui divider"></div>
                    <div class="row uniform">
                        <div class="12u 12u(small) txtLeft NoTopNBot" style="font-weight: bolder;">ROOM CHARGE</div>
                    </div>
                    <div class="row uniform">
                        <div class="2u 2u(small) txtCenter NoTopNBot">1</div>
                        <div class="6u 6u(small) txtLeft NoTopNBot"><% soaRoomType %></div>
                        <div class="4u 4u(small) txtRight NoTopNBot">₱<% soaRoomCharge %></div>
                    </div>
                    <div class="row uniform" ng-repeat="soaItemListDetail in soaItemList">
                        <div class="2u 2u(small) txtCenter NoTopNBot"><% soaItemListDetail.itemQty %></div>
                        <div class="6u 6u(small) txtLeft NoTopNBot"><% soaItemListDetail.itemName %></div>
                        <div class="4u 4u(small) txtRight NoTopNBot">₱<% soaItemListDetail.itemTotalF %></div>
                    </div>
                    <div class="ui divider"></div>
                    <div class="row uniform">
                        <div class="6u 6u(small) txtLeft NoTopNBot">TOTAL</div>
                        <div class="6u 6u(small) txtRight NoTopNBot">₱<% soaTotal %></div>
                    </div>
                    <div class="row uniform">
                        <div class="6u 6u(small) txtLeft NoTopNBot">LESS</div>
                        <div class="6u 6u(small) txtRight NoTopNBot">&nbsp;</div>
                    </div>
                    <div class="row uniform">
                        <div class="6u 6u(small) txtLeft NoTopNBot">Vat Exempt: </div>
                        <div class="6u 6u(small) txtRight NoTopNBot">₱<% soaVatExempt %></div>
                    </div>
                    <div class="row uniform">
                        <div class="6u 6u(small) txtLeft NoTopNBot">Discount: </div>
                        <div class="6u 6u(small) txtRight NoTopNBot">₱<% soaDiscountAmount %></div>
                    </div>
                    <div class="row uniform">
                        <div class="6u 6u(small) txtLeft NoTopNBot">Advance Deposit: </div>
                        <div class="6u 6u(small) txtRight NoTopNBot">₱<% soaAdvanceDeposit %></div>
                    </div>
                    <div class="ui divider"></div>
                    <div class="row uniform" style="font-weight: bolder;">
                        <div class="6u 6u(small) txtLeft NoTopNBot">AMOUNT DUE: </div>
                        <div class="6u 6u(small) txtRight NoTopNBot">₱<% soaAmountDue %></div>
                    </div>
                    <div class="row uniform" ng-repeat="soaDiscountDetails1 in soaDiscountDetails">
                        <div class="12u 12u(small) NoTopNBot txtLeft"><% soaDiscountDetails1.discountDesc %></div>
                    </div>
                    <div class="row uniform">
                        <div class="6u 6u(small) txtLeft "><% soaControlNo %></div>
                        <div class="6u 6u(small) txtRight ">SOA No.: <% soaNo %></div>
                    </div>
                    <div class="row uniform">
                        <div class="12u 12u(small) txtCenter"><div class="ui medium header">REMAINING BALANCE</div></div>
                    </div>

                </div>
            </div>

        </div>
        <div id="feedback" class="feedback mainDivHoldContent hidden">
            <div class="ui grid">
                <div class="sixteen wide column" style="text-align: center;">
                    <h2 class="ui center aligned icon header">
                        <i class="comments icon"></i>
                        Feedback
                    </h2>
                </div>
            </div>
            @if(Auth::check())
                <div id="" class="ui negative message">
                    {{--<i class="close icon"></i>--}}
                    <div class="header">
                        NOT AVAILABLE FOR EMPLOYEES
                    </div>
                </div>
            @else
                <div class="ui container stackable one column grid items">
                    <div class="column">
                        <div class="row uniform">
                            <div class="4u 12u(small)">
                                <h2>Service <div id="serviceRating" class="ui huge star rating" data-rating="0" ng-click="showRemarks('servicefeedbackRemarks','serviceRating')"></div><br/><% serviceRating %></h2>
                                <form id="servicefeedbackRemarks" class="ui form hidden">
                                    <label>Remarks</label>
                                    <textarea id="serviceRemarksFeedback" name="feedbackRemarks" ng-focus="serviceButton = true"><% serviceRemarks %></textarea>
                                    <br/>
                                    <br/>
                                    <button class="ui button" ng-show="serviceButton" ng-click="saveFeedbackRemarks('Service','serviceRemarksFeedback')">Save</button>
                                </form>

                            </div>
                            <div class="4u 12u(small)">
                                <h2>Room <div id="roomRating" class="ui huge star rating" data-rating="0" ng-click="showRemarks('roomfeedbackRemarks','roomRating')"></div><br/><% roomRating %></h2>
                                <form id="roomfeedbackRemarks" class="ui form hidden">
                                    <label>Remarks</label>
                                    <textarea id="roomRemarksFeedback" name="feedbackRemarks" ng-focus="roomButton = true"><% roomRemarks %></textarea>
                                    <br/>
                                    <br/>
                                    <button class="ui button" ng-show="roomButton" ng-click="saveFeedbackRemarks('Room','roomRemarksFeedback')">Save</button>
                                </form>
                            </div>
                            <div class="4u 12u(small)">
                                <h2>Food <div id="foodRating" class="ui huge star rating" data-rating="0" ng-click="showRemarks('foodfeedbackRemarks','foodRating')"></div><br/><% foodRating %></h2>
                                <form id="foodfeedbackRemarks" class="ui form hidden">
                                    <label>Remarks</label>
                                    <textarea id="foodRemarksFeedback" name="feedbackRemarks" ng-focus="foodButton = true"><% foodRemarks %></textarea>
                                    <br/>
                                    <br/>
                                    <button class="ui button" ng-show="foodButton" ng-click="saveFeedbackRemarks('Food','foodRemarksFeedback')">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div id="offers" class="offers mainDivHoldContent hidden">
            <div class="ui grid">
                <div class="sixteen wide column" style="text-align: center;">
                    <h2 class="ui center aligned icon header">
                        <i class="tags icon"></i>
                        Promo
                    </h2>
                </div>
            </div>
            <div class="ui grid">
                <div class="sixteen wide column">
                    <div class="column">
                        <div class="ui container stackable one column grid items">
                            <div class="column">
                                <div class="ui menu" style="background-color: #e74c3c;">
                                    <div class="right menu">
                                        <a ng-click="convertLayout('convertLayoutGridOffers')" class="item"><i class="large grid layout icon" style="color:white;"></i></a>
                                        <a ng-click="convertLayout('convertLayoutListOffers')" class="item"><i class="large list layout icon" style="color:white;"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="convertLayoutGridOffers" class="ui container stackable four column grid items">


                <div class="column" ng-repeat="itemListDetails in itemList2 | filter:searchItem as results  ">
                    {{--<div class="column" ng-repeat="itemListDetails in itemList2 | filter:searchItem | filter:{classification: selectedCategory} ">--}}
                    {{--<div class="column" ng-repeat="itemListDetails in itemList2 | filter:searchItem | filter:{classification: selectedCategory} ">--}}
                    {{--<div class="column" ng-repeat="itemListDetails in itemList2 | filter:'BEER' | filter:'FOOD' ">--}}
                    <div class="ui fluid image" ng-init="myVarImage = '../uploads/fnb/'+itemListDetails.item_no+'.png'">
                        <div class="ui ribbon label" style="background-color: #e74c3c;color:white;">
                            <i class="spoon icon" style="color:white;"></i>
                            <% itemListDetails.classification %>
                        </div>
                        <img class="ui fluid" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" ng-src="<% myVarImage %>" onerror="anonImg(this)">
                    </div>
                    <div class="content">
                        <div class="header"><% itemListDetails.item_name %></div>
                        <div class="meta">
                            <span class="price">₱<% itemListDetails.unit_price %></span>
                            {{--<span class="price">₱<% itemListPriceArr[itemListDetails.item_no] %></span>--}}
                            <span class="stay"></span>
                        </div>
                        <div class="description">
                            <p></p>
                        </div>
                        <div class="extra">
                            {{--<button id="O<%itemListDetails.item_no%>" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red label"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="cart icon" ng-show="!myVar"></i>Order</button>--}}
                            {{--<button id="L<%itemListDetails.item_no%>" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green label hidden"><i class="cart icon"></i><% itemListDetails.orderCount %> Items</button>--}}
                            {{--<button ng-show="!itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red button"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="add to cart icon" ng-show="!myVar"></i>Add to Cart</button>--}}
                            {{--<button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green button"><i class="cart icon"></i>Checkout Order</button>--}}
                            {{--<button ng-click="" class="ui button"><i class="info icon"></i> Additional Information</button>--}}
                            <button ng-show="!itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red button"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="add to cart icon" ng-show="!myVar"></i>Add to Cart</button>
                            {{--<button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green button"><i class="cart icon"></i>Checkout Order</button>--}}
                            {{--javier pogi--}}
                            <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui green button"><i class="add icon"></i></button>
                            <span ng-show="itemListArr[itemListDetails.item_no]" class="ui"><% itemListQuanArr[itemListDetails.item_no] %></span>
                            <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','SUB')" class="ui green button"><i class="minus icon"></i></button>
                            <span ng-show="itemListArr[itemListDetails.item_no]" class="price">Total: ₱<% itemListPriceArr[itemListDetails.item_no] %></span>
                        </div>
                    </div>
                </div>


            </div>
            <div id="convertLayoutListOffers" class="ui container stackable one column grid items hidden">
                <div class="column">
                    <table class="ui celled table">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr></thead>
                        <tbody>
                        <tr ng-repeat="itemListDetails in itemList2 | filter:searchItem as results  ">
                            <td>
                                <div class="ui ribbon label" style="background-color: #e74c3c;color:white;"><% itemListDetails.classification %></div>
                            </td>
                            <td><% itemListDetails.item_name %></td>
                            <td style="text-align: right;">₱<% itemListDetails.unit_price %></td>
                            {{--<span class="price">₱<% itemListPriceArr[itemListDetails.item_no] %></span>--}}
                            <td>
                                {{--<button id="O<%itemListDetails.item_no%>" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red label"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="cart icon" ng-show="!myVar"></i>Order</button>--}}
                                {{--<button id="L<%itemListDetails.item_no%>" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green label hidden"><i class="cart icon"></i><% itemListDetails.orderCount %> Items</button>--}}
                                {{--<button ng-show="!itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD');" class="ui red label"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="add to cart icon" ng-show="!myVar"></i>Add to Cart</button>--}}
                                {{--<button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green label"><i class="cart icon"></i>Checkout Order</button>--}}
                                {{--<button ng-click="" class="ui label"><i class="info icon"></i> Additional Information</button>--}}
                                <button ng-show="!itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui red button"><i class="ui mini active inline loader" ng-show="myVar"></i><i class="add to cart icon" ng-show="!myVar"></i>Add to Cart</button>
                                {{--<button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="showSubMenu('orderCart')" class="ui green button"><i class="cart icon"></i>Checkout Order</button>--}}
                                {{--javier pogi--}}
                                <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','ADD')" class="ui green button"><i class="add icon"></i></button>
                                <span ng-show="itemListArr[itemListDetails.item_no]" class="ui"><% itemListQuanArr[itemListDetails.item_no] %></span>
                                <button ng-show="itemListArr[itemListDetails.item_no]" ng-disabled="isDisabled" ng-click="selectOrder(itemListDetails.item_no,'1','SUB')" class="ui green button"><i class="minus icon"></i></button>
                                <span ng-show="itemListArr[itemListDetails.item_no]" class="price">Total: ₱<% itemListPriceArr[itemListDetails.item_no] %></span>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="ui ">

                <div class="sixteen wide column" style="text-align: center;">
                    <div class="ui container stackable one column grid items">

                        <div class="column" ng-show="searchItem==''">
                            <div class="ui button" ng-class="{disabled:pager.currentPage === 1}" ng-click="setPage(pager.currentPage-1)">Prev</div>
                            <div class="ui label">Page: <% pager.currentPage %> / <% pager.totalPages %></div>
                            <div class="ui button" ng-class="{disabled:pager.currentPage === pager.totalPages}" ng-click="setPage(pager.currentPage+1)">Next</div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div id="promo" class="promo mainDivHoldContent hidden">
            <div class="ui grid">
                <div class="sixteen wide column" style="text-align: center;">
                    <h2 class="ui center aligned icon header">
                        <i class="code icon"></i>
                        Promo Code
                    </h2>
                </div>
            </div>
            <div class="ui container stackable one column grid items">
                <div class="column">
                    @if(Auth::check())
                        <div id="" class="ui negative message">
                            {{--<i class="close icon"></i>--}}
                            <div class="header">
                                NOT AVAILABLE FOR EMPLOYEES
                            </div>
                        </div>
                    @else
                        <div class="ui info message">
                            {{--<i class="close icon"></i>--}}
                            <div class="header">
                                Promo code mechanics
                            </div>
                            <ul class="list">
                                <li>Can only accept 1 ROOM price discount related promo code.</li>
                                <li>You can enter one or more ITEM related promo code.</li>
                                <li>All promo code will be subject for approval on our side.</li>
                                <li>Promo code that you already enter cannot be remove or cancel.</li>
                            </ul>
                        </div>
                        <form class="ui form">
                            <div class="field">
                                <label>Enter promo Code</label>
                                <input id="promoCode" name="promoCode" type="text" />
                            </div>

                            <div class="ui submit button" ng-click="submitPromoCode()">Submit</div>
                            <div class="ui error message"></div>
                        </form>
                        <div id="promoCodeErrorDiv" class="ui negative message" ng-show="promoCodeErrorMsgFlag">
                            {{--<i class="close icon"></i>--}}
                            <div class="header">
                                We're sorry we can't apply that promo code
                            </div>
                            <p><% promoCodeErrorMsg %>
                            </p>
                        </div>
                        <table class="ui table">
                            <thead>
                            <tr>
                                <th>Promo Code</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="promoCodeContentD in promoCodeContent">
                                <td><% promoCodeContentD.promo_code %></td>
                                <td ng-if="promoCodeContentD.promo_code_type=='ITEM'">
                                    <% promoCodeContentD.promo_code_type %>S
                                    <br/>
                                    <p ng-repeat="promoCodeContentDitems in promoCodeContentD.items"><% promoCodeContentDitems.item_name %></p>
                                </td>
                                <td ng-if="promoCodeContentD.promo_code_type=='ROOM DISC. BY %'">LESS <% promoCodeContentD.promo_code_value %>% IN ROOM CHARGE.</td>
                                <td ng-if="promoCodeContentD.promo_code_type=='ROOM DISC. BY AMOUNT'">LESS ₱<% promoCodeContentD.promo_code_value %> IN ROOM CHARGE.</td>
                                <td ng-if="promoCodeContentD.status==0">Processing</td>
                                <td ng-if="promoCodeContentD.status==1">Applied</td>
                                <td ng-if="promoCodeContentD.status==2">Disapproved</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="ui bottom attached warning message">
                            <i class="icon help"></i>
                            Do you have any concern? Don't hesitate to call us, just dial 0.
                        </div>
                    @endif()

                </div>
            </div>
        </div>

    </div>

</div>

<script>
    $(".dropdown").dropdown();
    $("#bugfix")
            .popup({
                on       : 'click',
                position : 'bottom right',
                target   : '#orderButton',
                title    : 'Cart updated',
                content  : '',
                delay: {
                    show: 100,
                    hide: 100
                }
            })
    ;

    $('.dashboardMenu div').on('click',function(e){
        e.preventDefault();
//        $('.header').removeAttr('style');
//        var style = $(this).css('background-color');
//        var color = Handee.table.color(style);
//        Handee.table.init(color);
//        $('.handee').css('color','transparent');
//        $(this).hide();
//        $(this).siblings().addClass('hidden').delay(100);
        $(this).siblings().removeClass('active').delay(100).addClass('inactive');
        $(this).removeClass('inactive').addClass('active');
        var page = $(this).attr('href').replace('#','');
//        $('.html').removeClass('show');
        setTimeout(function(){
//            $('.handee').css('color',style);
//            $('.header').attr('style','color:#fff;background:'+style).addClass('fadeIn animated');
//            $('.header .fa').removeClass('hide');
            $('.'+page).removeClass('hidden');
        },1800);
        setTimeout(function(){
            $('.dashboardMenu div').removeAttr('class');
            $('.dashboardMenu').addClass('hidden');
        },1500);
    });


    $("#exportToImageSoa").click(function(){
        html2canvas(document.getElementById("soaContent"), {
            onrendered: function(canvas) {
                Canvas2Image.saveAsPNG(canvas);
            }
        });
    });
    $('.menu .item')
            .tab()
    ;
    $('.rating')
            .rating({
                initialRating: 0,
                maxRating: 5
            })
    ;
    $('#menuChoices').accordion();

</script>