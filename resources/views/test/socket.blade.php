<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>测试socket</title>
</head>
<style>
    *{
        margin: 0px;
        padding: 0px;
    }
    .room{
        background: darkgray;
    }
</style>
<link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
<body>

<div id="app">
    <div class="room" v-bind:style="{ width:room_width,height:room_height}">
        <ul id="app">
            <li v-for="item in items">
                @{{ item }}
            </li>
        </ul>

    </div>
</div>

</body>
<script>
    /**
     * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
     * 其中端口为Gateway端口，即start_gateway.php指定的端口。
     * start_gateway.php 中需要指定websocket协议，像这样
     * $gateway = new Gateway(websocket://0.0.0.0:7272);
     */

    console.log('start');

    ws = new WebSocket("ws://112.74.51.187:7272");

    console.log('connect');

    // 服务端主动推送消息时会触发这里的onmessage
    ws.onmessage = function(e){

        console.log('on message');

        // json数据转换成js对象
        var data = eval("("+e.data+")");
        var type = data.type || '';
        switch(type){
            // Events.php中返回的init类型的消息，将client_id发给后台进行uid绑定
            case 'init':
                // 利用jquery发起ajax请求，将client_id发给后端进行uid绑定
                $.post('kucaroom.com/bind', {client_id: data.client_id}, function(data){}, 'json');
                break;
            // 当mvc框架调用GatewayClient发消息时直接alert出来
            default :
                alert(e.data);
        }
    };

</script>
</html>