// angular.module('MainApp', ['angularUtils.directives.dirPagination']);
// MainApp.factory('PagerService', PagerService);

MainApp.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});

MainApp.controller('homeController', function($http,$rootScope,$scope,$sce){
    //initialized default variables
    var url2 = $("#urlVal").val();
    var roomNo = $("#roomNo").val();
    var SOCKET = $().nodeConnect();
    SOCKET.emit('room_login', { uid: 'dashboard' });
    // alert("a");
    // loadGuestRequest();
    $scope.promoCodeGButton = false;

    $scope.removedGuestCheckOut = function(id){
        $('#RemoveCheckOut')
            .modal({
                closable  : false,
                onDeny    : function(){
                    // window.alert('Wait not yet!');
                    // return false;
                },
                onApprove : function() {
                    // alert('a');
                    var formData = new FormData();
                    formData.append('getid',id);
                    $http.post(url2+'/removeCheckOut',formData,{
                            transformRequest: angular.identity,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept':'*/*',
                                'Content-type':undefined,
                            },
                            params:formData
                        })
                        .then(function successCallBack(response){

                            loadGuestRequest();
                        }, function errorCallback(response) {})
                        .then(function errorCallBack(response){});
                }
            })
            .modal('show')
        ;
    }

    $scope.validateGuestPromoCode = function(id) {
        // alert("a");
        $scope.promoCodeGButton = true;
        var formData = new FormData();
        formData.append('promoCodeId',id);
        $http.post(url2+'/validateGuestPromoCode',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                alert(response.data.status);
                $scope.promoCodeGButton = false;


            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});


    }

    $scope.trustHtml = function(content) {
        // alert(content);
        return $sce.trustAsHtml(content);
    }
    jQuery('#guestOrderStartDate').datetimepicker({
        format:'Y/m/d',
        onShow:function( ct ){
            this.setOptions({
                maxDate:jQuery('#guestOrderEndDate').val()?jQuery('#guestOrderEndDate').val():false
            })
        },
        timepicker:false,
    });

    jQuery('#guestOrderEndDate').datetimepicker({
        format:'Y/m/d',
        minDate:0,
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('#guestOrderStartDate').val()?jQuery('#guestOrderStartDate').val():false
            })
        },
        timepicker:false
    });
    jQuery('#guestPromoStartDate').datetimepicker({
        format:'Y/m/d',
        onShow:function( ct ){
            this.setOptions({
                maxDate:jQuery('#guestPromoEndDate').val()?jQuery('#guestPromoEndDate').val():false
            })
        },
        timepicker:false,
    });

    jQuery('#guestPromoEndDate').datetimepicker({
        format:'Y/m/d',
        minDate:0,
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('#guestPromoStartDate').val()?jQuery('#guestPromoStartDate').val():false
            })
        },
        timepicker:false
    });
    jQuery('#employeeOrderStartDate').datetimepicker({
        format:'Y/m/d',
        onShow:function( ct ){
            this.setOptions({
                maxDate:jQuery('#employeeOrderEndDate').val()?jQuery('#employeeOrderEndDate').val():false
            })
        },
        timepicker:false,
    });

    jQuery('#employeeOrderEndDate').datetimepicker({
        format:'Y/m/d',
        minDate:0,
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('#employeeOrderStartDate').val()?jQuery('#employeeOrderStartDate').val():false
            })
        },
        timepicker:false
    });
    jQuery('#guestFeedbackStartDate').datetimepicker({
        format:'Y/m/d',
        onShow:function( ct ){
            this.setOptions({
                maxDate:jQuery('#guestFeedbackEndDate').val()?jQuery('#guestFeedbackEndDate').val():false
            })
        },
        timepicker:false,
    });

    jQuery('#guestFeedbackEndDate').datetimepicker({
        format:'Y/m/d',
        minDate:0,
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('#guestFeedbackStartDate').val()?jQuery('#guestFeedbackStartDate').val():false
            })
        },
        timepicker:false
    });
    var date = new Date();
    var month = date.getMonth()+1;
    var day = date.getDate();
    var year = date.getFullYear();
    if(month<10){
        month = "0"+month;
    }
    if(day<10){
        day = "0"+day;
    }
    jQuery('#guestPromoStartDate').val(year+"/"+month+"/"+day);
    jQuery('#guestPromoEndDate').val(year+"/"+month+"/"+day);

    jQuery('#guestOrderStartDate').val(year+"/"+month+"/"+day);
    jQuery('#guestOrderEndDate').val(year+"/"+month+"/"+day);

    jQuery('#employeeOrderStartDate').val(year+"/"+month+"/"+day);
    jQuery('#employeeOrderEndDate').val(year+"/"+month+"/"+day);

    jQuery('#guestFeedbackStartDate').val(year+"/"+month+"/"+day);
    jQuery('#guestFeedbackEndDate').val(year+"/"+month+"/"+day);


    $scope.removedGuestPromoCode = function(getid) {
        // alert(getid);
        $('#RemoveConfi')
            .modal({
                closable  : false,
                onDeny    : function(){
                    // window.alert('Wait not yet!');
                    // return false;
                },
                onApprove : function() {
                    var formData = new FormData();
                    formData.append('getid',getid);
                    $http.post(url2+'/removePromoCode',formData,{
                            transformRequest: angular.identity,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept':'*/*',
                                'Content-type':undefined,
                            },
                            params:formData
                        })
                        .then(function successCallBack(response){
                            if(response.data.status=="Failed"){
                                alert("Room already Checkout");
                            } else if(response.data.status=="Success") {

                            } else {
                                alert(response.data.status);
                            }
                            // $scope.guestRequest = response.data.guestRequest;
                            // var trigger = response.data.triggerSound;
                            //trigger = 0 alert
                            //trigger = 1 no alert
                            // if(trigger=="0"){
                            //     document.getElementById('AlertSound').play();
                            // }
                            loadGuestRequest();
                        }, function errorCallback(response) {})
                        .then(function errorCallBack(response){});
                }
            })
            .modal('show')
        ;


    }






    $scope.approvedGuestOrder = function(transno,controlno,roomno) {
        // alert(roomno);
        $('#approvedConfi')
            .modal({
                closable  : false,
                onDeny    : function(){
                    // window.alert('Wait not yet!');
                    // return false;
                },
                onApprove : function() {
                    var formData = new FormData();
                    formData.append('transno',transno);
                    formData.append('controlno',controlno);
                    formData.append('roomno',roomno);
                    $http.post(url2+'/approvedGuestOrder',formData,{
                            transformRequest: angular.identity,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept':'*/*',
                                'Content-type':undefined,
                            },
                            params:formData
                        })
                        .then(function successCallBack(response){
                            if(response.data.status=="Failed"){
                                alert("Room already Checkout");
                            } else if(response.data.status=="Success") {

                            } else {
                                alert(response.data.status);
                            }
                            // $scope.guestRequest = response.data.guestRequest;
                            // var trigger = response.data.triggerSound;
                            //trigger = 0 alert
                            //trigger = 1 no alert
                            // if(trigger=="0"){
                            //     document.getElementById('AlertSound').play();
                            // }
                            loadGuestRequest();
                        }, function errorCallback(response) {})
                        .then(function errorCallBack(response){});
                }
            })
            .modal('show')
        ;


    }


    $scope.disapprovedGuestOrder = function(transno,controlno,roomno) {
        // alert(roomno);
        $('#disapprovedConfi')
            .modal({
                closable  : false,
                onDeny    : function(){
                    // window.alert('Wait not yet!');
                    // return false;
                },
                onApprove : function() {
                    var formData = new FormData();
                    formData.append('transno',transno);
                    formData.append('controlno',controlno);
                    formData.append('roomno',roomno);
                    $http.post(url2+'/disapprovedGuestOrder',formData,{
                            transformRequest: angular.identity,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept':'*/*',
                                'Content-type':undefined,
                            },
                            params:formData
                        })
                        .then(function successCallBack(response){
                            if(response.data.status=="Failed"){
                                alert("Room already Checkout");
                            }
                            // $scope.guestRequest = response.data.guestRequest;
                            // var trigger = response.data.triggerSound;
                            //trigger = 0 alert
                            //trigger = 1 no alert
                            // if(trigger=="0"){
                            //     document.getElementById('AlertSound').play();
                            // }
                            loadGuestRequest();
                        }, function errorCallback(response) {})
                        .then(function errorCallBack(response){});
                }
            })
            .modal('show')
        ;


    }
    $scope.removeEmployeeOrder = function(transno,controlno,roomno) {
        // alert(roomno);
        $('#employeeRemoveConfi')
            .modal({
                closable  : false,
                onDeny    : function(){
                    // window.alert('Wait not yet!');
                    // return false;
                },
                onApprove : function() {
                    var formData = new FormData();
                    formData.append('transno',transno);
                    formData.append('controlno',controlno);
                    formData.append('roomno',roomno);
                    $http.post(url2+'/employeeRemoveOrder',formData,{
                            transformRequest: angular.identity,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept':'*/*',
                                'Content-type':undefined,
                            },
                            params:formData
                        })
                        .then(function successCallBack(response){
                            if(response.data.status=="Failed"){
                                alert("Room already Checkout");
                            }
                            // $scope.guestRequest = response.data.guestRequest;
                            // var trigger = response.data.triggerSound;
                            //trigger = 0 alert
                            //trigger = 1 no alert
                            // if(trigger=="0"){
                            //     document.getElementById('AlertSound').play();
                            // }
                            loadEmployeeOrder();
                        }, function errorCallback(response) {})
                        .then(function errorCallBack(response){});
                }
            })
            .modal('show')
        ;


    }

    loadGuestRequest();
    loadEmployeeOrder();
    loadFeedbacksRoom();
    // setInterval(, 5000);


    //Node
    SOCKET.on('refreshCashierDashboard', function (data) {
        // alert("a");
        // $scope.itemTitle = data.itemNo;
        loadGuestRequest();
        loadEmployeeOrder();
        // alert($scope.itemListArr[data.itemNo]);
    });
    //Node

    function loadGuestRequest()
    {
        // alert("A");
        var formData = new FormData();
        formData.append('roomNo','');
        $http.post(url2+'/loadGuestOrder',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.guestRequest = response.data.guestRequest;
                $scope.guestRequestPromoCode = response.data.guestRequestPromoCode;
                $scope.guestRequestCheckOut = response.data.guestRequestCheckOut;
                var trigger = response.data.triggerSound;
                //trigger = 0 alert
                //trigger = 1 no alert
                if(trigger=="0"){
                    document.getElementById('AlertSound').play();
                }
                // loadGuestRequest();
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }
    function loadEmployeeOrder()
    {
        // alert("A");
        var formData = new FormData();
        formData.append('roomNo','');
        $http.post(url2+'/loadEmployeeOrder',formData,{
                transformRequest: angular.identity,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':'*/*',
                    'Content-type':undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.employeeRequest = response.data.employeeRequest;
                var trigger = response.data.triggerSound;
                //trigger = 0 alert
                //trigger = 1 no alert
                if(trigger=="0"){
                    document.getElementById('AlertSound').play();
                }
                // loadGuestRequest();
            }, function errorCallback(response) {})
            .then(function errorCallBack(response){});
    }

    function loadFeedbacksRoom() {
        var formData = new FormData();
        formData.append('roomNo','');
        $http.post(url2+'/loadRoom',formData,{
            transformRequest: angular.identity,
            headers: {
                'X-Request-With': 'XMLHttpRequest',
                'Accept':'*/*',
                'Content-type':undefined,
            },
            params:formData
        })
            .then(function successCallBack(response){
                $scope.roomList = response.data.room;
                $("#guestRoomFeedbackCmbox").dropdown({onChange: function(value, text, $selectedItem) {
                    $scope.loadRoomTransactions();
                }});
            }, function errorCallBack(response) {})
            .then(function errorCallBack(response){});
    }

    $scope.loadRoomTransactions = function() {
        // alert("a");
        var roomNo = $("#guestRoomFeedbackCmbox").val();
        if(roomNo==""){

        } else {
            var formData = new FormData();
            formData.append('roomNo',roomNo);
            $http.post(url2+'/loadRoomTransaction',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
                .then(function successCallBack(response){
                    $scope.roomListGenerate = true;
                    $scope.roomGenerate = false;
                    $scope.roomsLastTransactions = response.data.rooms;

                }, function errorCallBack(response){});
        }
    }

    $scope.loadGuestFeedback = function(seriesId,roomNo,controlNo){
        var formData = new FormData();
        formData.append('seriesId',seriesId);
        formData.append('roomNo',roomNo);
        formData.append('controlNo',controlNo);
        $http.post(url2+'/loadGuestFeedback',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.roomListGenerate = false;
                $scope.roomGenerate = true;
                $scope.SeriesId = response.data.SeriesId;
                $scope.RoomNo = response.data.RoomNo;
                $scope.ControlNo = response.data.ControlNo;

                $scope.guestFeedbackRoom = response.data.Room;

                $scope.guestFeedbackServiceStar = response.data.ServiceStar;
                $scope.guestFeedbackServiceRemarks = response.data.ServiceRemarks;


                $scope.guestFeedbackRoomStar = response.data.RoomStar;
                $scope.guestFeedbackRoomRemarks = response.data.RoomRemarks;


                $scope.guestFeedbackFoodStar = response.data.FoodStar;
                $scope.guestFeedbackFoodRemarks = response.data.FoodRemarks;

                $scope.feedbackType = response.data.guestFeedType;
                $scope.feedbackRemarks = response.data.guestFeedRemarks;

                $("#guestTypeFeedbackCmbox").dropdown('set selected',response.data.guestFeedType);
                $("#guestSubTypeFeedbackCmbox").dropdown('set selected',response.data.guestFeedSubType);

                $('#serviceRating').rating({maxRating: 5});
                $('#serviceRating').rating('set rating',response.data.ServiceStar);
                $('#serviceRating').rating('disable');

                $('#roomRating').rating({maxRating: 5});
                $('#roomRating').rating('set rating',response.data.RoomStar);
                $('#roomRating').rating('disable');

                $('#foodRating').rating({maxRating: 5});
                $('#foodRating').rating('set rating',response.data.FoodStar);
                $('#foodRating').rating('disable');


            }, function errorCallBack(response){});

    }
    
    $scope.saveFeedbackRemarks = function(){
        var SeriesId = $scope.SeriesId;
        var ControlNo = $scope.ControlNo;
        var RoomNo = $scope.RoomNo;

        var getType = $("#guestTypeFeedbackCmbox").val();
        var getSubType = $("#guestSubTypeFeedbackCmbox").val();
        var getRemarks = $("#guestRemarksFeedback").val();

        var formData = new FormData();
        formData.append('seriesid',SeriesId);
        formData.append('roomno',RoomNo);
        formData.append('controlno',ControlNo);
        formData.append('feedType',getType);
        formData.append('feedSubType',getSubType);
        formData.append('feedRemarks',getRemarks);

        $http.post(url2+'/saveGuestFeedbackCashier',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                // location.reload();
                $scope.serviceButton = false;
            }, function errorCallBack(response){});

    }

    $scope.changeQuan = function(typee,getId){
        var getType = typee;
        var getId = getId;
        var formData = new FormData();
        formData.append('getType',getType);
        formData.append('getId',getId);

        $http.post(url2+'/changeQTYbyId',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                loadGuestRequest();
            }, function errorCallBack(response){});
    }
    
    $scope.openModal = function(id){
        $('#'+id)
            .modal('show')
        ;
    }
    $("#guestTypeFeedbackCmbox").dropdown({onChange: function(value, text, $selectedItem) {
        // alert("a");
        $scope.loadGuestFeedbackByTypeOrSubtype();
        // $scope.feedbackRemarks = "a";
        // $scope.$apply();
    }});
    $("#guestSubTypeFeedbackCmbox").dropdown({onChange: function(value, text, $selectedItem) {
        $scope.loadGuestFeedbackByTypeOrSubtype();
        // $scope.feedbackRemarks = "a";
        // $scope.$apply();
    }});

    $scope.loadGuestFeedbackByTypeOrSubtype = function () {

        var xtype = $("#guestTypeFeedbackCmbox").val();
        var xsubtype = $("#guestSubTypeFeedbackCmbox").val();

        var SeriesId = $scope.SeriesId;
        var ControlNo = $scope.ControlNo;
        var RoomNo = $scope.RoomNo;

        var formData = new FormData();
        formData.append('getType',xtype);
        formData.append('getSubtype',xsubtype);

        formData.append('seriesid',SeriesId);
        formData.append('roomno',RoomNo);
        formData.append('controlno',ControlNo);

        $http.post(url2+'/loadGuestFeedbackByTypeOrSubtype',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.feedbackRemarks = response.data.remarks;
            }, function errorCallBack(response){});


    }

    $scope.loadGuestOrderHistory = function() {
        var startDate = $("#guestOrderStartDate").val();
        var endDate = $("#guestOrderEndDate").val();

        var formData = new FormData();
        formData.append('startdate',startDate);
        formData.append('enddate',endDate);


        $http.post(url2+'/loadGuestOrderHistory',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.historyGuestOrder = response.data.content;
            }, function errorCallBack(response){});
    }
    $scope.loadGuestPromoCodeHistory = function() {
        var startDate = $("#guestPromoStartDate").val();
        var endDate = $("#guestPromoEndDate").val();

        var formData = new FormData();
        formData.append('startdate',startDate);
        formData.append('enddate',endDate);


        $http.post(url2+'/loadGuestPromoHistory',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.historyGuestPromo1 = response.data.content1;
                $scope.historyGuestPromo2 = response.data.content2;
                $scope.historyGuestPromo3 = response.data.content3;
            }, function errorCallBack(response){});
    }
    $scope.loadEmployeeOrderHistory = function() {
        var startDate = $("#employeeOrderStartDate").val();
        var endDate = $("#employeeOrderEndDate").val();

        var formData = new FormData();
        formData.append('startdate',startDate);
        formData.append('enddate',endDate);


        $http.post(url2+'/loadEmployeeOrderHistory',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.historyEmployeeOrder = response.data.content;
            }, function errorCallBack(response){});
    }

    $scope.loadGuestFeedbackHistory = function(){
        var startDate = $("#guestFeedbackStartDate").val();
        var endDate = $("#guestFeedbackEndDate").val();

        var formData = new FormData();
        formData.append('startdate',startDate);
        formData.append('enddate',endDate);


        $http.post(url2+'/loadGuestFeedbackHistory',formData,{
                transformRequest:angular.identity,
                headers: {
                    'X-Request-With' : 'XMLHttpRequest',
                    'Accept' : '*/*',
                    'Content-type' : undefined,
                },
                params:formData
            })
            .then(function successCallBack(response){
                $scope.historyGuestFeedback1 = response.data.content1;
                $scope.historyGuestFeedback2 = response.data.content2;
                $scope.historyGuestFeedback3 = response.data.content3;
            }, function errorCallBack(response){});
    }

    $scope.loadRoomFeedback = function(seriesid,roomno,controlno){
        $('#modalHistoryGuestFeedback')
            .modal('hide')
        ;
        $scope.loadGuestFeedback(seriesid,roomno,controlno);

    }

});


