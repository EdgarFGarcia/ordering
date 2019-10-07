// angular.module('MainApp', ['angularUtils.directives.dirPagination']);
MainApp.factory('PagerService', PagerService);
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
    $scope.itemTitle = "Menu";

    //load default data
    loadItemListByCategory("");
    loadOrderCart(roomNo);


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
        $("#orderCategory").addClass("hidden");
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
            $('.ui.long.modal')
                .modal('show')
            ;
        }
    }

    $scope.loadshow = function(id,menu) {
        // $('#sideMenu')
        //     .transition('slide right')
        // ;
        // $('#'+id).removeClass("hidden");
        // $('.menuOption').addClass("hidden");
        // if(id=="foodList") {
        //     $('#'+menu).removeClass("hidden");
        // }
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
    function loadItemListByCategory(param){
        if(param=="Menu"){param="";}
        $("#searchItem").val('');
        $scope.searchItem = '';
        var formData = new FormData();
        formData.append('category',param);
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
                    } else {
                        $rootScope.itemListArr[$scope.itemList[x].item_no] = false;
                    }

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
                        total += (product.unit_price);
                    }
                    return total;

                }
                $scope.OrderItemListlength = $scope.OrderItemList.length;

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
                            duration   : '1s',
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



