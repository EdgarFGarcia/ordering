// angular.module('MainApp', ['angularUtils.directives.dirPagination']);
MainApp.factory('PagerService', PagerService);
MainApp.directive('isImage', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            // alert("a");
            element.bind('load', function() {
                alert('image is loaded');
            });
        }
    };
});
MainApp.controller('homeController', function($http,$rootScope,$scope,$sce){
    //initialized default variables
    var url2 = $("#urlVal").val();
    var roomNo = $("#roomNo").val();
    var SOCKET = $().nodeConnect();
    SOCKET.emit('room_login', { uid: roomNo });
    $scope.myVar = false;
    $scope.pager = {};
    $scope.setPage = setPage;
    $scope.searchItem = '';
    $rootScope.itemListArr = {};
    $rootScope.itemListQuanArr = {};
    $rootScope.itemListPriceArr = {};
    $scope.itemTitle = "Menu";
    $scope.dashboardOnly = true;
    $scope.showMsgBalance = false;
    // $scope.myOrderTotal = 0;
    loadMenuByClassification();
    $scope.showCategoryModal = function() {
        $('#categoryModal')
            .modal('setting', {
                onShow : function() {
                    setTimeout(function(){
                        $("#cartFloat").addClass("hidden");
                        $("#categoryFloat").addClass("hidden");
                    },250);

                },
                onHidden : function(){
                    $("#cartFloat").removeClass("hidden");
                    $("#categoryFloat").removeClass("hidden");
                    // $scope.loadshow('dashboard','menuForDashboard');
                }
            }).modal('show');
    }
    $scope.submitPromoCode = function(){
        var promoCode = $("#promoCode").val();
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        formData.append('promoCode',promoCode);
        $scope.promoCodeErrorMsgFlag = false;
        $http.post(url2+'/submitPromoCode',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                // $("#"+id).removeClass("hidden");
                var status = response.data.status;
                if(status=="Success"){
                    $scope.promoCodeErrorMsgFlag = false;
                } else {
                    $scope.promoCodeErrorMsg = status;
                    $scope.promoCodeErrorMsgFlag = true;


                }
                loadPromoCode();
                SOCKET.emit('refreshCashierDashboard', { uid: roomNo });
                // location.reload();

            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }

    $scope.showRemarks = function(id,type){
        var getType = "";
        var getRating = "";
        var ratingLabel = "";


        if(type=="serviceRating"){
            getType = "Service";
            getRating = $("#serviceRating").rating('get rating');
            if(getRating=="5"){
                ratingLabel = "Love it";
            } else if(getRating=="4"){
                ratingLabel = "Liked it";
            } else if(getRating=="3"){
                ratingLabel = "It's ok";
            } else if(getRating=="2"){
                ratingLabel = "Disliked it";
            } else if(getRating=="1"){
                ratingLabel = "Hated it";
            }
            $scope.serviceRating = ratingLabel;
        } else if(type=="roomRating") {
            getType = "Room";
            getRating = $("#roomRating").rating('get rating');
            if(getRating=="5"){
                ratingLabel = "Love it";
            } else if(getRating=="4"){
                ratingLabel = "Liked it";
            } else if(getRating=="3"){
                ratingLabel = "It's ok";
            } else if(getRating=="2"){
                ratingLabel = "Disliked it";
            } else if(getRating=="1"){
                ratingLabel = "Hated it";
            }
            $scope.roomRating = ratingLabel;
        } else if(type=="foodRating"){
            getType = "Food";
            getRating = $("#foodRating").rating('get rating');
            if(getRating=="5"){
                ratingLabel = "Love it";
            } else if(getRating=="4"){
                ratingLabel = "Liked it";
            } else if(getRating=="3"){
                ratingLabel = "It's ok";
            } else if(getRating=="2"){
                ratingLabel = "Disliked it";
            } else if(getRating=="1"){
                ratingLabel = "Hated it";
            }
            $scope.foodRating = ratingLabel;
        }



        var formData = new FormData();
        formData.append('roomNo',roomNo);
        formData.append('ratingType',getType);
        formData.append('ratingValue',getRating);

        $http.post(url2+'/saveFeedbackStar',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $("#"+id).removeClass("hidden");
                SOCKET.emit('refreshCashierDashboard', { uid: roomNo });
                // location.reload();

            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
        // alert(serviceRating);

    }
    $scope.saveFeedback = function(){
        var serviceRating = $("#serviceRating").rating('get rating');
        var roomRating = $("#roomRating").rating('get rating');
        var foodRating = $("#foodRating").rating('get rating');
        var feedbackRemarks = $("#feedbackRemarks").val();

        // alert(feedbackRemarks);
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        formData.append('serviceRating',serviceRating);
        formData.append('roomRating',roomRating);
        formData.append('foodRating',foodRating);
        formData.append('feedbackRemarks',feedbackRemarks);

        $http.post(url2+'/saveFeedback',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                SOCKET.emit('refreshCashierDashboard', { uid: roomNo });
                location.reload();

            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }

    $scope.submitOrder = function(){
        var orderRemarks = $("#orderRemarks").val();
        var getRoomNo = roomNo;
        //javier


        var formData = new FormData();
        formData.append('roomNo',getRoomNo);
        formData.append('notes',orderRemarks);
        $http.post(url2+'/saveCartOrder',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                SOCKET.emit('refreshCashierDashboard', { uid: roomNo });
                // location.reload();

                $('#finish')
                    .modal('setting', {
                        onShow : function() {
                            setTimeout(function(){
                                $("#cartFloat").addClass("hidden");
                                $("#categoryFloat").addClass("hidden");
                            },250);

                        },
                        onHidden : function(){

                            $scope.loadshow('dashboard','menuForDashboard');
                        }
                    }).modal('show');

            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }


    $scope.loadAllItem = function(){
        if($("#searchItem").val()==''){
            initController();
        } else {
            $scope.itemList2 = $scope.itemList;
        }
    }

    $scope.menuList = function(){
        $('#sideMenu')
            .transition('slide right')
        ;
    }

    $scope.showFoodListByCategory = function(param) {
        $("#categoryModal").modal("hide");
        $scope.itemTitle = param;
        loadItemListByCategory(param);
    }

    $scope.selectOrder = function(item_no,qty,type) {
        var fmitemNo = item_no;
        var fmroomNo = roomNo;
        $scope.isDisabled = true;
        updateOrder(fmroomNo,fmitemNo,qty,type);
    }

    $scope.showSubMenu = function(id) {
        if(id=="orderCategory") {
            if($('#'+id).hasClass("hidden")){
                $('#'+id).removeClass("hidden");
            } else {
                $('#'+id).addClass("hidden");
            }
            var formData = new FormData();
            formData.append('content',"");
            $http.post(url2+'/loadCategory',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
                .then(function successCallBack(response){
                    $scope.category = response.data.content;

                }, function errorCallback(response) {})
                .then(function errorCallBack(response){});
        } else {
            loadOrderCart(roomNo);
            $('#cartModal')
                .modal('setting', {
                    onHidden : function(){
                        $("#cartFloat").removeClass("hidden");
                        $("#categoryFloat").removeClass("hidden");
                    }
                }).modal('show');

            $("#cartFloat").addClass("hidden");
            $("#categoryFloat").addClass("hidden");
        }
    }

    $scope.loadshow = function(id,menu) {
        // alert(id);
        if(!$("#sideMenu").hasClass("hidden")) {
            $('#sideMenu')
                .transition('slide right')
            ;
        }
        // $('.mainDivHold').addClass("hidden");
        // $('#'+id).removeClass("hidden");
        // $('.mainDivHold').addClass("hidden");
        // $('#'+id).removeClass("hidden");
        $scope.dashboardOnly = true;
        $(".mainDivHoldContent").addClass("hidden");
        $('.dashboardMenu div').addClass('6u 6u(small) anim');
        $('.dashboardMenu').removeClass('hidden');
        $('.menuOption').addClass("hidden");

        if(id=="foodList") {
            loadItemListByCategory("");
            loadOrderCart(roomNo);
            $('#categoryFoodlist').removeClass("hidden");
            $('#cartFloat').removeClass("hidden");
            $('#categoryFloat').removeClass("hidden");
            $('#'+menu).removeClass("hidden");
            $scope.dashboardOnly = false;
        } else if(id=="myOrder") {
            loadMyOrder();
            $scope.dashboardOnly = false;
        } else if(id=="soa") {
            loadVcInfo();
            $scope.dashboardOnly = false;
        } else if(id=="feedback") {
            loadGuestFeedback();
            $scope.dashboardOnly = false;
        } else if(id=="offers") {
            loadItemListByCategory("PROMO");
            loadOrderCart(roomNo);
            $('#categoryFoodlist').addClass("hidden");
            $('#cartFloat').removeClass("hidden");
            $('#categoryFloat').removeClass("hidden");
            $('#'+menu).removeClass("hidden");
            $scope.dashboardOnly = false;
        } else if(id=="promo") {
            loadPromoCode();
            $scope.dashboardOnly = false;
        } else if(id=="dashboard") {
            $scope.itemTitle = "Menu";
            $("#menuForLogout").removeClass("hidden");
        } else if(id=="") {
            $scope.dashboardOnly = false;
        }
    }
    
    $scope.requestToCheckOut = function () {
        $scope.requestToCheckOutButton = true;
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        $http.post(url2+'/requestcheckOut',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.requestToCheckOutButton = false;
                $scope.showMsgBalance = true;
                SOCKET.emit('refreshCashierDashboard', { uid: roomNo });
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }

    function loadPromoCode() {
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        $http.post(url2+'/loadPromoCode',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.promoCodeContent = response.data.content;
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }

    $scope.convertLayout = function(param){
        if(param=="convertLayoutGrid"){
            $("#convertLayoutGrid").removeClass("hidden");
            $("#convertLayoutList").addClass("hidden");
        } else {
            $("#convertLayoutGrid").addClass("hidden");
            $("#convertLayoutList").removeClass("hidden");
        }
    }

    $scope.loadItemInfo = function(){

    }




    //Node

    SOCKET.on('changeOrderButton', function (data) {
        // $scope.itemTitle = data.itemNo;
        setDisplay(data.itemNo,data.status);
        // alert($scope.itemListArr[data.itemNo]);
    });

    //Node
    $scope.saveFeedbackRemarks = function($feedbackType,$remarksId){
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        formData.append('feedbackType',$feedbackType);
        formData.append('remarks',$("#"+$remarksId).val());
        $http.post(url2+'/saveFeedbackRemarks',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                if($feedbackType=="Service"){
                    $scope.serviceButton = false;
                } else if($feedbackType=="Room") {
                    $scope.roomButton = false;
                } else {
                    $scope.foodButton = false;
                }
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }

    function loadGuestFeedback() {
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        $http.post(url2+'/loadMyFeedback',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $("#serviceRating").rating('set rating',response.data.serviceStar);
                $("#roomRating").rating('set rating',response.data.roomStar);
                $("#foodRating").rating('set rating',response.data.foodStar);
                var ratingLabel1 = "";
                if(response.data.serviceStar=="5"){
                    ratingLabel1 = "Love it";
                } else if(response.data.serviceStar=="4"){
                    ratingLabel1 = "Liked it";
                } else if(response.data.serviceStar=="3"){
                    ratingLabel1 = "It's ok";
                } else if(response.data.serviceStar=="2"){
                    ratingLabel1 = "Disliked it";
                } else if(response.data.serviceStar=="1"){
                    ratingLabel1 = "Hated it";
                }
                $scope.serviceRating = ratingLabel1;
                var ratingLabel2 = "";
                if(response.data.roomStar=="5"){
                    ratingLabel2 = "Love it";
                } else if(response.data.roomStar=="4"){
                    ratingLabel2 = "Liked it";
                } else if(response.data.roomStar=="3"){
                    ratingLabel2 = "It's ok";
                } else if(response.data.roomStar=="2"){
                    ratingLabel2 = "Disliked it";
                } else if(response.data.roomStar=="1"){
                    ratingLabel2 = "Hated it";
                }
                $scope.roomRating = ratingLabel2;
                // alert(ratingLabel2);
                var ratingLabel3 = "";
                if(response.data.foodStar=="5"){
                    ratingLabel3 = "Love it";
                } else if(response.data.foodStar=="4"){
                    ratingLabel3 = "Liked it";
                } else if(response.data.foodStar=="3"){
                    ratingLabel3 = "It's ok";
                } else if(response.data.foodStar=="2"){
                    ratingLabel3 = "Disliked it";
                } else if(response.data.foodStar=="1"){
                    ratingLabel3 = "Hated it";
                }
                $scope.foodRating = ratingLabel3;


                if(response.data.serviceStar!="0"){$("#servicefeedbackRemarks").removeClass("hidden");}
                if(response.data.roomStar!="0"){$("#roomfeedbackRemarks").removeClass("hidden");}
                if(response.data.foodStar!="0"){$("#foodfeedbackRemarks").removeClass("hidden");}

                $scope.serviceStar = response.data.serviceStar;
                $scope.serviceRemarks = response.data.serviceRemarks;

                $scope.roomStar = response.data.roomStar;
                $scope.roomRemarks = response.data.roomRemarks;

                $scope.foodStar = response.data.foodStar;
                $scope.foodRemarks = response.data.foodRemarks;
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }


    function setDisplay(param1,param2) {
        // angular.element('#assemblystatustbl').scope().activate();
        $scope.itemListArr[param1] = param2;
        // $scope.$apply();
        // $("#bugfix").click();
        $scope.isDisabled = false;
        $scope.$apply();
        // loadOrderCart(roomNo);
        $("#bugfix").click();


    }




    function initController() {
        setPage(1);
    }

    function setPage(page) {

        if(page=="all"){
            $scope.pager = GetPager($scope.itemList.length, 1);
            $scope.itemList2 = $scope.itemList;
        } else {
            if (page < 1 || page > $scope.pager.totalPages) {
                return;
            }
            // get pager object from service
            $scope.pager = GetPager($scope.itemList.length, page);



            // get current page of items
            $scope.itemList2 = $scope.itemList.slice($scope.pager.startIndex, $scope.pager.endIndex + 1);


            // alert($scope.itemListArr.length);

            // itemListArr[itemListDetails.item_no] = false;
        }

    }

    function loadMyOrder() {
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        $http.post(url2+'/loadMyOrder',formData,{
            transformRequest: angular.identity,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':'*/*',
                'Content-type':undefined,
            },
            params:formData
        })
            .then(function successCallBack(response){
                $scope.myOrderList = response.data.content;
                // alert(response.data.contentCart);
                $scope.myOrderListCart = response.data.contentCart;
                $scope.myOrderTotal = function(){
                    var total = 0;
                    for(var i = 0; i < $scope.myOrderList.length; i++){
                        var product = $scope.myOrderList[i];
                        total += parseFloat(product.finalTotal);
                    }
                    return total;

                }
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }

    function loadVcInfo() {
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        $http.post(url2+'/loadVcInfo',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.companyName = response.data.companyName;
                $scope.companyAddress = response.data.companyAddress;
                $scope.companyTel = response.data.companyTel;
                $scope.companySerialNo = response.data.companySerialNo;
                $scope.companyTinNo = response.data.companyTinNo;
                $scope.companyAcreNo = response.data.companyAcreNo;
                $scope.companyPermitNo = response.data.companyPermitNo;
                $scope.roomNo = response.data.roomNo;
                $scope.cashier = response.data.cashier;
                $scope.username = response.data.username;

                $scope.soaDate = response.data.soaDate;
                $scope.soaTime = response.data.soaTime;
                $scope.soaNo = response.data.soaNo;

                $scope.soaDateIn = response.data.soaDateIn;
                $scope.soaDateOut = response.data.soaDateOut;
                $scope.soaDuration = response.data.soaDuration;

                $scope.soaRoomType = response.data.soaRoomType;
                $scope.soaRoomCharge = response.data.soaRoomCharge;

                $scope.soaItemList = response.data.soaItemList;
                $scope.soaTotal = response.data.soaTotal;
                $scope.soaAdvanceDeposit = response.data.soaAdvanceDeposit;
                $scope.soaDiscountAmount = response.data.soaDiscountAmount;
                $scope.soaVatExempt = response.data.soaVatExempt;
                $scope.soaAmountDue = response.data.soaAmountDue;
                $scope.soaDiscountDetails = response.data.soaDiscountDetails;
                $scope.soaControlNo = response.data.soaControlNo;
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }


    function loadItemListByCategory(param){
        if(param=="Menu"){param="";}
        $("#searchItem").val('');
        $scope.searchItem = '';
        var formData = new FormData();
        formData.append('category',param);
        formData.append('roomNo',roomNo);
        $http.post(url2+'/loadItemListByCategory',formData,{
            transformRequest: angular.identity,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':'*/*',
                'Content-type':undefined,
            },
            params:formData
        })
            .then(function successCallBack(response){
                $scope.itemList = response.data.content;
                for(x=0;x<=$scope.itemList.length-1;x++){
                    // alert($scope.itemList2[x].item_no);
                    if($scope.itemList[x].orderCount>0){
                        $rootScope.itemListArr[$scope.itemList[x].item_no] = true;
                        $rootScope.itemListQuanArr[$scope.itemList[x].item_no] = $scope.itemList[x].orderCount;
                        // alert($scope.itemList[x].orderCount);
                    } else {
                        $rootScope.itemListArr[$scope.itemList[x].item_no] = false;
                    }

                    $rootScope.itemListPriceArr[$scope.itemList[x].item_no] = $scope.itemList[x].orderPrice;

                    // alert($scope.itemListArr[$scope.itemList2[x].item_no]);
                }
                initController();

            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }
    function updateOrder(roomNo,itemNo,qty,type) {
        $scope.myVar = true;
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        formData.append('itemNo',itemNo);
        formData.append('qty',qty);
        formData.append('type',type);
        $http.post(url2+'/updateOrder',formData,{
            transformRequest: angular.identity,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':'*/*',
                'Content-type':undefined,
            },
            params:formData
        })
            .then(function successCallBack(response){

                if (response.data.status!='Success'){
                    $rootScope.itemListArr[itemNo] = false;
                    SOCKET.emit('changeOrderButton', { roomNo:roomNo,itemNo: itemNo,status: false});
                } else {
                    $rootScope.itemListArr[itemNo] = true;
                    $rootScope.itemListQuanArr[itemNo] = response.data.currQuan;
                    $rootScope.itemListPriceArr[itemNo] = response.data.currPrice;
                    // $rootScope.itemListQuanArr[itemNo] = $scope.itemList[x].orderCount;
                    SOCKET.emit('changeOrderButton', { roomNo:roomNo,itemNo: itemNo,status: true});
                }



                loadOrderCart(roomNo);

            }, function errorCallback(response) {})
            .then(function errorCallBack(response) {});
    }
    $('.orderButton')
        .popup({
            popup : $('.custom.popup'),
            on    : 'click'
        })
    ;
    function loadOrderCart(roomNo) {
        var formData = new FormData();
        formData.append('roomNo',roomNo);
        $http.post(url2+'/loadOrderCart',formData,{
            transformRequest: angular.identity,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':'*/*',
                'Content-type':undefined,
            },
            params:formData
        })
            .then(function successCallBack(response){

                // loadItemListByCategory("");
                $scope.isDisabled = false;
                $scope.myVar = false;
                $scope.OrderItemList = response.data.content;
                $scope.totalUnit = function(){
                    var total = 0;
                    for(var i = 0; i < $scope.OrderItemList.length; i++){
                        var product = $scope.OrderItemList[i];
                        total += parseFloat(product.unit_price);
                    }
                    return total;

                }
                $scope.OrderItemListlength = $scope.OrderItemList.length;

            }, function errorCallback(response) {})
            .then(function errorCallBack(response) {});
    }


    function loadMenuByClassification(){
        var formData = new FormData();
        formData.append('classification',"");
        $http.post(url2+'/loadMenuByClassification',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.menuListArr = response.data.content;

            }, function errorCallback(response) {})
            .then(function errorCallBack(response) {});
    }

    setTimeout(function(){
        $('#loading')
            .transition({
                animation  : 'scale',
                duration   : '1s',
                onComplete : function() {
                    $('#loading')
                        .transition({
                            animation  : 'scale',
                            duration   : '2s',
                            onComplete : function() {
                                $("#mainContent").removeClass("hidden");
                            }
                        })
                    ;
                }
            })
        ;
    },1000)

});

function PagerService() {
    // service definition
    var service = {};

    service.GetPager = GetPager;

    return service;

    // service implementation

}
function GetPager(totalItems, currentPage, pageSize) {
    // default to first page
    currentPage = currentPage || 1;

    // default page size is 10
    pageSize = pageSize || 10;

    // calculate total pages
    var totalPages = Math.ceil(totalItems / pageSize);

    var startPage, endPage;
    if (totalPages <= 10) {
        // less than 10 total pages so show all
        startPage = 1;
        endPage = totalPages;
    } else {
        // more than 10 total pages so calculate start and end pages
        if (currentPage <= 6) {
            startPage = 1;
            endPage = 10;
        } else if (currentPage + 4 >= totalPages) {
            startPage = totalPages - 9;
            endPage = totalPages;
        } else {
            startPage = currentPage - 5;
            endPage = currentPage + 4;
        }
    }

    // calculate start and end item indexes
    var startIndex = (currentPage - 1) * pageSize;
    var endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);

    // create an array of pages to ng-repeat in the pager control
    var pages = _.range(startPage, endPage + 1);

    // return object with all pager properties required by the view
    return {
        totalItems: totalItems,
        currentPage: currentPage,
        pageSize: pageSize,
        totalPages: totalPages,
        startPage: startPage,
        endPage: endPage,
        startIndex: startIndex,
        endIndex: endIndex,
        pages: pages
    };
}
function imgError(image){
    image.parentNode.parentNode.style.display = 'none';
}
function anonImg(image){
    image.src = '../img/noImage.png';
}

