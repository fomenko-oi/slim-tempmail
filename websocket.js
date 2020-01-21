const server     = require('http').createServer(),
      io         = require('socket.io')(server),
      port       = 8000;
      amqp       = require('amqplib/callback_api')
;

console.log('SocketIO > listening on port ' + port);

io.on('connection', function (socket){
      console.log('user connected')
});

amqp.connect('amqp://rabbit:rabbit@rabbitmq', function(err, conn) {
      if (err) {
            console.log(err);
            return;
      }
      conn.createChannel(function(err, ch) {
            let queue = 'notifications';
            ch.consume(queue, function(message) {
                  console.log('consumed: %s', message.content);
                  let value = JSON.parse(message.content);

                  console.log('in queue received message', value)

                  io.emit(`email.${value.receiver}.${value.host}`, {value});
            }, {noAck: true});
      });
});

server.listen(port);
