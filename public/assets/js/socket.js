const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const {Server} = require("socket.io")
const io = new Server(server,{
    cors:{
        origin:'*'
    }
});
global.io = io;
app.get('/qr', (req, res) => {
    let parCode = req.query.parcode;
    console.log(parCode);

  res.send('hello'+parCode);
  global.io.emit('qr', parCode);
});

io.on('connection', (socket) => {
  console.log('a user connected');
});

app.get('/', (req, res) => {
  res.send('<h1>Hello world</h1>');
});

server.listen(3000, () => {
  console.log('listening on *:3000');
});
