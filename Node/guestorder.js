var express = require('express');
var Q = require('q');
var app = express();
var mysql = require('mysql');
var io = require('socket.io')(7788);
var clients = [];
var connection = mysql.createConnection({
    host     : 'localhost',
    user     : 'root',
    password : '1tdAutop1l0t'
});
function doQuery1(){
    var defered = Q.defer();
    connection.query('SELECT * FROM (SELECT order_sound FROM vc_rms.tbl_guest_promo_code WHERE order_sound = 0 ' +
        'UNION ALL SELECT order_sound FROM vc_rms.tbl_guest_order WHERE order_sound = 0 AND status = 1 ) table1   ' +
        '',defered.makeNodeResolver());
    // connection.query('SELECT * FROM hms.tblroom',defered.makeNodeResolver());
    return defered.promise;
}
io.sockets.on('connection', function (socket) {

    var offlineclients = {};
    socket.on('room_login', function(data){
        if(data.uid)
        {

            var obj = {uid: data.uid, socketid: socket.id};
            // clients[data.uid] = obj;
            clients.push(obj);
            console.log("---------------------------ONLINE USER------------------------------");
            console.log(clients);
            console.log("--------------------------------------------------------------------");

            if(data.uid in offlineclients){
                // console.log(clients);
                delete offlineclients[data.uid];
            }
//             socket.broadcast.emit('online_status',{ onlinestatus:true,userid:data.uid });
        }
    });
    socket.on('changeOrderButton', function (data) {
        var roomNo = data.roomNo;
        var itemNo = data.itemNo;
        var status = data.status;

        for(x=0;x<=clients.length-1;x++){
            var uid = clients[x].uid;
            var socketid = clients[x].socketid;
            if(roomNo==uid){
                // console.log({ roomNo:roomNo,itemNo: itemNo,status: status});
                try
                {
                    io.sockets.connected[socketid].volatile.emit('changeOrderButton', { roomNo:roomNo,itemNo: itemNo,status: status});
                }
                catch(Exception)
                {
                    // offlineclients[roomNo] = {uid: roomNo};
                }
            }
        }
        // if(roomNo in clients) {
        //     console.log(data);
        //     try
        //     {
        //         io.sockets.connected[clients[roomNo].socketid].emit('changeOrderButton', { roomNo:roomNo,itemNo: itemNo,status: status});
        //     }
        //     catch(Exception)
        //     {
        //         // offlineclients[roomNo] = {uid: roomNo};
        //     }
        // }
        // else{
        //     // offlineclients[roomNo] = {uid: roomNo};
        // }
    });
    socket.on('refreshCashierDashboard', function (data) {


        for(x=0;x<=clients.length-1;x++){
            var uid = clients[x].uid;
            var socketid = clients[x].socketid;
            if('dashboard'==uid){

                // console.log({ roomNo:roomNo,itemNo: itemNo,status: status});
                try
                {
                    io.sockets.connected[socketid].volatile.emit('refreshCashierDashboard', { });
                }
                catch(Exception)
                {
                    console.log("error");
                }
            }
        }
        // if(roomNo in clients) {
        //     console.log(data);
        //     try
        //     {
        //         io.sockets.connected[clients[roomNo].socketid].emit('changeOrderButton', { roomNo:roomNo,itemNo: itemNo,status: status});
        //     }
        //     catch(Exception)
        //     {
        //         // offlineclients[roomNo] = {uid: roomNo};
        //     }
        // }
        // else{
        //     // offlineclients[roomNo] = {uid: roomNo};
        // }
    });

    setInterval(function(){
        notifyTheCashier();
    }, 3000);
    function notifyTheCashier(){
	console.log('Cashier notified...');
        Q.all(doQuery1()).then(function(results){
            var query0 = JSON.stringify(results[0][0]);
            if(query0){
                for(x=0;x<=clients.length-1;x++){
                    var uid = clients[x].uid;
                    var socketid = clients[x].socketid;
                    if('dashboard'==uid){

                        // console.log({ roomNo:roomNo,itemNo: itemNo,status: status});
                        try
                        {
                            io.sockets.connected[socketid].volatile.emit('refreshCashierDashboard', { });
                        }
                        catch(Exception)
                        {
                            console.log("error");
                        }
                    }
                }
            }

            // socket.volatile.emit('runRefresh',query0);
            // console.log(JSON.stringify(results[0][0][0]+results[1][0][0]));
            // res.send(JSON.stringify(results[0][0][0].solution+results[1][0][0].solution));
            // Hint : your third query would go here
        });
    }


});
    
