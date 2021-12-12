const app = require('express')();
const http = require('http').Server(app);
const io = require('socket.io')(http, {
    cors: {
        origin: 'http://147.182.237.55:3000', //CHANGE THIS ORIGIN TO THE URL WHERE IT WAS DEPLOYED
        methods: ['GET', 'POST'],
    },
});
const port = process.env.PORT || 3000;

io.on('connection', (socket) => {
    socket.on('message_sent', () => {
        io.emit('message_sent');
    });
});

http.listen(port, () => {
    console.log(`Socket.IO server running at http://147.182.237.55:${port}/`);
});