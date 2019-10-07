(function($){

    $.fn.nodeConnect = function(){

        if(typeof io != "undefined"){
            var SOCKET_IO = "192.168.15.12:7788";//
            var SOCKET = io.connect(SOCKET_IO);
            return SOCKET;
        }
    }

})( jQuery );