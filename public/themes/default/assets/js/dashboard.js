// angular.module('MainApp', ['angularUtils.directives.dirPagination']);
MainApp.factory('PagerService', PagerService);
MainApp.controller('homeController', function($http,$rootScope,$scope,$sce){
    //initialized default variables
    var url2 = $("#urlVal").val();
    var roomNo = $("#roomNo").val();
    var SOCKET = $().nodeConnect();
    SOCKET.emit('room_login', { uid: roomNo });

    $scope.menuList = function(){
        $('#sideMenu')
            .transition('slide right')
        ;
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


